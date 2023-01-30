<?php

namespace App\Controller;

use App\Entity\Financement;
use App\Entity\Projet;
use App\Entity\Statut;
use App\Entity\Users;
use App\Form\AddUserType;
use App\Form\EditUserType;
use App\Form\UserProfilType;
use App\Repository\FinancementRepository;
use App\Repository\ProjetRepository;
use App\Repository\RegionRepository;
use App\Repository\StatutRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\Translation\TranslatorInterface;


#[Route('/admin')]
class AdminController extends AbstractController
{
    public function __construct(FlashyNotifier $flashy, TranslatorInterface $translator)
    {
        $this->flashy = $flashy;
        $this->translator = $translator;
    }

    #[Route('/', name: 'admin')]
    public function index(FinancementRepository $financement, ProjetRepository $projetRepository, UsersRepository $usersRepository, StatutRepository $statutRepository, RegionRepository $regionRepository, Security $security): Response
    {
        $user = $security->getUser();

        if(in_array("ROLE_SUPER_ADMIN", $user->getRoles())) {
            $projet = $projetRepository->findAllByApprouve();
            $projetArchives = $projetRepository->findAllByEtat();
            $projetEnAttente = $projetRepository->findAllByEnAttente();
        } else {
            $projet = $projetRepository->findByUser($user->getId());
        }

        if(! $this->getUser()){
            $this->flashy->error('Vous devez vous connecté en tant qu\'administrateur au préalable!');
            return $this->redirectToRoute('login');
        }
        $projectsByArrondissements = $projetRepository->findCountProjetsByArrondissement();
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

        return $this->render('admin/index.html.twig',[
            'projets' => $projet,
            'archives' =>$projetArchives,
            'attente' =>$projetEnAttente,
            'users' => $usersRepository->findAll(),
            'statuts' => $statutRepository->findAllByApprouv(),
            'countByRegion' => $regions,
            'financements' =>$financement->findAll()
        ]);
    }

    #[Route('/profil/{id<[0-9]+>}', name: 'app_profil')]
    public function profil(Users $user, UsersRepository $usersRepository, Request $request): Response
    {
        if(! $this->getUser()){
            $this->flashy->error('Vous devez vous connecté en tant qu\'administrateur au préalable!');
            return $this->redirectToRoute('login');
        }
        $form = $this->createForm(UserProfilType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $usersRepository->add($user, true);

            $message = $this->translator->trans('Informations misent à jour');
            $this->flashy->success($message);
            return $this->redirectToRoute('admin');
        }

        return $this->renderForm('admin/profil.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/projets', name:'projet_list')]
    public function listProject(FinancementRepository $financementRepository, ProjetRepository $projetRepository, UsersRepository $usersRepository, StatutRepository $statutRepository, Security $security): Response
    {
        $user = $security->getUser();
        if(in_array("ROLE_SUPER_ADMIN", $user->getRoles())) {
            $projet = $projetRepository->findAllByArron();
            $projetregional = $projetRepository->findAllByRegion();
            $totalProjet = $projetRepository->findAll();
            $status = $statutRepository->findAll();
            $financements = $financementRepository->findAll();
        } else {
            $projet = $projetRepository->findByUser($user->getId());
            $status = $statutRepository->findByUser($user->getId());
            $financements = $financementRepository->findByUser($user->getId());
        }

//        dd($projetRepository->findAll());
        return $this->render('admin/projects/list.html.twig',[
            'projets' => $projet,
            'regional' =>$projetregional,
            'totalProjet' => $totalProjet,
            'users' => $usersRepository->findAll(),
            'statuts' => $status,
            'financements' => $financements
        ]);
    }

