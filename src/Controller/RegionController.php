<?php

namespace App\Controller;

use App\Entity\Arrondissement;
use App\Entity\Departement;
use App\Entity\Region;
use App\Repository\ArrondissementRepository;
use App\Repository\CategorieRepository;
use App\Repository\CommuneRepository;
use App\Repository\DepartementRepository;
use App\Repository\RegionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function showDepartement(DepartementRepository $departementRepository, Region $region): Response
    {
        $departements = $departementRepository->findBy (['region_id'=>$region->getId()]);

        return $this->json($departements, 200);
    }

    #[Route('/departements/{departement<[0-9]+>}/arrondissements', name:'arrondissement_list', methods: ['GET'])]
    public function showArrondissement(ArrondissementRepository $arrondissementRepository, Departement $departement): Response
    {
        $arrondissements = $arrondissementRepository->findBy(['id' => $departement->getId()]);

        return $this->json($arrondissements, 200);
    }

    #[Route('/arrondissements/{arrondissement<[0-9]+>}/communes', name:'commune_list', methods: ['GET'])]
    public function showCommune(CommuneRepository $communeRepository, Arrondissement $arrondissement): Response
    {
        $communes = $communeRepository->findBy(['id' => $arrondissement->getId()]);

        return $this->json($communes, 200);
    }

}
