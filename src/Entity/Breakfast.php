<?php

namespace App\Entity;

use App\Repository\BreakfastRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\String\Slugger\SluggerInterface;

#[ORM\Entity(repositoryClass: BreakfastRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity('slug')]
class Breakfast {

  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = NULL;

  #[ORM\Column(length: 255)]
  private ?string $name = NULL;

  #[ORM\Column(type: 'string', length: 255, unique: TRUE)]
  private string $slug;

  #[ORM\Column(type: 'datetime_immutable')]
  private ?\DateTimeImmutable $createdAt = NULL;

  /**
   * @var Collection<int, Dish>
   */
  #[ORM\ManyToMany(targetEntity: Dish::class, inversedBy: 'breakfasts')]
  private Collection $dishes;

  /**
   * @var Collection<int, Review>
   */
  #[ORM\OneToMany(mappedBy: 'breakfast', targetEntity: Review::class, orphanRemoval: true)]
  private Collection $reviews;

  public function __construct() {
    $this->dishes = new ArrayCollection();
    $this->reviews = new ArrayCollection();
  }

  public function __toString(): string {
    return (string) $this->getName();
  }

  public function getId(): ?int {
    return $this->id;
  }

  public function getName(): ?string {
    return $this->name;
  }

  public function setName(string $name): self {
    $this->name = $name;

    return $this;
  }

  public function getCreatedAt(): ?\DateTimeImmutable {
    return $this->createdAt;
  }

  #[ORM\PrePersist]
  public function setCreatedAt(): self {
    $this->createdAt = new \DateTimeImmutable();
    return $this;
  }

  /**
   * @return Collection<int, Dish>
   */
  public function getDishes(): Collection {
    return $this->dishes;
  }

  public function addDish(Dish $dish): self {
    if (!$this->dishes->contains($dish)) {
      $this->dishes->add($dish);
    }

    return $this;
  }

  public function removeDish(Dish $dish): self {
    $this->dishes->removeElement($dish);

    return $this;
  }

  public function getSlug(): ?string {
    return $this->slug;
  }

  public function setSlug(string $slug): self {
    $this->slug = $slug;

    return $this;
  }

  public function computeSlug(SluggerInterface $slugger): void {
    if (!$this->slug || '-' === $this->slug) {
      $this->slug = (string) $slugger->slug((string) $this)->lower();
    }
  }

  /**
   * @return Collection<int, Review>
   */
  public function getReviews(): Collection
  {
      return $this->reviews;
  }

  public function addReview(Review $review): self
  {
      if (!$this->reviews->contains($review)) {
          $this->reviews->add($review);
          $review->setBreakfast($this);
      }

      return $this;
  }

  public function removeReview(Review $review): self
  {
      if ($this->reviews->removeElement($review)) {
          // set the owning side to null (unless already changed)
          if ($review->getBreakfast() === $this) {
              $review->setBreakfast(null);
          }
      }

      return $this;
  }

}
