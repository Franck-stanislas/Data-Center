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
use App\Repository\UsersRepository;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/api')]
class RegionController extends AbstractController
{
    public function __construct(FlashyNotifier $flashy, TranslatorInterface $translator)
    {
        $this->flashy = $flashy;
        $this->translation = $translator;
    }

    #[Route('/regions', name: 'region_list', methods: ['GET'])]
    public function list(RegionRepository $regionRepository): Response
    {
        $regions = $regionRepository->findAll();
        return $this->json($regions, 200);
    }

    #[Route('/regions/{region<[0-9]+>}/departements', name: 'departement_list', methods: ['GET'])]
    public function showDepartement(Region $region): Response
    {
        $departements = $region->getDepartements();

        return $this->json($departements, 200);
    }

    #[Route('/departements/{departement<[0-9]+>}/arrondissements', name: 'arrondissement_list', methods: ['GET'])]
    public function showArrondissement(Departement $departement): Response
    {
        $arrondissements = $departement->getArrondissements();
        return $this->json($arrondissements, 200);
    }

    #[Route('/arrondissements/{arrondissement<[0-9]+>}/communes', name: 'commune_list', methods: ['GET'])]
    public function showCommune(Arrondissement $arrondissement): Response
    {
        $communes = $arrondissement->getCommunes();

        return $this->json($communes, 200);
    }

    #[Route('/categories', name: 'categorie_list', methods: ['GET'])]
    public function showCategorie(CategorieRepository $categorieRepository): Response
    {
        $categories = $categorieRepository->findAll();

        return $this->json($categories, 200);
    }

    #[Route('/status', name: 'status_list', methods: ['GET'])]
    public function showStatus(StatutRepository $statutRepository): Response
    {
        $statuts = $statutRepository->findAll();

        return $this->json($statuts, 200);
    }

    #[Route('/maturite', name: 'maturite_list', methods: ['GET'])]
    public function showMaturite(MaturiteRepository $maturiteRepository): Response
    {
        $maturites = $maturiteRepository->findAll();

        return $this->json($maturites, 200);
    }

    #[Route('/maturite/{maturite<[0-9]+>}/elts', name: 'maturite_elts', methods: ['GET'])]
    public function showMaturiteElts(Maturite $maturite): Response
    {
        $elts = $maturite->getEltMaturites();

        return $this->json($elts, 200);
    }

    #[Route('/maturite/{maturite<[0-9]+>}/financements', name: 'financement_list', methods: ['GET'])]
    public function showFinancements(Maturite $maturite): Response
    {
        $financements = $maturite->getFinancements();

        return $this->json($financements, 200);
    }

    #[Route('/project/save', name: 'project_save', methods: ['POST'])]
    public function saveProject( ProjetRepository $projectRepository, ArrondissementRepository $arrondissementRepository, CategorieRepository $categorieRepository, StatutRepository $statutRepository,
        MaturiteRepository       $maturiteRepository, FinancementRepository $financementRepository,
        EltMaturiteRepository    $eltMaturiteRepository, Security $security, Request $request): Response
    {
        // get data of request
        $data = json_decode($request->getContent(), true);
        $projet = new Projet();
        $projet->setArrondissement($arrondissementRepository->find($data['arrondissement']));
        $projet->setSecteur($categorieRepository->find($data['secteur']));
        $projet->setCouts($data['couts']);
        $projet->setResultats($data['resultats']);
        $projet->setObjectifs($data['objectifs']);
        $projet->setInstitule($data['institule']);
        $projet->setCaracteristique($data['caracteristique']);
        $projet->setMarche($data['marche']);
        $projet->setSupply($data['supply']);
        $projet->setAtouts($data['atouts']);
        $projet->setValeurAjouter($data['valeur_ajouter']);
        $projet->setEligibilite($data['eligibilite']);
        $projet->setMaturite($maturiteRepository->find($data['maturite']));
        $projet->setStatut($statutRepository->find($data['status']));
        $projet->setUser($security->getUser());
        foreach ($data['financements'] as $financement) {
            $projet->addFinancement($financementRepository->find($financement));
        }
        foreach ($data['eltsMaturite'] as $maturite) {
            $projet->addEltsMaturite($eltMaturiteRepository->find($maturite));
        }
        // save project
        $projectRepository->add($projet, true);
        $message  = $this->translation->trans('Projet enregistré');
        $this->flashy->success($message);
        $this->redirectToRoute('admin');
        return $this->json("ok", 200);
    }

