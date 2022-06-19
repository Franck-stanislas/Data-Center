<?php
namespace App\Entity;

use App\Entity\Categorie;
use App\Entity\Maturite;

class SearchData
{
    /*
     * @var string
     */
    public $mot = '';

    /**
    * @var Category[]
     */
    public $categories = [];

    /**
     * @var Maturite[]
     */
    public $maturites = [];

    /**
     * @return Category[]
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @param Category[] $categories
     */
    public function setCategories(array $categories): void
    {
        $this->categories = $categories;
    }

    /**
     * @return Maturite[]
     */
    public function getMaturites(): array
    {
        return $this->maturites;
    }

    /**
     * @param Maturite[] $maturites
     */
    public function setMaturites(array $maturites): void
    {
        $this->maturites = $maturites;
    }

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



}