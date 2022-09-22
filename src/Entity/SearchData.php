<?php
namespace App\Entity;

use App\Entity\Categorie;
use App\Entity\Maturite;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

class SearchData implements Translatable
{
    /*
     * @var string|null
     * @Gedmo\Translatable
     *
     */
    public $mot = '';

    /**
     * @var Maturite
     */
    public $maturites;

    /**
     * @var Categorie
     */
    public $categories;


    /**
     * @return string
     */
    public function getMot(): string
    {
        return $this->mot;
    }

    /**
     * @param string $mot
     */
    public function setMot(string $mot): void
    {
        $this->mot = $mot;
    }

    /**
     * @return \App\Entity\Maturite
     */
    public function getMaturite(): \App\Entity\Maturite
    {
        return $this->maturite;
    }

    /**
     * @param \App\Entity\Maturite $maturite
     */
    public function setMaturite(\App\Entity\Maturite $maturite): void
    {
        $this->maturite = $maturite;
    }

    /**
     * @return Categorie
     */
    public function getCategorie(): Categorie
    {
        return $this->categorie;
    }

    /**
     * @param Categorie $categorie
     */
    public function setCategorie(Categorie $categorie): void
    {
        $this->categorie = $categorie;
    }

    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }
}