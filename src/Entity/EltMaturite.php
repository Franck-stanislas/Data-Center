<?php

namespace App\Entity;

use App\Repository\EltMaturiteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EltMaturiteRepository::class)]
class EltMaturite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\ManyToOne(targetEntity: Maturite::class, inversedBy: 'eltMaturites')]
    #[ORM\JoinColumn(nullable: true)]
    private $id_maturite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getIdMaturite(): ?Maturite
    {
        return $this->id_maturite;
    }

    public function setIdMaturite(?Maturite $id_maturite): self
    {
        $this->id_maturite = $id_maturite;

        return $this;
    }
}
