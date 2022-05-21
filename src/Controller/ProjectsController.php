<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/projects')]
class ProjectsController extends AbstractController
{
    #[Route('/', name: 'app_projects')]
    public function index(): Response
    {
        return $this->render('projects/index.html.twig');
    }

    #[Route('/create', name: 'app_projects_create')]
    public function create(): Response
    {
        return $this->render('projects/create.html.twig');
    }
}
