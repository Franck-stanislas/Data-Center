<?php

namespace App\Entity;

use App\Repository\DepartementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepartementRepository::class)]
class Departement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $code_dept;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom_dept;

    #[ORM\ManyToOne(targetEntity: Region::class, inversedBy: 'code_dept')]
    #[ORM\JoinColumn(nullable: false)]
    private $code_region;

    #[ORM\OneToMany(mappedBy: 'code_dept', targetEntity: Arrondissement::class)]
    private $code_cec;

    public function __construct()
    {
        $this->code_cec = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeDept(): ?int
    {
        return $this->code_dept;
    }

    public function setCodeDept(int $code_dept): self
    {
        $this->code_dept = $code_dept;

        return $this;
    }

    public function getNomDept(): ?string
    {
        return $this->nom_dept;
    }

    public function setNomDept(string $nom_dept): self
    {
        $this->nom_dept = $nom_dept;

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
     * @return Collection<int, Arrondissement>
     */
    public function getCodeCec(): Collection
    {
        return $this->code_cec;
    }

    public function addCodeCec(Arrondissement $codeCec): self
    {
        if (!$this->code_cec->contains($codeCec)) {
            $this->code_cec[] = $codeCec;
            $codeCec->setCodeDept($this);
        }

        return $this;
    }

    public function removeCodeCec(Arrondissement $codeCec): self
    {
        if ($this->code_cec->removeElement($codeCec)) {
            // set the owning side to null (unless already changed)
            if ($codeCec->getCodeDept() === $this) {
                $codeCec->setCodeDept(null);
            }
        }

        return $this;
    }
}
