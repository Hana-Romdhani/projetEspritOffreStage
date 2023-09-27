<?php

namespace App\Controller;

use App\Entity\Competence;
use App\Form\CompetenceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompetenceController extends AbstractController
{
    /**
     * @Route("/competence/create", name="competence_create")
     */
    public function create(Request $request): Response
    {
        $competence = new Competence();

        $form = $this->createForm(CompetenceType::class, $competence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($competence);
            $entityManager->flush();

            $this->addFlash('success', 'Competence created successfully');

            return $this->redirectToRoute('competence_create');
        }

        return $this->render('competence/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}