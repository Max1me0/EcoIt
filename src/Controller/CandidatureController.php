<?php

namespace App\Controller;

use App\Entity\Candidature;
use App\Form\CandidatureType;
use App\Repository\CandidatureRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class CandidatureController extends AbstractController
{
    public function __construct(Security $security)
    {
        $this->security = $security;
    }    

    #[Route('/candidature/new', name: 'candidature_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CandidatureRepository $candidatureRepository): Response
    {
        $candidature = new Candidature();
        $form = $this->createForm(CandidatureType::class, $candidature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $form = $this->manageUpload($form, $candidature);

            $user = $this->security->getUser();
            $candidature->setcandidat($user);

            $candidatureRepository->add($candidature);
            return $this->redirectToRoute('accueil');
        }

        return $this->renderForm('candidature/new.html.twig', [
            'candidature' => $candidature,
            'form' => $form,
        ]);
    }    

    private function manageUpload(FormInterface $form, Candidature $candidature): FormInterface
    {
        /** @var UploadedFile $imageFile */
        $imageFile = $form->get('image_file')->getData();
        if ($imageFile) {
                        
            $newFilename = uniqid().'.'.$imageFile->guessExtension();

            try {
                $imageFile->move(
                    $this->getParameter('kernel.project_dir') . '/public/uploads',
                    $newFilename
                );
            } catch (FileException $e) {
                $this->addFlash('error', '[Upload] : '.$e->getMessage());
            }

            $candidature->setPhotoCandidatPath($newFilename);
        }

        return $form;
    }

    #[Route('/admin/candidature', name: 'candidature_index', methods: ['GET'])]
    public function index(CandidatureRepository $candidatureRepository): Response
    {
        return $this->render('candidature/index.html.twig', [
            'candidatures' => $candidatureRepository->findAll(),
        ]);
    }
    
    #[Route('/admin/candidature/{id}', name: 'candidature_show', methods: ['GET'])]
    public function show(Candidature $candidature): Response
    {
        return $this->render('candidature/show.html.twig', [
            'candidature' => $candidature,
        ]);
    }

    #[Route('/admin/candidature/{id}/update', name: 'candidature_update', methods: ['GET', 'POST'])]
    public function update(Request $request, Candidature $candidature, CandidatureRepository $candidatureRepository, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('update'.$candidature->getId(), $request->request->get('_token'))) {
            $name = $candidature->getName();
            $firstname = $candidature->getFirstname();
            $user = $candidature->getCandidat();
            $user->setName($name);
            $user->setFirstname($firstname);
            $user->setRoles(['ROLE_TEACHER']);
            $userRepository->updateData($user);
            $candidatureRepository->remove($candidature);
        }

        return $this->redirectToRoute('candidature_index', [], Response::HTTP_SEE_OTHER);
        
    }

    #[Route('/admin/candidature/{id}/delete', name: 'candidature_delete', methods: ['POST'])]
    public function delete(Request $request, Candidature $candidature, CandidatureRepository $candidatureRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$candidature->getId(), $request->request->get('_token'))) {
            $candidatureRepository->remove($candidature);
        }

        return $this->redirectToRoute('candidature_index', [], Response::HTTP_SEE_OTHER);
    }
}

