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

    #[ORM\ManyToMany(targetEntity: EltMaturite::class, inversedBy: 'projets')]
    private $eltsMaturite;

    #[ORM\ManyToOne(targetEntity: Commune::class, inversedBy: 'projets')]
    #[ORM\JoinColumn(nullable: false)]
    private $commune;

    #[ORM\OneToMany(mappedBy: 'projet', targetEntity: Financement::class)]
    private $financements;


    public function __construct()
    {
        $this->eltsMaturite = new ArrayCollection();
        $this->financements = new ArrayCollection();
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

    public function getCommune(): ?Commune
    {
        return $this->commune;
    }

    public function setCommune(?Commune $commune): self
    {
        $this->commune = $commune;

        return $this;
    }

    /**
     * @return Collection<int, Financement>
     */
    public function getFinancements(): Collection
    {
        return $this->financements;
    }

    public function addFinancement(Financement $financement): self
    {
        if (!$this->financements->contains($financement)) {
            $this->financements[] = $financement;
            $financement->setProjet($this);
        }

        return $this;
    }

    public function removeFinancement(Financement $financement): self
    {
        if ($this->financements->removeElement($financement)) {
            // set the owning side to null (unless already changed)
            if ($financement->getProjet() === $this) {
                $financement->setProjet(null);
            }
        }

        return $this;
    }
}
