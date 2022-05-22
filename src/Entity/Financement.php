<?php

namespace App\Entity;

use App\Repository\FinancementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FinancementRepository::class)]
class Financement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom_financement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFinancement(): ?string
    {
        return $this->nom_financement;
    }

    public function setNomFinancement(string $nom_financement): self
    {
        $this->nom_financement = $nom_financement;

        return $this;
    }
}
