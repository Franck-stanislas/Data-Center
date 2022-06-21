<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Maturite;
use App\Entity\Projet;
use App\Entity\SearchData;
use App\Form\SearchForm;
use App\Repository\CategorieRepository;
use App\Repository\MaturiteRepository;
use App\Repository\ProjetRepository;
use App\Repository\RegionRepository;
use App\Repository\StatutRepository;
use App\Repository\UsersRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(Request $request, CategorieRepository $categorieRepository, MaturiteRepository $maturiteRepository, ProjetRepository $projetRepository, PaginatorInterface $paginator): Response
    {
        $projets = $projetRepository->findAllByIdDesc();
        $projet = $paginator->paginate(
            $projets,
            $request->query->getInt('page', 1),9
        ) ;

        $data = new SearchData();

        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $search = $projetRepository->findSearch($data);
            $projetSearch = $paginator->paginate(
                $search,
                $request->query->getInt('page', 1),9
            ) ;
            return $this->render('index/projectSearch.html.twig', compact('projetSearch'));

        }

        return $this->render('index/index.html.twig', [
            'categories' => $categorieRepository->findAll(),
            'maturites' => $maturiteRepository->findAll(),
            'projets' => $projet,
            'form' => $form->createView()
        ]);
    }

    #[Route('/projets', name: 'app_project_list')]
    public function listProject(Request $request, CategorieRepository $categorieRepository, StatutRepository $statut, ProjetRepository $projetRepository, MaturiteRepository $maturiteRepository, PaginatorInterface $paginator): Response
    {
        $projet = $projetRepository->findAll();

        $projets = $paginator->paginate(
            $projet,
            $request->query->getInt('page', 1),6
        ) ;

        return $this->render('index/list-project.html.twig', [
            'categories' => $categorieRepository->findAll(),
            'statuts' => $statut->findAll(),
            'projets' => $projets,
            'maturites' => $maturiteRepository->findAll()
        ]);
    }

    #[Route('/projects-list', name: 'app_projects_list')]
    public function listProjects(): Response
    {
        return $this->render('index/list-projects.html.twig');
    }

    #[Route('/projet/{id}/details', name: 'app_project_detail', methods: ['GET'])]
    public function detailProject(Projet $projet, CategorieRepository $categorieRepository, UsersRepository $usersRepository): Response
    {
        return $this->render('index/detail-project.html.twig', [
            'projet' => $projet,
            'categories' => $categorieRepository->findOneByProjet($projet),
            'users' => $usersRepository->findOneUserByProjet($projet)
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

    #[Route('/category/{id}/projets', name: 'app_category_detail', methods: ['GET'])]
    public function projetsCategory( Categorie $categorie, ProjetRepository $projetRepository, PaginatorInterface $paginator, Request $request): Response
    {

        $projet = $projetRepository->findProjetByCategory($categorie);

        $projets = $paginator->paginate(
            $projet,
            $request->query->getInt('page', 1),9
        ) ;

        return $this->render('index/category-project.html.twig', [
            'projets' => $projets,
            'categorie' => $categorie
        ]);
    }


    #[Route('/carte-projet', name: 'app_project_map')]
    public function mapProject(CategorieRepository $categorieRepository, StatutRepository $statut): Response
    {

        return $this->render('index/carte.html.twig');
    }
}
