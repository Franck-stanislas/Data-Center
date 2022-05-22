<?php

namespace App\Controller;

use App\Entity\EltMaturite;
use App\Form\EltMaturiteType;
use App\Repository\EltMaturiteRepository;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/Eltmaturite')]
class EltMaturiteController extends AbstractController
{
    public function __construct(FlashyNotifier $flashy)
    {
        $this->flashy = $flashy;
    }

    #[Route('/', name: 'app_elt_maturite_index', methods: ['GET'])]
    public function index(EltMaturiteRepository $eltMaturiteRepository): Response
    {
        return $this->render('elt_maturite/index.html.twig', [
            'elt_maturites' => $eltMaturiteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_elt_maturite_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EltMaturiteRepository $eltMaturiteRepository): Response
    {
        $eltMaturite = new EltMaturite();
        $form = $this->createForm(EltMaturiteType::class, $eltMaturite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $eltMaturiteRepository->add($eltMaturite, true);
            $this->flashy->success('Nouveau élément de maturité enregistré');
            return $this->redirectToRoute('app_elt_maturite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('elt_maturite/new.html.twig', [
            'elt_maturite' => $eltMaturite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_elt_maturite_show', methods: ['GET'])]
    public function show(EltMaturite $eltMaturite): Response
    {
        return $this->render('elt_maturite/show.html.twig', [
            'elt_maturite' => $eltMaturite,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_elt_maturite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EltMaturite $eltMaturite, EltMaturiteRepository $eltMaturiteRepository): Response
    {
        $form = $this->createForm(EltMaturiteType::class, $eltMaturite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $eltMaturiteRepository->add($eltMaturite, true);
            $this->flashy->success('Elément de maturité modifié');
            return $this->redirectToRoute('app_elt_maturite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('elt_maturite/edit.html.twig', [
            'elt_maturite' => $eltMaturite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_elt_maturite_delete', methods: ['POST'])]
    public function delete(Request $request, EltMaturite $eltMaturite, EltMaturiteRepository $eltMaturiteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eltMaturite->getId(), $request->request->get('_token'))) {
            $eltMaturiteRepository->remove($eltMaturite, true);
            $this->flashy->success('Elément de maturité supprimé');
        }

        return $this->redirectToRoute('app_elt_maturite_index', [], Response::HTTP_SEE_OTHER);
    }
}
