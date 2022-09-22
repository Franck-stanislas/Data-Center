<?php

namespace App\Controller;

use App\Entity\Statut;
use App\Form\StatutType;
use App\Repository\StatutRepository;
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

#[Route('admin/statut')]
class StatutController extends AbstractController
{
    public function __construct(FlashyNotifier $flashy, TranslatorInterface $translator)
    {
        $this->flashy = $flashy;
        $this->translation = $translator;
    }

    #[Route('/', name: 'app_statut_index', methods: ['GET'])]
    public function index(StatutRepository $statutRepository): Response
    {
        if(! $this->getUser()){
            $this->flashy->error('Vous devez vous connecté en tant qu\'administrateur au préalable!');
            return $this->redirectToRoute('login');
        }

        return $this->render('statut/index.html.twig', [
            'statuts' => $statutRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_statut_new', methods: ['GET', 'POST'])]
    public function new(Request $request, StatutRepository $statutRepository): Response
    {
        if(! $this->getUser()){
            $this->flashy->error('Vous devez vous connecté en tant qu\'administrateur au préalable!');
            return $this->redirectToRoute('login');
        }

        $statut = new Statut();
        $form = $this->createForm(StatutType::class, $statut);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $statutRepository->add($statut, true);
            $message  = $this->translation->trans('Nouveau statut ajouté');
            $this->flashy->success($message);
            return $this->redirectToRoute('app_statut_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('statut/new.html.twig', [
            'statut' => $statut,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_statut_show', methods: ['GET'])]
    public function show(Statut $statut): Response
    {
        if(! $this->getUser()){
            $this->flashy->error('Vous devez vous connecté en tant qu\'administrateur au préalable!');
            return $this->redirectToRoute('login');
        }

        return $this->render('statut/show.html.twig', [
            'statut' => $statut,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_statut_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Statut $statut, StatutRepository $statutRepository): Response
    {
        if(! $this->getUser()){
            $this->flashy->error('Vous devez vous connecté en tant qu\'administrateur au préalable!');
            return $this->redirectToRoute('login');
        }

        $form = $this->createForm(StatutType::class, $statut);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $statutRepository->add($statut, true);
            $message  = $this->translation->trans('Statut mis à jour');
            $this->flashy->primary($message);
            return $this->redirectToRoute('app_statut_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('statut/edit.html.twig', [
            'statut' => $statut,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_statut_delete', methods: ['POST'])]
    public function delete(Request $request, Statut $statut, StatutRepository $statutRepository): Response
    {
        if(! $this->getUser()){
            $this->flashy->error('Vous devez vous connecté en tant qu\'administrateur au préalable!');
            return $this->redirectToRoute('login');
        }

        if ($this->isCsrfTokenValid('delete'.$statut->getId(), $request->request->get('_token'))) {
            $statutRepository->remove($statut, true);
            $message  = $this->translation->trans('Statut supprimé');
            $this->flashy->success($message);
        }

        return $this->redirectToRoute('app_statut_index', [], Response::HTTP_SEE_OTHER);
    }
}
