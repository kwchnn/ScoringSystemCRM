<?php

namespace App\Entity;

use App\Repository\MobileOperatorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MobileOperatorRepository::class)]
class MobileOperator
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    private ?string $operator_name = null;

    #[ORM\Column]
    private ?int $score = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOperatorName(): ?string
    {
        return $this->operator_name;
    }

    public function setOperatorName(string $operator_name): self
    {
        $this->operator_name = $operator_name;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }
}
