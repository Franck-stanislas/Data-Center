<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

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

    #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: 'secteur_projet'), Ignore]
    #[ORM\JoinColumn(nullable: true)]
    private $secteur;

    #[ORM\ManyToOne(targetEntity: Maturite::class, inversedBy: 'maturite_projet')]
    #[ORM\JoinColumn(nullable: false)]
    private $maturite;

    #[ORM\ManyToOne(targetEntity: Statut::class, inversedBy: 'statut_projet'), Ignore]
    #[ORM\JoinColumn(nullable: true)]
    private $statut;

    #[ORM\ManyToMany(targetEntity: EltMaturite::class, inversedBy: 'projets')]
    private $eltsMaturite;

    #[ORM\ManyToOne(targetEntity: Arrondissement::class, inversedBy: 'projets')]
    private $arrondissement;

    #[ORM\ManyToMany(targetEntity: Financement::class, inversedBy: 'projets'), Ignore]
    private $financement;


    public function __construct()
    {
        $this->eltsMaturite = new ArrayCollection();
        $this->financement = new ArrayCollection();
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


    /**
     * @return Collection<int, EltMaturite>
     */
    public function getEltsMaturite(): Collection
    {
        return $this->eltsMaturite;
    }

    public function addEltsMaturite(EltMaturite $eltsMaturite): self
    {
        if (!$this->eltsMaturite->contains($eltsMaturite)) {
            $this->eltsMaturite[] = $eltsMaturite;
        }

        return $this;
    }

    public function removeEltsMaturite(EltMaturite $eltsMaturite): self
    {
        $this->eltsMaturite->removeElement($eltsMaturite);

        return $this;
    }

    public function getArrondissement(): ?Arrondissement
    {
        return $this->arrondissement;
    }

    public function setArrondissement(?Arrondissement $arrondissement): self
    {
        $this->arrondissement = $arrondissement;

        return $this;
    }

    /**
     * @return Collection<int, Financement>
     */
    public function getFinancement(): Collection
    {
        return $this->financement;
    }

    public function addFinancement(Financement $financement): self
    {
        if (!$this->financement->contains($financement)) {
            $this->financement[] = $financement;
        }

        return $this;
    }

    public function removeFinancement(Financement $financement): self
    {
        $this->financement->removeElement($financement);

        return $this;
    }
}
