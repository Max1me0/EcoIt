<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Formation;
use App\Repository\FormationRepository;
use App\Entity\Lesson;
use App\Entity\Section;

class CatalogueController extends AbstractController
{
    #[Route('/catalogue', name: 'catalogue')]
    public function index(FormationRepository $formationRepository): Response
    {
        return $this->render('catalogue/index.html.twig', [
            'formations' => $formationRepository->findAll(),
        ]);
    }

    #[Route('/student/catalogue/{id}', name: 'catalogue_formation', methods: ['GET'])]
    public function show(Formation $formation): Response
    {
        return $this->render('catalogue/formation.html.twig', [
            'formation' => $formation,
        ]);
    }

    #[Route('/student/catalogue/{formation}/{section}/{leçon}', name: 'catalogue_formation_consulter', methods: ['GET'])]
    public function read_lesson(Formation $formation, Section $section, Lesson $lesson): Response
    {        
        return $this->render('catalogue/consulter.html.twig', [            
            'formation' => $formation,
            'section' => $section,
            'leçon' => $lesson,
        ]);
    }
}
