<?php

namespace App\Entity;

use App\Repository\MaturiteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaturiteRepository::class)]
class Maturite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom_maturite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomMaturite(): ?string
    {
        return $this->nom_maturite;
    }

    public function setNomMaturite(string $nom_maturite): self
    {
        $this->nom_maturite = $nom_maturite;

        return $this;
    }
}
