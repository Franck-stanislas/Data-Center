<?php

namespace App\Controller\API;

use App\Entity\Maturite;
use App\Repository\ArrondissementRepository;
use App\Repository\CategorieRepository;
use App\Repository\MaturiteRepository;
use App\Repository\ProjetRepository;
use App\Repository\RegionRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/projects')]
class ProjectController extends AbstractController
{
    #[Route('/get-all', name: 'api_all_projects', methods: ['GET', 'POST'])]
    public function all(Request $request, ProjetRepository $projetRepository, CategorieRepository $categorieRepository,
        MaturiteRepository $maturiteRepository, PaginatorInterface $paginator): Response
    {
        $projet = $projetRepository->findAll();
        $projets = $paginator->paginate(
            $projet,
            1,
            30
        );
        return $this->json([
            "totalCount" => count($projet),
            "currentPage" => $projets->getCurrentPageNumber(),
            "numItemsPerPage" => $projets->getItemNumberPerPage(),
            "totalPages" => ceil($projets->getTotalItemCount() / $projets->getItemNumberPerPage()),
            "projets" => $projets->getItems(),
            "categories" => $categorieRepository->findAllWithProjectsCount(),
            "maturites" => $maturiteRepository->findAllWithProjetsCount()
        ], 200);
    }

    #[Route('/get-allByArron', name: 'api_all_arron_projects', methods: ['GET', 'POST'])]
    public function allArron(Request $request, ProjetRepository $projetRepository, CategorieRepository $categorieRepository,
                        MaturiteRepository $maturiteRepository, PaginatorInterface $paginator): Response
    {
        $projet = $projetRepository->findAllByArron();
        $projets = $paginator->paginate(
            $projet,
            1,
            30
        );
        return $this->json([
            "totalCount" => count($projet),
            "currentPage" => $projets->getCurrentPageNumber(),
            "numItemsPerPage" => $projets->getItemNumberPerPage(),
            "totalPages" => ceil($projets->getTotalItemCount() / $projets->getItemNumberPerPage()),
            "projets" => $projets->getItems(),
            "categories" => $categorieRepository->findAllByArronWithProjectsCount(),
            "maturites" => $maturiteRepository->findAllWithProjetsCount()
        ], 200);
    }


    #[Route('/get-allByRegion', name: 'api_all_region_projects', methods: ['GET', 'POST'])]
    public function allRegion(Request $request, ProjetRepository $projetRepository, CategorieRepository $categorieRepository,
                        MaturiteRepository $maturiteRepository, RegionRepository $regionRepository, PaginatorInterface $paginator): Response
    {
        $projet = $projetRepository->findAllByRegion();
        $projets = $paginator->paginate(
            $projet,
            1,
            30
        );
        return $this->json([
            "totalCount" => count($projet),
            "currentPage" => $projets->getCurrentPageNumber(),
            "numItemsPerPage" => $projets->getItemNumberPerPage(),
            "totalPages" => ceil($projets->getTotalItemCount() / $projets->getItemNumberPerPage()),
            "projets" => $projets->getItems(),
            "categories" => $categorieRepository->findAllByRegionWithProjectsCount(),
            "maturites" => $maturiteRepository->findAllWithProjetsCount(),
            "regions" => $regionRepository->findAllWithProjetsCount(),
        ], 200);
    }


    #[Route('/filters', name: 'api_filters_projects', methods: ['POST'])]
    public function filterProjects(Request $request, ProjetRepository $projetRepository, CategorieRepository $categorieRepository,
        MaturiteRepository $maturiteRepository, PaginatorInterface $paginator): Response
    {
        $projet = $projetRepository->findAll();
        $projets = $paginator->paginate(
            $projet,
            1,
            30
        );
        $data = json_decode($request->getContent(), true);
        if(!empty($data)) {
            $projet = $projetRepository->findAllByFilters(
                $data['activesMaturites'],
                $data['activesCategories'],
                $data['search'],
                (int) $data['region'] ?: null,
                (int) $data['departement'] ?: null,
                (int) $data['arrondissement'] ?: null
            );

            $projets = $paginator->paginate(
                $projet,
                $data['page'] ?: 1,
                30
            );
        }

        return $this->json([
            "totalCount" => count($projet),
            "currentPage" => $projets->getCurrentPageNumber(),
            "numItemsPerPage" => $projets->getItemNumberPerPage(),
            "totalPages" => ceil($projets->getTotalItemCount() / $projets->getItemNumberPerPage()),
            "products" => $projets->getItems(),
            "categories" => $categorieRepository->findAllByMaturitesWithProjectsCount($data['activesMaturites']),
            "maturites" => $maturiteRepository->findAllByCategoriesWithProjetsCount($data['activesCategories'])
        ], 200);
    }


