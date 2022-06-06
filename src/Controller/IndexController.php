<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\ProjetRepository;
use App\Repository\StatutRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(CategorieRepository $categorieRepository, StatutRepository $statut): Response
    {
        return $this->render('index/index.html.twig', [
            'categories' => $categorieRepository->findAll(),
            'statuts' => $statut->findAll(),
        ]);
    }

    #[Route('/list-project', name: 'app_project_list')]
    public function listProject(CategorieRepository $categorieRepository, StatutRepository $statut, ProjetRepository $projetRepository): Response
    {
        return $this->render('index/list-project.html.twig', [
            'categories' => $categorieRepository->findAll(),
            'statuts' => $statut->findAll(),
            'projets' => $projetRepository->findAll()
        ]);
    }

    #[Route('/category', name: 'app_project_category')]
    public function categoryProject(Request $request, CategorieRepository $categorieRepository, PaginatorInterface $paginator): Response
    {
        $categories = $categorieRepository->findAll();

        $categorie = $paginator->paginate(
            $categories,
            $request->query->getInt('page', 1),9
        ) ;
        return $this->render('index/category.html.twig', compact('categorie'));
    }
}
