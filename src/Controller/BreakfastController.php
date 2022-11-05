<?php

namespace App\Controller;

use App\Entity\Breakfast;
use App\Entity\Conference;
use App\Entity\Review;
use App\Form\ReviewFormType;
use App\Repository\BreakfastRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class BreakfastController extends AbstractController {

  private Environment $twig;

  private EntityManagerInterface $entityManager;

  public function __construct(Environment $twig, EntityManagerInterface $entityManager) {
    $this->twig = $twig;
    $this->entityManager = $entityManager;
  }

  #[Route('/', name: 'homepage')]
  #[Route('/breakfast', name: 'app_breakfast')]
  public function index(BreakfastRepository $breakfastRepository): Response {
    return $this->render('breakfast/index.html.twig', [
      'breakfasts' => $breakfastRepository->findAll(),
    ]);
  }

  #[Route('/breakfast_header', name: 'breakfast_header')]
  public function breakfastHeader(BreakfastRepository $breakfastRepository): Response {
    return new Response($this->twig->render('breakfast/header.html.twig',
      [
        'breakfasts' => $breakfastRepository->findAll(),
      ]));
  }

  #[Route('/breakfast/{slug}', name: 'breakfast')]
  public function show(Request $request, Breakfast $breakfast, NotifierInterface $notifier): Response {
    $review = new Review();
    $form = $this->createForm(ReviewFormType::class, $review);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $review->setBreakfast($breakfast);
      $this->entityManager->persist($review);
      $this->entityManager->flush();

      $notifier->send(new Notification('Thank you for the review.', ['browser']));

      return $this->redirectToRoute('breakfast', ['slug' => $breakfast->getSlug()]);
    }


    dump($form);
    return new Response($this->twig->render('breakfast/show.html.twig', [
      'breakfast' => $breakfast,
      'review_form' => $form->createView()
    ]));
  }

}
