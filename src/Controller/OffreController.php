<?php
// OffreController.php
namespace App\Controller;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\JsonResponse;
use CalendarBundle\Event\CalendarEvent;
use Knp\Component\Pager\PaginatorInterface;

use App\Entity\Competence;
use App\Entity\Offre;
use App\Entity\QuestionAnswer;
use App\Entity\Test;
use App\Form\OffreType;
use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

class OffreController extends AbstractController
{
    #[Route('/offre/create', name: 'offre_create')]
    public function create( Request $request): Response
    {
        $offre = new Offre();
        $token = $this->container->get('security.token_storage')->getToken();
        $user = $token->getUser();
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $competenceIds = $request->request->get('competences');
            if (!empty($competenceIds)) {
                foreach ($competenceIds as $competenceId) {
                    $competence = $entityManager->getRepository(Competence::class)->find($competenceId);



                    if ($competence) {
                        $offre->addCompetence($competence);
                        $competence->setOffre($offre);

                    }
                }

            }

                $offre->setUserIDOFFRE($user);

            $entityManager->persist($offre);
          
            $entityManager->flush();


            return $this->redirectToRoute('offre_create');
        }

        return $this->render('offre/create.html.twig', [
            'form' => $form->createView(),
            'competences' => $this->getDoctrine()->getRepository(Competence::class)->findAll(),
        ]);
    }
    /**
     * @Route("/offres", name="offres_list")
     */
    public function list(OffreRepository $offreRepository,PaginatorInterface $paginator, Request $request): Response
    {
        $offres = $offreRepository->findAll();
        $showDetails = false;
        $offres = $paginator->paginate(
            $offres,
            $request->query->getInt('page', 1),
            3
        );

        return $this->render('offre/list.html.twig', [
            'offres' => $offres,
            'show_details' => $showDetails,
        ]);
    }
    /**
     * @Route("/offre/{id}/update", name="offre_update")
     */
    public function update(Request $request, Offre $offre,OffreRepository $offreRepository): Response
    {
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();



            $competenceIds = $request->request->get('competences');
            if (!empty($competenceIds)) {
                foreach ($competenceIds as $competenceId) {
                    $competence = $entityManager->getRepository(Competence::class)->find($competenceId);


                    if ($competence && !$offre->hasCompetence($competence)) {
                        $offre->addCompetence($competence);
                        $competence->setOffre($offre);
                    }
                }
            }
            $offreRepository->save($offre,true);



            return $this->redirectToRoute('offres_list');
        }

        return $this->renderForm('offre/update.html.twig', [
            'offre' => $offre,
            'form' => $form,
            'competences' => $this->getDoctrine()->getRepository(Competence::class)->findAll(),
        ]);
    }

    /**
     * @Route("/offre/{id}/delete", name="offre_delete")
     */
    public function delete(Request $request, Offre $offre): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($offre);
        $entityManager->flush();

        return $this->redirectToRoute('offres_list');
    }
    

    /**
     * @Route("/pdf", name="pdf",methods="GET")
     */
    public function pdf(OffreRepository $repository)
    {

        $pdfOptions =new Options();
        $pdfOptions->set('defaultFront','Arial');
        $dompdf = new Dompdf($pdfOptions);
        $Offre =$repository->findAll();
        $html= $this->renderView('offre/pdf.html.twig',
            ['offres'=> $Offre]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4','portrait');
        $dompdf->render();
        $dompdf->stream("Liste_des_offre.pdf",[
            "Attachment"=> true
        ]);
    }
   
    /**
   * @Route("/calendar/events", name="calendar_events")
   */
   public function calendarEvents(): JsonResponse
    {
        $offres = $this->getDoctrine()->getRepository(Offre::class)->findAll();

        $events = [];
        foreach ($offres as $offre) {
            $events[] = [
                'title' => $offre->getNomOffre(),
                'start' => $offre->getDatePublication()->format('Y-m-d'),
                'end' => $offre->getDateCloture()->format('Y-m-d'),
                'color' => 'green'
            ];
        }

        return new JsonResponse($events);
    }
      /**
   * @Route("/cal", name="cal")
   */
  public function cal()
  {    
    return $this->renderForm('offre/calendar.html.twig');
  }
    /**
     * @Route("/offresfront", name="offres_list_front")
     */
    
    public function offreListFront(OffreRepository $offreRepository): Response
    {
        $offres = $offreRepository->findAll();
        $showDetails = false;

        return $this->render('offreFront/list.html.twig', [
            'offres' => $offres,
            'show_details' => $showDetails,
        ]);
    }
 /**
     * @Route("/api/offres", name="offres_api")
     */
    public function getAllOffres()
    {
        $offre = $this->getDoctrine()->getRepository(Offre::class)->findAll();

        $offresArray = array();

        foreach ($offre as $offres) {
            $dateCloture = $offres->getDateCloture();
            $dateString = $dateCloture->format('Y-m-d');


            $offresArray[] = array(
                'id' => $offres->getId(),
                'dateCloture' => $dateString,
                'description' => $offres->getDescription(),
                'datePublication' => $offres->getDatePublication()->format('d-m-y'),
                'nomOffre' => $offres->getNomOffre(),

            );
        }

        return new JsonResponse(array('root' => $offresArray));

    }
  /**
     * @Route("/api/delete_offre", name="remove_offre_mobile")
     */
    public function deleteOffre(Request $request, OffreRepository $offreRepository): Response

    {

        $offre = new Offre();
        $id = (int)$request->query->get('id');
        $offre = $offreRepository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($offre);
        $em->flush();
        return $this->json([
            'success' => true,
            'message' => 'offre  deleted successfully'

        ], Response::HTTP_OK);
    }
     /**
     * @Route("/api/addOffre", name="add_offre")
     */
    public function addOffreMoblie(Request $request): JsonResponse
    {
        // Create a new Reclamation object and set its properties
        $offre = new Offre();
        $offre->setDescription($request->query->get('description'));
        $offre->setNomOffre($request->query->get('nomOffre'));
        $dateClotureString = $request->query->get('dateCloture');
        $dateCloture = new DateTime($dateClotureString);
        $offre->setDateCloture($dateCloture);
        $offre->setDatePublication(new \DateTime());

        // Persist the new Reclamation object in the database
        $em = $this->getDoctrine()->getManager();
        $em->persist($offre);
        $em->flush();

        // Return a JSON response indicating success
        return $this->json([
            'success' => true,
            'message' => 'offre created successfully'

        ], Response::HTTP_OK);
    }

 /**
     * @Route("/api/update", name="update_offre_mobile")
     */
    public function updateOffre(Request $request, OffreRepository $offreRepository): JsonResponse

    {
        $id = (int)$request->query->get('id');
        $offre = $offreRepository->find($id);

        $offre->setDescription($request->query->get('description'));
        $offre->setNomOffre($request->query->get('nomOffre'));
        $dateClotureString = $request->query->get('dateCloture');
        $dateCloture = new DateTime($dateClotureString);
        $offre->setDateCloture($dateCloture);
        $offre->setDatePublication(new \DateTime());

        // Persist the new Reclamation object in the database
        $em = $this->getDoctrine()->getManager();
        $em->persist($offre);
        $em->flush();

        // Return a JSON response indicating success
        return $this->json([
            'success' => true,
            'message' => 'offre updated successfully'

        ], Response::HTTP_OK);
    }

    #[Route('/api/addTest', name: 'test_create_mobile')]
    public function addTest(Request $request, OffreRepository $offreRepository)
    {
        $id = (int)$request->query->get('id');

        $offre = $offreRepository->find($id);

        $test = new Test();

        for ($i = 1; $i < 4; $i++) {
            $question = new QuestionAnswer();
            $question->setQuestion($request->query->get('q'.$i));
            $question->setAnswer($request->query->get('a'.$i));
            $test->addQuestionAnswer($question);
        }


        $entityManager = $this->getDoctrine()->getManager();

        $test->setOffre($offre);
        $entityManager->persist($test);
        $entityManager->flush();

        return $this->json([
            'success' => true,
            'message' => 'test  created successfully'

        ], Response::HTTP_OK);


    }
    
  
}

