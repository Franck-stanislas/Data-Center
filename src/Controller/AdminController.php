<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\AddUserType;
use App\Form\EditUserType;
use App\Repository\UsersRepository;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;



#[Route('/admin')]
class AdminController extends AbstractController
{
    public function __construct(FlashyNotifier $flashy)
    {
        $this->flashy = $flashy;
    }

    #[Route('/', name: 'admin')]
    public function index(): Response
    {
        if(! $this->getUser()){
            $this->flashy->error('Vous devez vous connecté en tant qu\'administrateur au préalable!');
            return $this->redirectToRoute('login');
        }
        return $this->render('admin/index.html.twig');
    }

    #[Route('/profil', name: 'app_profil')]
    public function profil(): Response
    {
        if(! $this->getUser()){
            $this->flashy->error('Vous devez vous connecté en tant qu\'administrateur au préalable!');
            return $this->redirectToRoute('login');
        }
        return $this->render('admin/profil.html.twig');
    }


    #[Route("/utilisateurs", name:"utilisateurs")]
    public function usersList(UsersRepository $users)
    {

        return $this->render('admin/user/users.html.twig', [
            'users' => $users->findAll(),
        ]);
    }

    #[Route("/utilisateurs/new", name:"new_user" , methods: ['GET', 'POST'])]
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
            $this->flashy->success('Utilisateur ajouté');

            return $this->redirectToRoute('utilisateurs', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/user/userAdd.html.twig', [
            'users' => $user,
            'form' => $form,
        ]);
    }


    #[Route("/utilisateurs/modifier/{id}", name:"modifier_utilisateur")]

    public function editUser(Users $user, UsersRepository $usersRepository, Request $request)
    {
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $usersRepository->add($user, true);

            $this->flashy->success('Utilisateur modifié avec succès');
            return $this->redirectToRoute('utilisateurs');
        }

        return $this->render('admin/user/edituser.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'user_delete', methods: ['POST'])]
    public function delete(Request $request, Users $users, UsersRepository $usersRepository): Response
    {
        if(! $this->getUser()){
            $this->flashy->error('Vous devez vous connecté en tant qu\'administrateur au préalable!');
            return $this->redirectToRoute('login');
        }

        if ($this->isCsrfTokenValid('delete'.$users->getId(), $request->request->get('_token'))) {
            $usersRepository->remove($users, true);
            $this->flashy->success('Utilisateur supprimé');
        }

        return $this->redirectToRoute('utilisateurs', [], Response::HTTP_SEE_OTHER);
    }



}