    #[Route('/projets-approuve', name:'projet_approuv_list')]
    public function ApprouvProjectLIst(FinancementRepository $financementRepository, ProjetRepository $projetRepository, UsersRepository $usersRepository, StatutRepository $statutRepository, Security $security): Response
    {
        $user = $security->getUser();
        if(in_array("ROLE_SUPER_ADMIN", $user->getRoles())) {
            $projet = $projetRepository->findAllByApprouve();
            $projetregional = $projetRepository->findAllApprouvByRegion();
            $projetArchives = $projetRepository->findAllByEtat();
            $status = $statutRepository->findAllByApprouv();
            $financements = $financementRepository->findAll();
        } else {
            $projet = $projetRepository->findByUserApprouvProject($user->getId());
            $status = $statutRepository->findByUserApprouv($user->getId());
            $financements = $financementRepository->findByUserApprouv($user->getId());
        }


        return $this->render('admin/projects/approuvProjectList.html.twig',[
            'projets' => $projet,
            'regional' =>$projetregional,
            'archives' =>$projetArchives,
            'users' => $usersRepository->findAll(),
            'statuts' => $status,
            'financements' => $financements
        ]);
    }


    #[Route('/projet/{id}', name: 'app_project_show', methods: ['GET'])]
    public function show(Projet $projet): Response
    {
        return $this->render('admin/projects/showProject.html.twig', [
            'projet' => $projet,
        ]);
    }
    #[Route('/projets-regional', name:'projet_list_regional')]
    public function regionalProject(FinancementRepository $financementRepository, ProjetRepository $projetRepository, UsersRepository $usersRepository, StatutRepository $statutRepository, Security $security): Response
    {
        $user = $security->getUser();
        if(in_array("ROLE_SUPER_ADMIN", $user->getRoles())) {
            $projet = $projetRepository->findAllByRegion();
            $status = $statutRepository->findAllByApprouv();
            $financements = $financementRepository->findAll();
        } else {
            $projet = $projetRepository->findByUser($user->getId());
            $status = $statutRepository->findByUser($user->getId());
            $financements = $financementRepository->findByUser($user->getId());
        }

//        dd($projetRepository->findAll());
        return $this->render('admin/projects/regional-list.html.twig',[
            'projets' => $projet,
            'users' => $usersRepository->findAll(),
            'statuts' => $status,
            'financements' => $financements
        ]);
    }



    #[Route('/projets-communal', name:'communal_projet_list')]
    public function communalProject(FinancementRepository $financementRepository, ProjetRepository $projetRepository, UsersRepository $usersRepository, StatutRepository $statutRepository, Security $security): Response
    {
        $user = $security->getUser();
        if(in_array("ROLE_SUPER_ADMIN", $user->getRoles())) {
            $projet = $projetRepository->findAllByArron();
            $status = $statutRepository->findAll();
            $financements = $financementRepository->findAll();
        } else {
            $projet = $projetRepository->findByUser($user->getId());
            $status = $statutRepository->findByUser($user->getId());
            $financements = $financementRepository->findByUser($user->getId());
        }

//        dd($projetRepository->findAll());
        return $this->render('admin/projects/communalProject.html.twig',[
            'projets' => $projet,
            'users' => $usersRepository->findAll(),
            'statuts' => $status,
            'financements' => $financements
        ]);
    }

    #[Route('/regional-approuv', name:'projet_approuv_regional')]
    public function regionalApprouvProject(FinancementRepository $financementRepository, ProjetRepository $projetRepository, UsersRepository $usersRepository, StatutRepository $statutRepository, Security $security): Response
    {
        $user = $security->getUser();
        if(in_array("ROLE_SUPER_ADMIN", $user->getRoles())) {
            $projet = $projetRepository->findAllApprouvByRegion();
            $status = $statutRepository->findAllByApprouv();
            $financements = $financementRepository->findAll();
        } else {
            $projet = $projetRepository->findByUserApprouvProject($user->getId());
            $status = $statutRepository->findByUserApprouv($user->getId());
            $financements = $financementRepository->findByUserApprouv($user->getId());
        }

//        dd($projetRepository->findAll());
        return $this->render('admin/projects/regionalApprouvList.html.twig',[
            'projets' => $projet,
            'users' => $usersRepository->findAll(),
            'statuts' => $status,
            'financements' => $financements
        ]);
    }



