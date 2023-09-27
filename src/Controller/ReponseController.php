<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Entity\Reponse;
use App\Form\Reclamation1Type;
use App\Form\ReponseType;
use App\Repository\ReclamationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twilio\Rest\Client;

class ReponseController extends AbstractController
{
    #[Route('reponse/{id}/create', name: 'reponse_create', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        $form = $this->createForm(ReponseType::class, $reclamation);
        $form->handleRequest($request);
        $reponse=new Reponse();
        $reponse->setDateRep(new \DateTime());
        if ($form->isSubmitted() && $form->isValid()) {
            $reponse->setTraitement($reclamation->getRep());
            $reclamation->setReponse($reponse);
            $reclamationRepository->save($reclamation, true);
            // $sid    = "AC7ad9822a12bcab7d05087b01bc178db9";
            // $token  = "23533609f6a3cfc591707e45a8cea334";
            // $twilio = new Client($sid, $token);
            // $message = $twilio->messages
            //     ->create("+21656938615", // to
            //         array(
            //             "from" => "+16206282576",
            //             "body" => "Votre réclamation a été traitée "
            //         )
            //     );

            // print($message->sid);

            return $this->redirectToRoute('reclamations', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reponse/index.html.twig', [
            'reclamation' => $reclamation,
            'reponse' =>$reponse,
            'form' => $form,
        ]);
    }
}