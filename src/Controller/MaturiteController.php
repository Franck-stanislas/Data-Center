<?php

namespace App\Controller;

use App\Entity\Maturite;
use App\Form\MaturiteType;
use App\Repository\MaturiteRepository;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Require ROLE_ADMIN for all the actions of this controller
 *
 * @IsGranted("ROLE_ADMIN")
 */

#[Route('admin/maturite')]
class MaturiteController extends AbstractController
{
    public function __construct(FlashyNotifier $flashy, TranslatorInterface $translator)
    {
        $this->flashy = $flashy;
        $this->translation = $translator;
    }

    #[Route('/', name: 'app_maturite_index', methods: ['GET'])]
    public function index(MaturiteRepository $maturiteRepository): Response
    {
        if(! $this->getUser()){
            $this->flashy->error('Vous devez vous connecté en tant qu\'administrateur au préalable!');
            return $this->redirectToRoute('login');
        }

        return $this->render('maturite/index.html.twig', [
            'maturites' => $maturiteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_maturite_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MaturiteRepository $maturiteRepository): Response
    {
        if(! $this->getUser()){
            $this->flashy->error('Vous devez vous connecté en tant qu\'administrateur au préalable!');
            return $this->redirectToRoute('login');
        }

        $maturite = new Maturite();
        $form = $this->createForm(MaturiteType::class, $maturite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $maturiteRepository->add($maturite, true);
            $message = $this->translation->trans('Nouvelle maturité ajoutée');
            $this->flashy->success($message);
            return $this->redirectToRoute('app_maturite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('maturite/new.html.twig', [
            'maturite' => $maturite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_maturite_show', methods: ['GET'])]
    public function show(Maturite $maturite): Response
    {
        if(! $this->getUser()){
            $this->flashy->error('Vous devez vous connecté en tant qu\'administrateur au préalable!');
            return $this->redirectToRoute('login');
        }

        return $this->render('maturite/show.html.twig', [
            'maturite' => $maturite,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_maturite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Maturite $maturite, MaturiteRepository $maturiteRepository): Response
    {
        if(! $this->getUser()){
            $this->flashy->error('Vous devez vous connecté en tant qu\'administrateur au préalable!');
            return $this->redirectToRoute('login');
        }

        $form = $this->createForm(MaturiteType::class, $maturite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $maturiteRepository->add($maturite, true);
            $message = $this->translation->trans('Nouvelle maturité mis à jour');
            $this->flashy->primary($message);
            return $this->redirectToRoute('app_maturite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('maturite/edit.html.twig', [
            'maturite' => $maturite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_maturite_delete', methods: ['POST'])]
    public function delete(Request $request, Maturite $maturite, MaturiteRepository $maturiteRepository): Response
    {
        if(! $this->getUser()){
            $this->flashy->error('Vous devez vous connecté en tant qu\'administrateur au préalable!');
            return $this->redirectToRoute('login');
        }

        if ($this->isCsrfTokenValid('delete'.$maturite->getId(), $request->request->get('_token'))) {
            $maturiteRepository->remove($maturite, true);
            $message = $this->translation->trans('Maturité supprimée');
            $this->flashy->success($message);
        }

        return $this->redirectToRoute('app_maturite_index', [], Response::HTTP_SEE_OTHER);
    }
}