    #[Route('/communal-approuv', name:'communal_approuv_list')]
    public function communalApprouvProject(FinancementRepository $financementRepository, ProjetRepository $projetRepository, UsersRepository $usersRepository, StatutRepository $statutRepository, Security $security): Response
    {
        $user = $security->getUser();
        if(in_array("ROLE_SUPER_ADMIN", $user->getRoles())) {
            $projet = $projetRepository->findAllApprouvByArron();
            $status = $statutRepository->findAllByApprouv();
            $financements = $financementRepository->findAll();
        } else {
            $projet = $projetRepository->findByUserApprouvProject($user->getId());
            $status = $statutRepository->findByUserApprouv($user->getId());
            $financements = $financementRepository->findByUserApprouv($user->getId());
        }

//        dd($projetRepository->findAll());
        return $this->render('admin/projects/communalProjectApprouv.html.twig',[
            'projets' => $projet,
            'users' => $usersRepository->findAll(),
            'statuts' => $status,
            'financements' => $financements
        ]);
    }


    #[Route('/projets-archives', name:'projet_archives')]
    public function archiveProject(ProjetRepository $projetRepository, UsersRepository $usersRepository, Security $security): Response
    {
        $user = $security->getUser();

        if(in_array("ROLE_SUPER_ADMIN", $user->getRoles())) {
            $projet = $projetRepository->findAllByEtat();
        } else {
            $projet = $projetRepository->findByUser($user->getId());
        }

//        dd($projetRepository->findAll());
        return $this->render('admin/projects/archiveProjet.html.twig',[
            'projets' => $projet,
            'users' => $usersRepository->findAll(),
        ]);
    }

    #[Route('/rejected-projet', name:'rejected_project')]
    public function rejectedProject(ProjetRepository $projetRepository, UsersRepository $usersRepository, Security $security): Response
    {
        $user = $security->getUser();

        if(in_array("ROLE_SUPER_ADMIN", $user->getRoles())) {
            $projet = $projetRepository->findAllByReject();
        } else {
            $projet = $projetRepository->findByUserRejectProject($user->getId());
        }

        return $this->render('admin/projects/rejectedProject.html.twig',[
            'projets' => $projet,
            'users' => $usersRepository->findAll(),
        ]);
    }

