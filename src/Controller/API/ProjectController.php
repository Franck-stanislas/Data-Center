<?php

namespace App\Controller\API;

use App\Entity\Maturite;
use App\Repository\CategorieRepository;
use App\Repository\MaturiteRepository;
use App\Repository\ProjetRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/projects')]
class ProjectController extends AbstractController
{
    #[Route('/get-all', name: 'api_all_projects', methods: ['GET', 'POST'])]
    public function all(
        Request $request,
        ProjetRepository $projetRepository,
        CategorieRepository $categorieRepository,
        MaturiteRepository $maturiteRepository,
        PaginatorInterface $paginator
    ): Response {
        $projet = $projetRepository->findAll();
        $projets = $paginator->paginate(
            $projet,
            1,
            4
        );

        return $this->json([
            "totalCount" => count($projet),
            "currentPage" => $projets->getCurrentPageNumber(),
            "numItemsPerPage" => $projets->getItemNumberPerPage(),
            "totalPages" => ceil($projets->getTotalItemCount() / $projets->getItemNumberPerPage()),
            "products" => $projets->getItems(),
            "categories" => $categorieRepository->findAllWithProjectsCount(),
            "maturites" => $maturiteRepository->findAllWithProjetsCount()
        ], 200);
    }

    #[Route('/filters', name: 'api_filters_projects', methods: ['POST'])]
    public function filterProjects(
        Request $request,
        ProjetRepository $projetRepository,
        CategorieRepository $categorieRepository,
        MaturiteRepository $maturiteRepository,
        PaginatorInterface $paginator
    ): Response {
        $projet = $projetRepository->findAll();
        $projets = $paginator->paginate(
            $projet,
            1,
            4
        );
        $data = json_decode($request->getContent(), true);
        if(!empty($data)) {
            $projet = $projetRepository->findAllByFilters($data['activesMaturites'], $data['activesCategories'], $data['search']);
            $projets = $paginator->paginate(
                $projet,
                $data['page'] ?: 1,
                4
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
}