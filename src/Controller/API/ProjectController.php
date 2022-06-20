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
        $data = json_decode($request->getContent(), true);
        if($data) {
            dd($data['maturites']);
            $projet = $projetRepository->findAllByMaturites($data['maturites']);
            $projets = $paginator->paginate(
                $projet,
                $data['page'] ?: 1,
                4
            );
        } else {
            $projet = $projetRepository->findAll();
            $projets = $paginator->paginate(
                $projet,
                1,
                4
            );
        }

        return $this->json([
            "totalCount" => $projets->getTotalItemCount(),
            "currentPage" => $projets->getCurrentPageNumber(),
            "numItemsPerPage" => $projets->getItemNumberPerPage(),
            "totalPages" => ceil($projets->getTotalItemCount() / $projets->getItemNumberPerPage()),
            "products" => $projets->getItems(),
            "categories" => $categorieRepository->findAllWithProjectsCount(),
            "maturites" => $maturiteRepository->findAllWithProjetsCount()
        ], 200);
    }
}