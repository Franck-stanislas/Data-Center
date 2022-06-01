<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjetRepository::class)]
class Projet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $institule;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $objectifs;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $resultats;

    #[ORM\Column(type: 'float')]
    private $couts;

    #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: 'secteur_projet')]
    #[ORM\JoinColumn(nullable: false)]
    private $secteur;

    #[ORM\ManyToOne(targetEntity: Maturite::class, inversedBy: 'maturite_projet')]
    #[ORM\JoinColumn(nullable: false)]
    private $maturite;

    #[ORM\ManyToOne(targetEntity: Statut::class, inversedBy: 'statut_projet')]
    #[ORM\JoinColumn(nullable: false)]
    private $statut;

    #[ORM\ManyToOne(targetEntity: Financement::class, inversedBy: 'financement_projet')]
    #[ORM\JoinColumn(nullable: false)]
    private $financement;

    #[ORM\ManyToMany(targetEntity: Commune::class, inversedBy: 'projets')]
    private $commune;

    public function __construct()
    {
        $this->commune = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInstitule(): ?string
    {
        return $this->institule;
    }

    public function setInstitule(string $institule): self
    {
        $this->institule = $institule;

        return $this;
    }

    public function getObjectifs(): ?string
    {
        return $this->objectifs;
    }

    public function setObjectifs(?string $objectifs): self
    {
        $this->objectifs = $objectifs;

        return $this;
    }

    public function getResultats(): ?string
    {
        return $this->resultats;
    }

    public function setResultats(?string $resultats): self
    {
        $this->resultats = $resultats;

        return $this;
    }

    public function getCouts(): ?float
    {
        return $this->couts;
    }

    public function setCouts(float $couts): self
    {
        $this->couts = $couts;

        return $this;
    }

    public function getSecteur(): ?Categorie
    {
        return $this->secteur;
    }

    public function setSecteur(?Categorie $secteur): self
    {
        $this->secteur = $secteur;

        return $this;
    }

    public function getMaturite(): ?Maturite
    {
        return $this->maturite;
    }

    public function setMaturite(?Maturite $maturite): self
    {
        $this->maturite = $maturite;

        return $this;
    }

    public function getStatut(): ?Statut
    {
        return $this->statut;
    }

    public function setStatut(?Statut $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getFinancement(): ?Financement
    {
        return $this->financement;
    }

    public function setFinancement(?Financement $financement): self
    {
        $this->financement = $financement;

        return $this;
    }

    /**
     * @return Collection<int, Commune>
     */
    public function getCommune(): Collection
    {
        return $this->commune;
    }

    public function addCommune(Commune $commune): self
    {
        if (!$this->commune->contains($commune)) {
            $this->commune[] = $commune;
        }

        return $this;
    }

    public function removeCommune(Commune $commune): self
    {
        $this->commune->removeElement($commune);

        return $this;
    }
}