    #[Route('/region-filters', name: 'api_filters_projects', methods: ['GET', 'POST'])]
    public function RegionFilterProjects(Request $request, ProjetRepository $projetRepository, CategorieRepository $categorieRepository,
                                   RegionRepository $regionRepository, MaturiteRepository $maturiteRepository, PaginatorInterface $paginator): Response
    {
        $projet = $projetRepository->findAll();
        $projets = $paginator->paginate(
            $projet,
            1,
            30
        );
        $data = json_decode($request->getContent(), true);
        if(!empty($data)) {
            $projet = $projetRepository->findAllByFilters(
                $data['activesMaturites'],
                $data['activesCategories'],
                $data['search'],
                $data['activesRegions'],
                (int) $data['departement'] ?: null,
                (int) $data['arrondissement'] ?: null
            );
            $projets = $paginator->paginate(
                $projet,
                $data['page'] ?: 1,
                30
            );
        }
      //  dd($regionRepository->findAllWithProjetsCount());

        return $this->json([
            "totalCount" => count($projet),
            "currentPage" => $projets->getCurrentPageNumber(),
            "numItemsPerPage" => $projets->getItemNumberPerPage(),
            "totalPages" => ceil($projets->getTotalItemCount() / $projets->getItemNumberPerPage()),
            "products" => $projets->getItems(),
            "categories" => $categorieRepository->findAllByArronWithProjectsCount(),
//            "maturites" => $maturiteRepository->findAllByCategoriesWithProjetsCount($data['activesCategories']),
            "regions" => $regionRepository->findAllWithProjetsCount($data['activesRegions'])
        ], 200);
    }



    #[Route('/print-projects', name: 'api_print_projects', methods: ['POST'])]
    public function printProjects(Request $request, ProjetRepository $projetRepository): Response
    {
        $projet = $projetRepository->findAll();
        $data = json_decode($request->getContent(), true);
        if(!empty($data)) {
            $projet = $projetRepository->findAllByFilters(
                $data['activesMaturites'],
                $data['activesCategories'],
                $data['search'],
                (int) $data['region'] ?: null,
                (int) $data['departement'] ?: null,
                (int) $data['arrondissement'] ?: null
            );
        }

        return $this->json($projet, 200);
    }

    #[Route('/by-region', name: 'api_projects_region', methods: ['GET'])]
    public function getProjectsCountByRegion(ProjetRepository $projetRepository, RegionRepository $regionRepository): Response {
        $projectsByArrondissements = $projetRepository->findProjetsWithRegionApi();
        /*$allRegions = array_map(function ($region) {
            return $region->getNom();
        }, $regionRepository->findAll());

        $regions = [];
        foreach ($projectsByArrondissements as $project) {
            // count projects by region
            $region = $project['region'];
            $count = $project['count'];
            $ville = $project['ville'];
            $institule = $project['institule'];
            $objectifs =$project['objectifs'];
            $couts = $project['couts'];
            $secteur = $project['secteur'];
            $maturite = $project['maturite'];
            $lat = $project['lat'];
            $lon = $project['lon'];

            if (!isset($regions[$region])) {
                $regions[$region] = [
                    "count" => $count,
                    "ville" => $ville,
                    "institule" => $institule,
                    "objectifs" => $objectifs,
                    "couts" => $couts,
                    "secteur" => $secteur,
                    "maturite" => $maturite,
                    "lat" => $lat,
                    "lon" => $lon,
                    "region" => $region
                ];
            } else {
                $regions[$region] = [
                    "count" => $regions[$region]["count"] + $count,
                    "ville" => $ville,
                    "institule" => $institule,
                    "objectifs" => $objectifs,
                    "couts" => $couts,
                    "secteur" => $secteur,
                    "maturite" => $maturite,
                    "lat" => $lat,
                    "lon" => $lon,
                    "region" => $region
                ];
            }
        }
        foreach ($allRegions as $region) {
            if (!isset($regions[$region])) {
                $regions[$region]["count"] = 0;
            }
        }*/

        return $this->json($projectsByArrondissements);
    }
    
    #[Route('/by-commune', name: 'api_projects_commune', methods: ['GET'])]
    public function getProjectsCountByCommune(ProjetRepository $projetRepository, ArrondissementRepository $arrondissementRepository, RegionRepository $regionRepository): Response {
        $projectsByCommune = $projetRepository->findCountProjetsByCommuneApi();

        return $this->json($projectsByCommune);
    }

    #[Route('/by-maturite', name: 'api_projects_maturite', methods: ['GET'])]
    public function getProjectsCountByMaturite(ProjetRepository $projetRepository, RegionRepository $regionRepository): Response {

        $projectByMaturite = $projetRepository->findCountProjetsByMaturiteApi();
        $allRegions = array_map(function ($region) {
            return $region->getNom();
        }, $regionRepository->findAll());

        foreach ($projectByMaturite as $project) {
            // count projects by region
            $region = $project['region'];
            $count = $project['count'];
            $lat = $project['lat'];
            $lon = $project['lon'];
            if (!isset($regions[$region])) {
                $regions[$region] = [
                    "count" => $count,
                    "lat" => $lat,
                    "lon" => $lon,
                    "region" => $region
                ];
            } else {
                $regions[$region] = [
                    "count" => $regions[$region]["count"] + $count,
                    "lat" => $lat,
                    "lon" => $lon,
                    "region" => $region
                ];
            }
        }
        foreach ($allRegions as $region) {
            if (!isset($regions[$region])) {
                $regions[$region]["count"] = 0;
            }
        }
        return $this->json($regions);
    }

}