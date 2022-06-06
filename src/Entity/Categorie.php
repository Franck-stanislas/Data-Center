<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use App\Repository\ProjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[Vich\Uploadable]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom_categorie;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     */
    #[Vich\UploadableField(mapping: 'categorie_image', fileNameProperty: 'imageName')]
    #[Assert\Image(maxSize:"8M", mimeTypes: ['image/*'], mimeTypesMessage: "Mauvais type de fichier, format pris en charge  PNG|JPEG|JPG|*")]
    private ?File $imageFile = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $imageName;

    #[ORM\OneToMany(mappedBy: 'secteur', targetEntity: Projet::class, orphanRemoval: true), Ignore]
    private $projet;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     */
    #[Vich\UploadableField(mapping: 'icone', fileNameProperty: 'iconeName')]
    #[Assert\Image(maxSize:"1M", mimeTypes: ['image/svg+xml'], mimeTypesMessage: 'Veuilllez choisir une image SVG')]
    private ?File $iconeFile = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $iconeName;

    public function __construct()
    {
        $this->projet = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCategorie(): ?string
    {
        return $this->nom_categorie;
    }

    public function setNomCategorie(string $nom_categorie): self
    {
        $this->nom_categorie = $nom_categorie;

        return $this;
    }

    /**
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            // $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $iconeFile
     */
    public function setIconeFile(?File $iconeFile = null): void
    {
        $this->iconeFile = $iconeFile;

        if (null !== $iconeFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getIconeFile(): ?File
    {
        return $this->iconeFile;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return Collection<int, Projet>
     */
    public function getProjet(): Collection
    {
        return $this->projet;
    }

    public function addProjet(Projet $projet): self
    {
        if (!$this->projet->contains($projet)) {
            $this->projet[] = $projet;
            $projet->setSecteur($this);
        }

        return $this;
    }

    public function removeProjet(Projet $projet): self
    {
        if ($this->projet->removeElement($projet)) {
            // set the owning side to null (unless already changed)
            if ($projet->getSecteur() === $this) {
                $projet->setSecteur(null);
            }
        }

        return $this;
    }

    public function getIconeName(): ?string
    {
        return $this->iconeName;
    }

    public function setIconeName(?string $iconeName): self
    {
        $this->iconeName = $iconeName;

        return $this;
    }

//    public function getProjetNumber(ProjetRepository $projetRepository):float{
//
//        $total = 0;
//        foreach($this->getProjet() as $id=>$quantite){
//            $quantite = $projetRepository->find($id);
//            $total += $quantite;
//        }
//        return $total;
//    }
}
