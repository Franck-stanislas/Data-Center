<?php

namespace App\Entity;

use App\Repository\ArrondissementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArrondissementRepository::class)]
class Arrondissement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $code_ctd;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom_ctd;

    #[ORM\ManyToOne(targetEntity: Departement::class, inversedBy: 'code_cec')]
    #[ORM\JoinColumn(nullable: false)]
    private $code_dept;

    #[ORM\ManyToOne(targetEntity: Region::class, inversedBy: 'code_cec')]
    #[ORM\JoinColumn(nullable: false)]
    private $code_region;

    #[ORM\OneToMany(mappedBy: 'code_ctd', targetEntity: Commune::class)]
    private $code_cec;

    public function __construct()
    {
        $this->code_cec = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeCtd(): ?int
    {
        return $this->code_ctd;
    }

    public function setCodeCtd(int $code_ctd): self
    {
        $this->code_ctd = $code_ctd;

        return $this;
    }

    public function getNomCtd(): ?string
    {
        return $this->nom_ctd;
    }

    public function setNomCtd(string $nom_ctd): self
    {
        $this->nom_ctd = $nom_ctd;

        return $this;
    }

    public function getCodeDept(): ?Departement
    {
        return $this->code_dept;
    }

    public function setCodeDept(?Departement $code_dept): self
    {
        $this->code_dept = $code_dept;

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

    /**
     * @return Collection<int, Commune>
     */
    public function getCodeCec(): Collection
    {
        return $this->code_cec;
    }

    public function addCodeCec(Commune $codeCec): self
    {
        if (!$this->code_cec->contains($codeCec)) {
            $this->code_cec[] = $codeCec;
            $codeCec->setCodeCtd($this);
        }

        return $this;
    }

    public function removeCodeCec(Commune $codeCec): self
    {
        if ($this->code_cec->removeElement($codeCec)) {
            // set the owning side to null (unless already changed)
            if ($codeCec->getCodeCtd() === $this) {
                $codeCec->setCodeCtd(null);
            }
        }

        return $this;
    }
}
