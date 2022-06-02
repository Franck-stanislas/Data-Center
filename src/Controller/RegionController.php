<?php

namespace App\Controller;

use App\Entity\Arrondissement;
use App\Entity\Departement;
use App\Entity\Maturite;
use App\Entity\Region;
use App\Repository\ArrondissementRepository;
use App\Repository\CategorieRepository;
use App\Repository\CommuneRepository;
use App\Repository\DepartementRepository;
use App\Repository\FinancementRepository;
use App\Repository\MaturiteRepository;
use App\Repository\RegionRepository;
use App\Repository\StatutRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

#[Route('/api')]
class RegionController extends AbstractController
{

    #[Route('/regions', name:'region_list', methods: ['GET'])]
    public function list(RegionRepository $regionRepository): Response
    {
        $regions = $regionRepository->findAll();
        return $this->json($regions, 200);
    }

    #[Route('/regions/{region<[0-9]+>}/departements', name:'departement_list', methods: ['GET'])]
    public function showDepartement(Region $region): Response
    {
        $departements = $region->getDepartements();

        return $this->json($departements, 200);
    }

    #[Route('/departements/{departement<[0-9]+>}/arrondissements', name:'arrondissement_list', methods: ['GET'])]
    public function showArrondissement(Departement $departement): Response
    {
        $arrondissements = $departement->getArrondissements();
        return $this->json($arrondissements, 200);
    }

    #[Route('/arrondissements/{arrondissement<[0-9]+>}/communes', name:'commune_list', methods: ['GET'])]
    public function showCommune(Arrondissement $arrondissement): Response
    {
        $communes = $arrondissement->getCommunes();

        return $this->json($communes, 200);
    }

    #[Route('/categories', name:'categorie_list', methods: ['GET'])]
    public function showCategorie(CategorieRepository $categorieRepository): Response
    {
        $categories = $categorieRepository->findAll();

        return $this->json($categories, 200);
    }

    #[Route('/status', name:'status_list', methods: ['GET'])]
    public function showStatus(StatutRepository $statutRepository): Response
    {
        $statuts = $statutRepository->findAll();

        return $this->json($statuts, 200);
    }

    #[Route('/maturite', name:'maturite_list', methods: ['GET'])]
    public function showMaturite(MaturiteRepository $maturiteRepository): Response
    {
        $maturites = $maturiteRepository->findAll();

        return $this->json($maturites, 200);
    }

    #[Route('/maturite/{maturite<[0-9]+>}/elts', name:'maturite_elts', methods: ['GET'])]
    public function showMaturiteElts(Maturite $maturite): Response
    {
        $elts = $maturite->getEltMaturites();

        return $this->json($elts, 200);
    }

    #[Route('/financements', name:'financement_list', methods: ['GET'])]
    public function showFinancements(FinancementRepository $financementRepository): Response
    {
        $financements = $financementRepository->findAll();

        return $this->json($financements, 200);
    }





}
