<?php

namespace App\Entity;

use App\Repository\MaturiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToMany(mappedBy: 'id_maturite', targetEntity: EltMaturite::class)]
    private $eltMaturites;

    public function __construct()
    {
        $this->eltMaturites = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, EltMaturite>
     */
    public function getEltMaturites(): Collection
    {
        return $this->eltMaturites;
    }

    public function addEltMaturite(EltMaturite $eltMaturite): self
    {
        if (!$this->eltMaturites->contains($eltMaturite)) {
            $this->eltMaturites[] = $eltMaturite;
            $eltMaturite->setIdMaturite($this);
        }

        return $this;
    }

    public function removeEltMaturite(EltMaturite $eltMaturite): self
    {
        if ($this->eltMaturites->removeElement($eltMaturite)) {
            // set the owning side to null (unless already changed)
            if ($eltMaturite->getIdMaturite() === $this) {
                $eltMaturite->setIdMaturite(null);
            }
        }

        return $this;
    }
}
