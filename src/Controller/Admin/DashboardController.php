<?php

namespace App\Controller\Admin;

use App\Entity\Breakfast;
use App\Entity\Dish;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController {

  /**
   * @Route("/admin", name="admin")
   */
  public function index(): Response {
    $routeBuilder = $this->container->get(AdminUrlGenerator::class);

    if (($routeBuilder instanceof AdminUrlGenerator) === FALSE) {
      throw new \Exception("AdminUrlGenerator missing");
    }

    $url = $routeBuilder->setController(BreakfastCrudController::class)
      ->generateUrl();
    return $this->redirect($url);
  }

  public function configureDashboard(): Dashboard {
    return Dashboard::new()
      ->setTitle('Breakfast');
  }

  public function configureMenuItems(): iterable {
    yield MenuItem::linktoRoute('Back to the website', 'fas fa-home', 'homepage');
    yield MenuItem::linkToCrud('Breakfasts', 'fas fa-map-marker-alt', Breakfast::class);
    yield MenuItem::linkToCrud('Dishes', 'fas fa-comments', Dish::class);
  }

}