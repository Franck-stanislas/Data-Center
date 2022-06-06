<?php

namespace App\Entity;

use App\Repository\FinancementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: FinancementRepository::class)]
class Financement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom_financement;

    #[ORM\ManyToMany(targetEntity: Maturite::class, mappedBy: 'financements'), Ignore]
    private $maturites;

    #[ORM\ManyToMany(targetEntity: Projet::class, mappedBy: 'financement'), Ignore]
    private $projets;

    public function __construct()
    {
        $this->maturites = new ArrayCollection();
        $this->projets = new ArrayCollection();
    }

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


    /**
     * @return Collection<int, Maturite>
     */
    public function getMaturites(): Collection
    {
        return $this->maturites;
    }

    public function addMaturite(Maturite $maturite): self
    {
        if (!$this->maturites->contains($maturite)) {
            $this->maturites[] = $maturite;
            $maturite->addFinancement($this);
        }

        return $this;
    }

    public function removeMaturite(Maturite $maturite): self
    {
        if ($this->maturites->removeElement($maturite)) {
            $maturite->removeFinancement($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Projet>
     */
    public function getProjets(): Collection
    {
        return $this->projets;
    }

    public function addProjet(Projet $projet): self
    {
        if (!$this->projets->contains($projet)) {
            $this->projets[] = $projet;
            $projet->addFinancement($this);
        }

        return $this;
    }

    public function removeProjet(Projet $projet): self
    {
        if ($this->projets->removeElement($projet)) {
            $projet->removeFinancement($this);
        }

        return $this;
    }
}
