<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
class Review {

  const GRADES = [3 => 'Excellent', 2 => 'Good', 1 => 'Not good'];

  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = NULL;

  #[ORM\Column(length: 255)]
  private ?string $email = NULL;

  #[ORM\Column]
  private ?int $grade = NULL;

  #[ORM\ManyToOne(inversedBy: 'reviews')]
  #[ORM\JoinColumn(nullable: FALSE)]
  private ?Breakfast $breakfast = NULL;

  public function getId(): ?int {
    return $this->id;
  }

  public function getEmail(): ?string {
    return $this->email;
  }

  public function setEmail(string $email): self {
    $this->email = $email;

    return $this;
  }

  public function getGrade(): ?int {
    return $this->grade;
  }

  public function getGradeVerbose(): ?string {
    if ($this->grade === NULL) {
      return '';
    }

    if (isset(self::GRADES[$this->grade])) {
      return self::GRADES[$this->grade];
    }

    return '';
  }

  public function setGrade(int $grade): self {
    $this->grade = $grade;

    return $this;
  }

  public function getBreakfast(): ?Breakfast {
    return $this->breakfast;
  }

  public function setBreakfast(?Breakfast $breakfast): self {
    $this->breakfast = $breakfast;

    return $this;
  }

}
