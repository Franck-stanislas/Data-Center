<?php

namespace App\Controller\API;

use App\Entity\Maturite;
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
//dd(ceil($projets->getTotalItemCount() / $projets->getItemNumberPerPage()));
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
        $projectsByArrondissements = $projetRepository->findCountProjetsByArrondissementApi();
        $allRegions = array_map(function ($region) {
            return $region->getNom();
        }, $regionRepository->findAll());

        $regions = [];
        foreach ($projectsByArrondissements as $project) {
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