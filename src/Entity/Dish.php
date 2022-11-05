<?php

namespace App\Entity;

use App\Repository\DishRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\String\Slugger\SluggerInterface;

#[ORM\Entity(repositoryClass: DishRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity('slug')]
class Dish {

  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = NULL;

  #[ORM\Column(length: 255)]
  private ?string $name = NULL;

  #[ORM\Column(type: 'string', length: 255, unique: TRUE)]
  private $slug;

  #[ORM\ManyToMany(targetEntity: Breakfast::class, mappedBy: 'dishes')]
  private Collection $breakfasts;


  public function __construct() {
    $this->breakfasts = new ArrayCollection();
  }

  public function getId(): ?int {
    return $this->id;
  }

  public function __toString(): string {
    return $this->getName();
  }

  public function getName(): ?string {
    return $this->name;
  }

  public function setName(string $name): self {
    $this->name = $name;

    return $this;
  }

  /**
   * @return Collection<int, Breakfast>
   */
  public function getBreakfasts(): Collection {
    return $this->breakfasts;
  }

  public function addBreakfast(Breakfast $breakfast): self {
    if (!$this->breakfasts->contains($breakfast)) {
      $this->breakfasts->add($breakfast);
      $breakfast->addDish($this);
    }

    return $this;
  }

  public function removeBreakfast(Breakfast $breakfast): self {
    if ($this->breakfasts->removeElement($breakfast)) {
      $breakfast->removeDish($this);
    }

    return $this;
  }

  public function getSlug(): ?string {
    return $this->slug;
  }

  public function setSlug(string $slug): self {
    $this->slug = $slug;

    return $this;
  }

  public function computeSlug(SluggerInterface $slugger) {
    if (!$this->slug || '-' === $this->slug) {
      $this->slug = (string) $slugger->slug((string) $this)->lower();
    }
  }

}
