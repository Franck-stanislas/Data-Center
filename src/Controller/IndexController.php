<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('index/index.html.twig');
    }

    #[Route('/list-project', name: 'app_project_list')]
    public function listProject(): Response
    {
        return $this->render('index/list-project.html.twig');
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
