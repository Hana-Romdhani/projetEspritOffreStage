<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Entity\Reponse;
use App\Entity\User;
use App\Form\Reclamation1Type;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Knp\Component\Pager\PaginatorInterface;


use GuzzleHttp\Client as GuzzleClient;
use Twilio\Rest\Client;

use App\Repository\UserRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Notifier\Message\SmsMessage;
use Symfony\Component\Notifier\TexterInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

use Symfony\Component\OptionsResolver\OptionsResolver;


class ReclamationsController extends AbstractController
{

    /**
     * @Route("/addReclamation", name="addReclamation")
     */
    public function addReclamation(Request $request, ReclamationRepository $reclamationRepository): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $token2 = $this->container->get('security.token_storage')->getToken();

        $user = $token2->getUser();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $dateReclamation = new \DateTime();

            // Get the date portion of the DateTime object using the format() method
            $dateString = $dateReclamation->format('Y-m-d');
        
            $dateReclamation = new \DateTime($dateString);
                    $reclamation->setDateReclamation($dateReclamation);
                    $reclamation->setUseridid($user);
                    $reclamation->setUser($user->getEmail());
            //$reclamation->setUser($this->getUser());
            $reclamationRepository->save($reclamation);
            $em = $this->getDoctrine()->getManager();
        //     $sid    = "AC7ad9822a12bcab7d05087b01bc178db9";
        //     $token  = "23533609f6a3cfc591707e45a8cea334";
        //     // , array(
        //     //     'http' => array(
        //     //         'verify' => 'C:\Users\hanar\Downloads\cacert.pem'
        //     //     )
        //     // )
        //     $twilio = new Client($sid, $token);
        //     // $config = [
        //     //     'httpClient' => new Client([
        //     //         'verify' => '/path/to/root/certificates.pem'
        //     //     ])
        //     // ];
        //     // $twilio = new \Twilio\Rest\Client($sid, $token, null, $config);
        //     // $config = [
        //     //     'httpClient' => new GuzzleClient([
        //     //         'verify' => 'C:\Users\hanar\Downloads\cacert.pem'
        //     //     ])
        //     // ];
            
        //     // $twilio = new Client($sid, $token, null, $config);

        //     $message = $twilio->messages
        //       ->create("+21656938615", // to
        //         array(
        //           "from" => "+16206282576",
        //           "body" => "bonjour vous avez une nouvelle reclamation"
        //         )
        //       );
        
        // print($message->sid);
        
