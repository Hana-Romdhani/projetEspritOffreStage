<?php

namespace App\Controller;

use App\Entity\Specialite;
use App\Form\SpecialiteType;
use App\Repository\SpecialiteRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/Admin/specialite')]
class SpecialiteController extends AbstractController
{
    #[Route('/', name: 'app_specialite')]
    public function index(SpecialiteRepository $repo): Response
    {     $list=$repo->findAll();
        return $this->render('administrateur/specialite/liste.html.twig', [
            'specialite' => $list,
        ]);
    }
    #[Route('/ajouter', name: 'app_gerer_specialite_ajouter', methods: ['GET', 'POST'])]
    public function ajouter(Request $request, SpecialiteRepository $utilisateurRepository,SessionInterface $session): Response
    {
        $specialite = new Specialite();
        $form = $this->createForm(SpecialiteType::class, $specialite);
        $form->handleRequest($request);
        $session = $this->get('session');

        if ($form->isSubmitted() && $form->isValid()) {
            $utilisateurRepository->save($specialite, true);
            $session->getFlashBag()->add('success', 'la specialite a été ajouter avec succès !');

            return $this->redirectToRoute('app_specialite');
        }

        return $this->render('administrateur/specialite/ajouter.html.twig', [
            'specialite' => $specialite,
            'form' =>  $form->createView(),
        ]);
    }
    
    #[Route('/supprimer/{idSpecialite}', name: 'app_gerer_specialite_sup')]
    public function delete(ManagerRegistry $em, int $idSpecialite): Response
    { $repo=$em->getRepository(Specialite::class);
        $spe=$repo->find($idSpecialite);
          $em=$em->getManager();
      
          $session = $this->get('session');

        if ($spe) {
             $em->remove($spe);
              $em->flush();
        }
        $session->getFlashBag()->add('success', 'la specialite a été supprimer avec succès !');

        return $this->redirectToRoute('app_specialite',[
            'utilisateur' => $spe,
       
        ]);
       
    }

#[Route('/modifier/{idSpecialite}', name: 'app_gerer_spe_modifier')]
    public function edit(Request $request, Specialite $specialite, SpecialiteRepository $utilisateurRepository,ManagerRegistry $doctrine,SessionInterface $session): Response
    {  
         $id=$request->get('idSpecialite');
        $repo=$doctrine->getRepository(Specialite::class);

        $spe=$repo->find($id);
        $form=$this->createForm(SpecialiteType::class,$spe);

        $data = $form->getData();
       // dd($data);
       $session = $this->get('session');
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

                // Save only the modified fields

           
            
            $utilisateurRepository->save($specialite,true);
            //$em=$doctrine->getManager();
            //  $em->persist($student);
           // $em->flush();

            
           $session->getFlashBag()->add('success', 'la specialite a été modifier avec succès !');
            return $this->redirectToRoute("app_specialite");

        }
        
        return $this->render('administrateur/specialite/modifier.html.twig',[
           'form' => $form->createView(),  'utilisateur' => $specialite]);
       
    }
    #[Route('/search', name: 'spe_search')]

    public function search(Request $request, SpecialiteRepository $specialiteRepository): Response
    {
        $spe = $request->query->get('specialite');
    
        if (!$spe) {
            return $this->redirectToRoute('app_specialite');
        }
    
        $specialite = $specialiteRepository->findBydomaine($spe);
    
        return $this->render('administrateur/specialite/liste.html.twig', [
            'specialite' => $specialite,
        ]);

       
    }
}
