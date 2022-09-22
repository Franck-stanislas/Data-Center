<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Form\ProjetType;
use App\Repository\ProjetRepository;
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
#[Route('/admin/projects')]
class ProjectsController extends AbstractController
{
    public function __construct(FlashyNotifier $flashy, TranslatorInterface $translator)
    {
        $this->flashy = $flashy;
        $this->translation = $translator;
    }

    #[Route('/', name: 'app_projects')]
    public function index(): Response
    {
        if(! $this->getUser()){
            $this->flashy->error('Vous devez vous connecté en tant qu\'administrateur au préalable!');
            return $this->redirectToRoute('login');
        }

        return $this->render('projects/index.html.twig');
    }

    #[Route('/create', name: 'app_projects_create')]
    public function create(): Response
    {
        if(! $this->getUser()){
            $this->flashy->error('Vous devez vous connecté en tant qu\'administrateur au préalable!');
            return $this->redirectToRoute('login');
        }

        return $this->renderForm('projects/create.html.twig');
    }

    #[Route('/edit/{id<[0-9]+>}', name: 'project_edit', methods: ['GET'])]
    public function editProject(Projet $projet): Response
    {
        $formatedProjet = [];
        $formatedProjet['financements'] = [];
        $formatedProjet['eltsMaturite'] = [];
        $formatedProjet["arrondissement"] = $projet->getArrondissement()->getId();
        $formatedProjet["secteur"] = $projet->getSecteur()->getId();
        $formatedProjet["couts"] = $projet->getCouts();
        $formatedProjet["resultats"] = $projet->getResultats();
        $formatedProjet["objectifs"] = $projet->getObjectifs();
        $formatedProjet["institule"] = $projet->getInstitule();
        $formatedProjet["caracteristique"] = $projet->getCaracteristique();
        $formatedProjet["marche"] = $projet->getMarche();
        $formatedProjet["supply"] = $projet->getSupply();
        $formatedProjet["atouts"] = $projet->getAtouts();
        $formatedProjet["valeur_ajouter"] = $projet->getValeurAjouter();
        $formatedProjet["eligibilite"] = $projet->getEligibilite();
        $formatedProjet["maturite"] = $projet->getMaturite()->getId();
        $formatedProjet["status"] = $projet->getStatut()?->getId();
        $formatedProjet["user_id"] = $projet->getUser()->getId();
        foreach ($projet->getFinancement() as $financement) {
            $formatedProjet['financements'][] = $financement->getId();
        }
        foreach ($projet->getEltsMaturite() as $maturite) {
            $formatedProjet['eltsMaturite'][] = $maturite->getId();
        }
        return $this->renderForm('projects/edit.html.twig', compact('formatedProjet'));
    }
}