    #[Route('/projets/{id}', name: 'app_projet_delete', methods: ['POST'])]
    public function projetDelete(Request $request, Projet $projet, ProjetRepository $projetRepository): Response
    {

        if ($this->isCsrfTokenValid('delete'.$projet->getId(), $request->request->get('_token'))) {
            $projetRepository->remove($projet, true);
            $message  = $this->translator->trans('Projet supprimé');
            $this->flashy->success($message);
        }

        return $this->redirectToRoute('projet_list', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/archives/{id<[0-9]+>}', name: 'app_projet_archive', methods: ['GET'])]
    public function projetArchive(Request $request, Projet $projet, ProjetRepository $projetRepository): Response
    {

       $projets = $projet->setEtat(1);
       $projetRepository->add($projets, true);
       $message  = $this->translator->trans('Catégorie modifié');
       $this->flashy->success($message);

        return $this->redirectToRoute('projet_list', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/approuve/{id<[0-9]+>}', name: 'app_projet_approuve', methods: ['GET'])]
    public function approuveProjet(Request $request, Projet $projet, ProjetRepository $projetRepository): Response
    {

        $projet = $projet->setApprouver(1);
        $projetRepository->add($projet, true);
        $message  = $this->translator->trans('Projet approuver');
        $this->flashy->success($message);

        return $this->redirectToRoute('projet_list', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/reject/{id<[0-9]+>}', name: 'app_projet_reject', methods: ['POST'])]
    public function rejectProjet(Request $request, Projet $projet, ProjetRepository $projetRepository, EntityManagerInterface $em): Response
    {

        if ($request->isMethod('POST')){
            $data = $request->request->all();

            if ($this->isCsrfTokenValid('project_rejected', $data['_token'])){
                $projet->setReject(1);
                $projet->setCommentaire($data['comments']);

                $projetRepository->add($projet, true);

            }
            $message  = $this->translator->trans('Projet rejeter');
            $this->flashy->success($message);
        }


        return $this->redirectToRoute('projet_list', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/statut/{id}', name:'projet_list_parameter')]
    public function listProjectByStatutParameter(FinancementRepository $financementRepository, Statut $statut, ProjetRepository $projetRepository, UsersRepository $usersRepository, StatutRepository $statutRepository): Response
    {
        $projet = $projetRepository->findAllByStatutParameter($statut);
        return $this->render('admin/projects/list.html.twig',[
            'projets' => $projet,
            'users' => $usersRepository->findAll(),
            'statuts' => $statutRepository->findAll(),
            'financements' => $financementRepository->findAll()
        ]);
    }

    #[Route('/financements/{id}', name:'projet_list_financement')]
    public function listProjectByFinancementParameter(FinancementRepository $financementRepository, Financement $financement, ProjetRepository $projetRepository, UsersRepository $usersRepository, StatutRepository $statutRepository): Response
    {
        $projet = $projetRepository->findAllByFinancementParameter($financement);
        return $this->render('admin/projects/list.html.twig',[
            'projets' => $projet,
            'users' => $usersRepository->findAll(),
            'statuts' => $statutRepository->findAll(),
            'financements' => $financementRepository->findAll()
        ]);
    }


    #[Route("/users", name:"utilisateurs")]
    public function usersList(UsersRepository $users)
    {

        return $this->render('admin/user/users.html.twig', [
            'users' => $users->findAll(),
        ]);
    }

    #[Route("/user/new", name:"new_user" , methods: ['GET', 'POST'])]
    public function usersAdd( UsersRepository $users, Request $request, UserPasswordHasherInterface $passwordHasher) : Response
    {
        $user = new Users();

        $form = $this->createForm(AddUserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // get plaintextPassword type by user
            $plaintextPassword =  $form['password']->getData() ;

            // dd($plaintextPassword);

            // hash the password (based on the security.yaml config for the $user class)
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);

            $users->add($user, true);
            $message  = $this->translator->trans('Utilisateur ajouté');
            $this->flashy->success($message);

            return $this->redirectToRoute('utilisateurs', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/user/userAdd.html.twig', [
            'users' => $user,
            'form' => $form,
        ]);
    }


    #[Route("/user/{id<[0-9]+>}/update", name:"modifier_utilisateur")]

    public function editUser(Users $user, UsersRepository $usersRepository, Request $request)
    {
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $usersRepository->add($user, true);

            $message  = $this->translator->trans('Utilisateur modifié avec succès');
            $this->flashy->primary($message);
            return $this->redirectToRoute('utilisateurs');
        }

        return $this->renderForm('admin/user/edituser.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/user/{id<[0-9]+>}', name: 'user_delete', methods: ['POST'])]
    public function delete(Request $request, Users $users, UsersRepository $usersRepository): Response
    {
        if(! $this->getUser()){
            $this->flashy->error('Vous devez vous connecté en tant qu\'administrateur au préalable!');
            return $this->redirectToRoute('login');
        }

        if ($this->isCsrfTokenValid('delete'.$users->getId(), $request->request->get('_token'))) {
            $usersRepository->remove($users, true);
            $message  = $this->translator->trans('Utilisateur supprimé');
            $this->flashy->success($message);
        }

        return $this->redirectToRoute('utilisateurs', [], Response::HTTP_SEE_OTHER);
    }



}