            $em->persist($reclamation);
            $em->flush();
            return $this->redirectToRoute('userReclamations');
        } else
            return $this->render('Reclamation/createReclamation.html.twig', ['form' => $form->createView()]);
    }


    /**
     * @Route("/reclamations", name="reclamations")
     */
    public function reclamations(PaginatorInterface $paginator,ReclamationRepository $reclamationRepository, Request $request): Response
    {
        $reclamations = $reclamationRepository->findAll();
       
        return $this->render('Reclamation/reclamations.html.twig', [
            'reclamations' => $reclamations,
        ]);
    }

    /**
     * @Route("/userReclamations", name="userReclamations")
     */
    public function reclamationsUser(PaginatorInterface $paginator,ReclamationRepository $reclamationRepository, Request $request): Response
    {
        //$user= $this->getUser();


        $token = $this->container->get('security.token_storage')->getToken();

        $user = $token->getUser();
        $reclamations = $reclamationRepository->findByUserEmail($user->getEmail());

        return $this->render('ReclamationUser/reclamations.html.twig', [
            'reclamations' => $reclamations,
        ]);
    }




    #[Route('/{id}/edit', name: 'reclamation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        $form = $this->createForm(Reclamation1Type::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationRepository->save($reclamation, true);

            return $this->redirectToRoute('reclamations', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/editReclamation.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }
    #[Route('/{id}/editUserReclamation', name: 'user_reclamation_edit', methods: ['GET', 'POST'])]
    public function editUserReclamation(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        $form = $this->createForm(Reclamation1Type::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationRepository->save($reclamation, true);

            return $this->redirectToRoute('userReclamations', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamationUser/editReclamation.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }



    /**
     * @Route("/reclamations/{id}/remove", name="remove_reclamation")
     */
    public function remove(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response

    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($reclamation);
        $em->flush();
        return $this->redirectToRoute('reclamations', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/reclamations/{id}/removeUserReclamation", name="remove_user_reclamation")
     */
    public function userRemoveReclamation(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response

    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($reclamation);
        $em->flush();
        return $this->redirectToRoute('userReclamations', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/reclamations/{id}", name="show_reclamation")
     */
    /**
     * @Route("/reclamation/{id}", name="reclamation_show")
     */
    public function show($id, ReclamationRepository $reclamationRepository): Response
    {
        $reclamation = $reclamationRepository->find($id);
        return $this->render('Reclamation/showReclamation.html.twig', ['reclamation' => $reclamation]);
    }

    public function search(Request $request, ReclamationRepository $repository): JsonResponse
    {
        $query = $request->query->get('query');
        $reclamations = $repository->search($query);

        $response = [];

        foreach ($reclamations as $reclamation) {
            $response[] = [
                'id' => $reclamation->getId(),
                'description' => $reclamation->getDescription(),
                'etat' => $reclamation->getEtat(),
                'dateReclamation'=>$reclamation->getDateReclamation(),
            ];
        }

        return new JsonResponse($response);
    }

//web service  reclamation





 /**
     * @Route("/api/addReclamation_mobile", name="add_reclamationmobile")
     */
    public function addReclamationApi(Request $request,UtilisateurRepository $userRepo): JsonResponse
    {
        // Create a new Reclamation object and set its properties
        $reclamation = new Reclamation();
        $reclamation->setDescription($request->query->get('description'));
        $reclamation->setUser($userRepo->findOneByEmail("rihem@esprit.tn"));
        $reclamation->setEtat("pending");
        $em = $this->getDoctrine()->getManager();
        $sid    = "AC7ad9822a12bcab7d05087b01bc178db9";
        $token  = "23533609f6a3cfc591707e45a8cea334";
        $twilio = new Client($sid, $token);
        $message = $twilio->messages
            ->create("+21656938615", // to
                array(
                    "from" => "+16206282576",
                    "body" => "bonjour vous avez une nouvelle reclamation! description :".$request->query->get('description')
                )
            );

        print($message->sid);


        // Persist the new Reclamation object in the database
        $em = $this->getDoctrine()->getManager();
        $em->persist($reclamation);
        $em->flush();

        // Return a JSON response indicating success
        return $this->json([
            'success' => true,
            'message' => 'Rec lamation created successfully'

        ], Response::HTTP_OK);
    }




 /**
     * @Route("/api/reclamations", name="reclamations_api")
     */
    public function getAllReclamations()
    {
        $reclamations = $this->getDoctrine()->getRepository(Reclamation::class)->findAll();

        $reclamationsArray = array();

        foreach($reclamations as $reclamation) {

            $reclamationsArray[] = array(
                'id' => $reclamation->getId(),
                'dateReclamation' => $reclamation->getDateReclamation()->format('y-m-d'),
                'user' => $reclamation->getUser(),
                'description' => $reclamation->getDescription(),
                'etat' => $reclamation->getEtat(),

            );
        }

        return  new JsonResponse(array('root' => $reclamationsArray));

    }
    /**
     * @Route("/api/delete_reclamation", name="remove_reclamation_mobile")
     */
    public function deleteReclamation(Request $request, ReclamationRepository $reclamationRepository): Response

    {
        $reclamation = new Reclamation();
        $id = (int)$request->query->get('id');
        $reclamation=$reclamationRepository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($reclamation);
        $em->flush();
        return new Response("reclamation Supprimé");
    }
 /**
     * @Route("/api/updateReclamation", name="update_reclamationmobile")
     */
    public function updateReclamation(Request $request,ReclamationRepository $reclamationRepository): JsonResponse
    {
        // Create a new Reclamation object and set its properties
        $id = (int)$request->query->get('id');
        $reclamation = $reclamationRepository->find($id);
        $reclamation->setDescription($request->query->get('description'));
        $reclamation->setEtat($request->query->get('etat'));

        // Persist the new Reclamation object in the database
        $em = $this->getDoctrine()->getManager();
        $em->persist($reclamation);
        $em->flush();

        // Return a JSON response indicating success
        return $this->json([
            'success' => true,
            'message' => 'Reclamation updated successfully'

        ], Response::HTTP_OK);
    }








/**
     * @Route("/api/addReponse", name="addReponse_mobile")
     */
    public function addReponse(Request $request,ReclamationRepository $reclamationRepository): JsonResponse
    {
        // Create a new Reclamation object and set its properties
        $id = (int)$request->query->get('id');
        $reponse=new Reponse();
        $reponse->setDateRep(new \DateTime());
        $reclamation = $reclamationRepository->find($id);
        $reponse->setTraitement($request->query->get('reponse'));
        $reclamation->setReponse($reponse);
        $reclamationRepository->save($reclamation, true);

        // Persist the new Reclamation object in the database
        $em = $this->getDoctrine()->getManager();
        $em->persist($reclamation);
        $em->flush();

        // Return a JSON response indicating success
        return $this->json([
            'success' => true,
            'message' => 'reponse created successfully'

        ], Response::HTTP_OK);
    }


}
