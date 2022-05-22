<?php

namespace App\Entity;

use App\Repository\CommuneRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommuneRepository::class)]
class Commune
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $code_cec;

    #[ORM\Column(type: 'string', length: 255)]
    private $localite;

    #[ORM\Column(type: 'string', length: 255)]
    private $libelle;

    #[ORM\Column(type: 'string', length: 255)]
    private $code;

    #[ORM\ManyToOne(targetEntity: Region::class, inversedBy: 'code_cec')]
    #[ORM\JoinColumn(nullable: false)]
    private $code_region;

    #[ORM\ManyToOne(targetEntity: Arrondissement::class, inversedBy: 'code_cec')]
    #[ORM\JoinColumn(nullable: false)]
    private $code_ctd;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeCec(): ?int
    {
        return $this->code_cec;
    }

    public function setCodeCec(int $code_cec): self
    {
        $this->code_cec = $code_cec;

        return $this;
    }

    public function getLocalite(): ?string
    {
        return $this->localite;
    }

    public function setLocalite(string $localite): self
    {
        $this->localite = $localite;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getCodeRegion(): ?Region
    {
        return $this->code_region;
    }

    public function setCodeRegion(?Region $code_region): self
    {
        $this->code_region = $code_region;

        return $this;
    }

    public function getCodeCtd(): ?Arrondissement
    {
        return $this->code_ctd;
    }

    public function setCodeCtd(?Arrondissement $code_ctd): self
    {
        $this->code_ctd = $code_ctd;

        return $this;
    }
}
