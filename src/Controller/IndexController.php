<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Projet;
use App\Entity\SearchData;
use App\Form\SearchForm;
use App\Repository\CategorieRepository;
use App\Repository\FinancementRepository;
use App\Repository\MaturiteRepository;
use App\Repository\ProjetRepository;
use App\Repository\StatutRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
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
            $projetSearchCount = count($search);

            $projetSearch = $paginator->paginate(
                $search,
                $request->query->getInt('page', 1),9
            ) ;
            return $this->render('index/projectSearch.html.twig', compact('projetSearch', 'projetSearchCount'));

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

    #[Route('/regional-projects', name: 'app_regional_projects_list')]
    public function regionalProjets(): Response
    {
        return $this->render('index/regional-list-projects.html.twig');
    }

    #[Route('/communal-projects', name: 'app_arron_project_list')]
    public function arrondissementProjets(): Response
    {
        return $this->render('index/communal-list-projects.html.twig');
    }

    #[Route('/projet/{id}/details', name: 'app_project_detail', methods: ['GET'])]
    public function detailProject(Projet $projet, CategorieRepository $categorieRepository, UsersRepository $usersRepository): Response
    {
        if ($projet->getArrondissement()){
            $mapUrl = 'https://maps.google.com/maps?q='. urlencode($projet->getArrondissement()->getVille() . ', Cameroon') . '&t=&z=13&ie=UTF8&iwloc=&output=embed';
        }else{
            $mapUrl = 'https://maps.google.com/maps?q='. urlencode($projet->getRegion()->getVille() . ', Cameroon') . '&t=&z=13&ie=UTF8&iwloc=&output=embed';
        }
        return $this->render('index/detail-project.html.twig', [
            'projet' => $projet,
            'categories' => $categorieRepository->findOneByProjet($projet),
            'users' => $usersRepository->findOneUserByProjet($projet),
            'mapUrl' => $mapUrl
        ]);
    }

    #[Route('/category', name: 'app_project_category')]
    public function categoryProject(Request $request, CategorieRepository $categorieRepository, PaginatorInterface $paginator): Response
    {
        $categories = $categorieRepository->findAll();
        $categorieCount = count($categories);

        $categorie = $paginator->paginate(
            $categories,
            $request->query->getInt('page', 1),18
        ) ;
        return $this->render('index/category.html.twig', compact('categorie', 'categorieCount'));
    }

    #[Route('/category/{id}/projets', name: 'app_category_detail', methods: ['GET'])]
    public function projetsCategory( Categorie $categorie, ProjetRepository $projetRepository, PaginatorInterface $paginator, Request $request): Response
    {

        $projet = $projetRepository->findProjetByCategory($categorie);

        $projets = $paginator->paginate(
            $projet,
            $request->query->getInt('page', 1),30
        ) ;

        return $this->render('index/category-project.html.twig', [
            'projets' => $projets,
            'categorie' => $categorie
        ]);
    }

//    #[Route('/financement', name: '')]
//    public function financementProject(FinancementRepository $financementRepository): Response
//    {
//        $financements = $financementRepository->findBy([], ['nom'=>'ASC']);
//        return $this->render('layout/financementNavbar.html.twig', compact('financements'));
//    }

    #[Route('/about', name: 'app_project_about')]
    public function about():Response
    {
        return $this->render('index/about.html.twig');
    }

    #[Route('/change-locale/{locale}', name:'app_change_locale')]
    public function changeLocale($locale, Request $request)
    {
//        // On stocke la langue demandée dans la session
        $request->getSession()->set('_locale', $locale);

        // On revient sur la page précédente
        return $this->redirect($request->headers->get('referer'));

    }

}
