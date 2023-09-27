<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Entity\QuestionAnswer;
use App\Entity\Test;
use App\Form\QuestionAnswerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/testback', name: 'app_test_back')]
    public function indexBack(): Response
    {
        return $this->render('backBase.html.twig'
        );
    }
    #[Route('/testfront', name: 'app_test_front')]
    public function indexFront(): Response
    {
        return $this->render('basefront.html.twig'
        );
    }


    #[Route('/offre/{id}/test/create', name: 'offre_test_create')]
    public function create(Request $request, $id)
    {
        $offre = $this->getDoctrine()->getRepository(Offre::class)->find($id);
        if (!$offre) {
            throw $this->createNotFoundException(
                'No offre found for id ' . $id
            );
        }
        // Check if a test already exists for this offre
        if ($offre->getTest()) {
            return $this->redirectToRoute('offre_test_show', ['id' => $id, 'testId' => $offre->getTest()->getId()]);
        }

        $test = new Test();

        for ($i = 0; $i < 3; $i++) {
            $question = new QuestionAnswer();
            $test->addQuestionAnswer($question);
        }

        $form = $this->createFormBuilder($test)
            ->add('questionAnswers', CollectionType::class, [
                'entry_type' => QuestionAnswerType::class,
                'entry_options' => ['label' => false],
            ])
            ->getForm();

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $test->setOffre($offre);
            $entityManager->persist($test);
            $entityManager->flush();

            return $this->redirectToRoute('offres_list');
        }
        return $this->render('test/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/offre/{id}/test/{testId}/edit', name: 'offre_test_edit')]
    public function edit(Request $request, $id, $testId)
    {
        $offre = $this->getDoctrine()->getRepository(Offre::class)->find($id);

        if (!$offre) {
            throw $this->createNotFoundException(
                'No offre found for id ' . $id
            );
        }

        $test = $this->getDoctrine()->getRepository(Test::class)->find($testId);

        if (!$test) {
            throw $this->createNotFoundException(
                'No test found for id ' . $testId
            );
        }
//afin de changer le nombre des questions on doit changer i<3
        for ($i = 0; $i < 3; $i++) {
            $question = new QuestionAnswer();
            $test->addQuestionAnswer($question);
        }

        $form = $this->createFormBuilder($test)
            ->add('questionAnswers', CollectionType::class, [
                'entry_type' => QuestionAnswerType::class,
                'entry_options' => ['label' => false],
            ])
            ->getForm();

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($test);
            $entityManager->flush();

            return $this->redirectToRoute('offres_list');
        }
        return $this->render('test/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/offre/{id}/test/{testId}/remove', name: 'offre_test_remove')]
    public function remove(Request $request, $id, $testId)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $test = $entityManager->getRepository(Test::class)->find($testId);

        if (!$test) {
            throw $this->createNotFoundException(
                'No test found for id ' . $testId
            );
        }

        $entityManager->remove($test);
        $entityManager->flush();

        return $this->redirectToRoute('offres_list');
    }

    #[Route('/offre/{id}/test/{testId}/show', name: 'offre_test_show')]
    public function show(Request $request, $id, $testId)
    {
        $offre = $this->getDoctrine()->getRepository(Offre::class)->find($id);

        if (!$offre) {
            throw $this->createNotFoundException(
                'No offre found for id ' . $id
            );
        }

        $test = $this->getDoctrine()->getRepository(Test::class)->find($testId);

        if (!$test) {
            throw $this->createNotFoundException(
                'No test found for id ' . $testId
            );
        }

        $form = $this->createFormBuilder($test)
            ->add('questionAnswers', CollectionType::class, [
                'entry_type' => QuestionAnswerType::class,
                'entry_options' => ['label' => false],
            ])
            ->getForm();

        return $this->render('test/show.html.twig', [
            'form' => $form->createView(),
            'offre' => $offre,
            'test' => $test,
        ]);
    }


}
