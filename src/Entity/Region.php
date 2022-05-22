<?php

namespace App\Entity;

use App\Repository\RegionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegionRepository::class)]
class Region
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $code;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\OneToMany(mappedBy: 'code_region', targetEntity: Departement::class, orphanRemoval: true)]
    private $code_dept;

    #[ORM\OneToMany(mappedBy: 'code_region', targetEntity: Arrondissement::class)]
    private $code_ctd;

    #[ORM\OneToMany(mappedBy: 'code_region', targetEntity: Commune::class)]
    private $code_cec;

    public function __construct()
    {
        $this->code_dept = new ArrayCollection();
        $this->code_ctd = new ArrayCollection();
        $this->code_cec = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Departement>
     */
    public function getCodeDept(): Collection
    {
        return $this->code_dept;
    }

    public function addCodeDept(Departement $codeDept): self
    {
        if (!$this->code_dept->contains($codeDept)) {
            $this->code_dept[] = $codeDept;
            $codeDept->setCodeRegion($this);
        }

        return $this;
    }

    public function removeCodeDept(Departement $codeDept): self
    {
        if ($this->code_dept->removeElement($codeDept)) {
            // set the owning side to null (unless already changed)
            if ($codeDept->getCodeRegion() === $this) {
                $codeDept->setCodeRegion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Arrondissement>
     */
    public function getCodeCtd(): Collection
    {
        return $this->code_ctd;
    }

    public function addCodeCtd(Arrondissement $codeCtd): self
    {
        if (!$this->code_ctd->contains($codeCtd)) {
            $this->code_ctd[] = $codeCtd;
            $codeCtd->setCodeRegion($this);
        }

        return $this;
    }

    public function removeCodeCec(Arrondissement $codeCtd): self
    {
        if ($this->code_ctd->removeElement($codeCtd)) {
            // set the owning side to null (unless already changed)
            if ($codeCtd->getCodeRegion() === $this) {
                $codeCtd->setCodeRegion(null);
            }
        }

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
            $codeCec->setCodeRegion($this);
        }

        return $this;
    }
}
