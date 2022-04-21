<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/teacher/gestion')]
class GestionFormationController extends AbstractController
{
    #[Route('/index', name: 'gestion_formation')]
    public function index(): Response
    {
        return $this->render('gestion_formation/index.html.twig', [
            'controller_name' => 'GestionFormationController',
        ]);
    }
}
