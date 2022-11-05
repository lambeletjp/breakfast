<?php

namespace App\EntityListener;

use App\Entity\Dish;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

class DishEntityListener {

  private SluggerInterface $slugger;

  public function __construct(SluggerInterface $slugger) {
    $this->slugger = $slugger;
  }

  public function prePersist(Dish $dish, LifecycleEventArgs $event): void {
    $dish->computeSlug($this->slugger);
  }

  public function preUpdate(Dish $dish, LifecycleEventArgs $event): void {
    $dish->computeSlug($this->slugger);
  }

}
