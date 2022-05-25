<?php

namespace App\Controller;

use App\Entity\Region;
use App\Repository\CategorieRepository;
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

    #[Route('/departements', name:'departement_list', methods: ['GET'])]
    public function showDepartement(DepartementRepository $departementRepository, Region $region): Response
    {
        $region = new Region();
        $departements = $departementRepository->findBy(['id'=>$region->getId()]);


        return $this->json($departements, 200);
    }

}
