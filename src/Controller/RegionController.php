<?php

namespace App\Controller;

use App\Entity\Arrondissement;
use App\Entity\Departement;
use App\Entity\Maturite;
use App\Entity\Projet;
use App\Entity\Region;
use App\Repository\ArrondissementRepository;
use App\Repository\CategorieRepository;
use App\Repository\CommuneRepository;
use App\Repository\DepartementRepository;
use App\Repository\EltMaturiteRepository;
use App\Repository\FinancementRepository;
use App\Repository\MaturiteRepository;
use App\Repository\ProjetRepository;
use App\Repository\RegionRepository;
use App\Repository\StatutRepository;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

#[Route('/api')]
class RegionController extends AbstractController
{
    public function __construct(FlashyNotifier $flashy)
    {
        $this->flashy = $flashy;
    }

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

    #[Route('/maturite/{maturite<[0-9]+>}/financements', name:'financement_list', methods: ['GET'])]
    public function showFinancements(Maturite $maturite): Response
    {
        $financements = $maturite->getFinancements();

        return $this->json($financements, 200);
    }

    #[Route('/project/save', name:'project_save', methods: ['POST'])]
    public function saveProject(
        ProjetRepository $projectRepository,
        CommuneRepository $communeRepository,
        CategorieRepository $categorieRepository,
        StatutRepository $statutRepository,
        MaturiteRepository $maturiteRepository,
        FinancementRepository $financementRepository,
        EltMaturiteRepository $eltMaturiteRepository,
        Request $request): Response {
        // get data of request
        $data = json_decode($request->getContent(), true);
        $projet = new Projet();
        $projet->setCommune($communeRepository->find($data['commune']));
        $projet->setSecteur($categorieRepository->find($data['secteur']));
        $projet->setCouts($data['couts']);
        $projet->setResultats($data['resultats']);
        $projet->setObjectifs($data['objectifs']);
        $projet->setInstitule($data['institule']);
        $projet->setMaturite($maturiteRepository->find($data['maturite']));
        $projet->setStatut($statutRepository->find($data['status'][0]));
        foreach ($data['financements'] as $financement) {
            $projet->addFinancement($financementRepository->find($financement));
        }
        foreach ($data['eltsMaturite'] as $maturite) {
            $projet->addEltsMaturite($eltMaturiteRepository->find($maturite));
        }
        // save project
        $projectRepository->add($projet, true);
        $this->flashy->success('Nouvelle maturité ajoutée');
        return $this->json("ok", 200);
    }





}
