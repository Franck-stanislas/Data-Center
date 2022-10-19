<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

#[ORM\Entity(repositoryClass: ProjetRepository::class)]
class Projet implements Translatable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Gedmo\Translatable]
    #[ORM\Column(type: 'string', length: 255)]
    private $institule;

    #[Gedmo\Translatable]
    #[ORM\Column(type: 'text', nullable: true)]
    private $objectifs;

    #[Gedmo\Translatable]
    #[ORM\Column(type: 'text', nullable: true)]
    private $resultats;

    #[ORM\Column(type: 'float')]
    private $couts;

    #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: 'secteur_projet')]
    #[ORM\JoinColumn(nullable: true)]
    private $secteur;

    #[ORM\ManyToOne(targetEntity: Maturite::class, inversedBy: 'maturite_projet')]
    #[ORM\JoinColumn(nullable: false)]
    private $maturite;

    #[ORM\ManyToOne(targetEntity: Statut::class, inversedBy: 'statut_projet'), Ignore]
    #[ORM\JoinColumn(nullable: true)]
    private $statut;

    #[ORM\ManyToMany(targetEntity: EltMaturite::class, inversedBy: 'projets'), Ignore]
    private $eltsMaturite;

    #[ORM\ManyToOne(targetEntity: Arrondissement::class, inversedBy: 'projets')]
    private $arrondissement;

    #[ORM\ManyToMany(targetEntity: Financement::class, inversedBy: 'projets'), Ignore]
    private $financement;

    #[ORM\ManyToOne(targetEntity: Users::class, inversedBy: 'projets')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\Column(type: 'float', nullable: true)]
    private $lng;

    #[ORM\Column(type: 'float', nullable: true)]
    private $lat;

    #[Gedmo\Translatable]
    #[ORM\Column(type: 'text', nullable: true)]
    private $caracteristique;

    #[Gedmo\Translatable]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $marche;

    #[Gedmo\Translatable]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $supply;

    #[Gedmo\Translatable]
    #[ORM\Column(type: 'text', nullable: true)]
    private $atouts;

    #[Gedmo\Translatable]
    #[ORM\Column(type: 'text', nullable: true)]
    private $valeurAjouter;

    #[Gedmo\Translatable]
    #[ORM\Column(type: 'text', nullable: true)]
    private $eligibilite;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $etat;

    #[ORM\ManyToOne(targetEntity: Region::class, inversedBy: 'projets')]
    private $region;

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

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getLng(): ?float
    {
        return $this->lng;
    }

    public function setLng(?float $lng): self
    {
        $this->lng = $lng;

        return $this;
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(?float $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getCaracteristique(): ?string
    {
        return $this->caracteristique;
    }

    public function setCaracteristique(?string $caracteristique): self
    {
        $this->caracteristique = $caracteristique;

        return $this;
    }

    public function getMarche(): ?string
    {
        return $this->marche;
    }

    public function setMarche(?string $marche): self
    {
        $this->marche = $marche;

        return $this;
    }

    public function getSupply(): ?string
    {
        return $this->supply;
    }

    public function setSupply(?string $supply): self
    {
        $this->supply = $supply;

        return $this;
    }

    public function getAtouts(): ?string
    {
        return $this->atouts;
    }

    public function setAtouts(?string $atouts): self
    {
        $this->atouts = $atouts;

        return $this;
    }

    public function getValeurAjouter(): ?string
    {
        return $this->valeurAjouter;
    }

    public function setValeurAjouter(?string $valeurAjouter): self
    {
        $this->valeurAjouter = $valeurAjouter;

        return $this;
    }

    public function getEligibilite(): ?string
    {
        return $this->eligibilite;
    }

    public function setEligibilite(?string $eligibilite): self
    {
        $this->eligibilite = $eligibilite;

        return $this;
    }

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

//    public function setTranslatableLocale($locale)
//    {
//        $this->locale = $locale;
//    }

public function getRegion(): ?Region
{
    return $this->region;
}

public function setRegion(?Region $region): self
{
    $this->region = $region;

    return $this;
}
}