    #[Route('/project/edit', name: 'project_api_edit', methods: ['POST'])]
    public function editProject(
        ProjetRepository         $projectRepository,
        ArrondissementRepository $arrondissementRepository,
        CategorieRepository      $categorieRepository,
        StatutRepository         $statutRepository,
        MaturiteRepository       $maturiteRepository,
        FinancementRepository    $financementRepository,
        EltMaturiteRepository    $eltMaturiteRepository,
        Security                 $security,
        UsersRepository          $usersRepository,
        Request                  $request): Response
    {
        // get data of request
        $data = json_decode($request->getContent(), true);
        $projet = new Projet();
        $projet->setArrondissement($arrondissementRepository->find($data['arrondissement']));
        $projet->setSecteur($categorieRepository->find($data['secteur']));
        $projet->setCouts($data['couts']);
        $projet->setResultats($data['resultats']);
        $projet->setObjectifs($data['objectifs']);
        $projet->setInstitule($data['institule']);
        $projet->setCaracteristique($data['caracteristique']);
        $projet->setMarche($data['marche']);
        $projet->setSupply($data['supply']);
        $projet->setAtouts($data['atouts']);
        $projet->setValeurAjouter($data['valeur_ajouter']);
        $projet->setEligibilite($data['eligibilite']);
        $projet->setMaturite($maturiteRepository->find($data['maturite']));
        $projet->setStatut($statutRepository->find($data['status']));
        $projet->setUser($usersRepository->findOneBy(["id" => $data['user_id']]));
        foreach ($data['financements'] as $financement) {
            $projet->addFinancement($financementRepository->find($financement));
        }
        foreach ($data['eltsMaturite'] as $maturite) {
            $projet->addEltsMaturite($eltMaturiteRepository->find($maturite));
        }
        // save project
        $projectRepository->add($projet, true);

        $message  = $this->translation->trans('Projet modifié');
        $this->flashy->primary($message);
        $this->redirectToRoute('admin');
        return $this->json("ok", 200);
    }

    // get all projects
    #[Route('/projects', name: 'project_list', methods: ['GET'])]
    public function listProject(ProjetRepository $projectRepository, RegionRepository $regionRepository): Response
    {

        $projectsByArrondissements = $projectRepository->findCountProjetsByArrondissement();
        $allRegions = array_map(function ($region) {
            return $region->getNom();
        }, $regionRepository->findAll());

        $regions = [];
        foreach ($projectsByArrondissements as $project) {
            // count projects by region
            $region = $project['region'];
            $count = $project['count'];
            if (!isset($regions[$region])) {
                $regions[$region] = $count;
            } else {
                $regions[$region] += $count;
            }
        }
        foreach ($allRegions as $region) {
            if (!isset($regions[$region])) {
                $regions[$region] = 0;
            }
        }

        $projects = $projectRepository->findAll();

        // serialize projects
        $encoders = [new JsonEncoder()];
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return null;
            },
        ];
        $normalizers = [new ObjectNormalizer(null, null, null, null, null, null, $defaultContext)];
        $serializer = new Serializer($normalizers);
        $result = $serializer->normalize($projects, null, [AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true]);

        dd($result);

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);

        dd($serializer->serialize($projects, 'json'));

        return $this->json($projects, 200);
    }

}
