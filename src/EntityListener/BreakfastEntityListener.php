<?php

namespace App\EntityListener;

use App\Entity\Breakfast;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

class BreakfastEntityListener {

  private $slugger;

  public function __construct(SluggerInterface $slugger) {
    $this->slugger = $slugger;
  }

  public function prePersist(Breakfast $breakfast, LifecycleEventArgs $event) {
    $breakfast->computeSlug($this->slugger);
  }

  public function preUpdate(Breakfast $breakfast, LifecycleEventArgs $event) {
    $breakfast->computeSlug($this->slugger);
  }

}
