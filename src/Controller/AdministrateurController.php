<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/Admin')]
class AdministrateurController extends AbstractController
{
    #[Route('/', name: 'app_admin')]
    public function showpage(): Response
    {   // return new Response();
        return $this->redirectToRoute('stats');
    }
/*
    #[Route('/ListeUtilisateur', name: 'app_ListeUtilisateur')]
    public function ListeUtilisateur(UtilisateurRepository $repo): Response
    {
            $list=$repo->findAll();
        return $this->render('administrateur/listUtilisateur.html.twig',["utilisateur"=>$list ]);
    }*/

 #[Route('/liste', name: 'app_gerer_utilisateur_Liste')]
    public function index(UtilisateurRepository $utilisateurRepository,NormalizerInterface $nor): Response
    {       $utilisateurs = $utilisateurRepository->findBy(['isdelete' => true]);

              // $utnor=$nor->normalize($utilisateurs,'json');


      // $json= json_encode($utnor);
        // return new Response($json);
        
        return $this->render('administrateur/gerer_utilisateur/liste.html.twig', [
            'utilisateurs' => $utilisateurs
        ]);
    }
   

   


    #[Route('/liste_supprimer', name: 'app_gerer_utilisateur_Liste_supprimer')]
    public function index_supprimer(UtilisateurRepository $utilisateurRepository): Response
    {       $utilisateurs = $utilisateurRepository->findBy(['isdelete' => false]);
         
        return $this->render('administrateur/gerer_utilisateur/liste.html.twig', [
            'utilisateurs' => $utilisateurs
        ]);
    }
   
    #[Route('/restaurer/{idUtilisateur}', name: 'app_gerer_utilisateur_Liste_recup')]
        public function restore(EntityManagerInterface $entityManager, Utilisateur $utilisateur): Response
    { $session = $this->get('session');
        $utilisateur->setIsdelete(true);
        $entityManager->flush();
        $session->getFlashBag()->add('success', 'L\'utilisateur a été récuperer avec succès !');
        return $this->redirectToRoute('app_gerer_utilisateur_Liste');
    }
    
 #[Route('/detaille/{idUtilisateur}', name: 'app_gerer_utilisateur_detaille')]
    public function show(Utilisateur $utilisateur,SessionInterface $session): Response
    {         
        return $this->render('administrateur/gerer_utilisateur/detaille.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }
    #[Route('/modifier/{idUtilisateur}', name: 'app_gerer_utilisateur_modifier')]
    public function edit(Request $request, Utilisateur $utilisateur, UtilisateurRepository $utilisateurRepository,ManagerRegistry $doctrine,SessionInterface $session): Response
    {  
         $id=$request->get('idUtilisateur');
        $repo=$doctrine->getRepository(Utilisateur::class);

        $utilisateur=$repo->find($id);
        $form=$this->createForm(UtilisateurType::class,$utilisateur);

        $data = $form->getData();
       // dd($data);
       $session = $this->get('session');
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

                // Save only the modified fields

           
            
            $utilisateurRepository->save($utilisateur,true);
            //$em=$doctrine->getManager();
            //  $em->persist($student);
           // $em->flush();

            
           $session->getFlashBag()->add('success', 'L\'utilisateur a été modifier avec succès !');
            return $this->redirectToRoute("app_gerer_utilisateur_Liste");

        }
        
        return $this->render('administrateur/gerer_utilisateur/modifier.html.twig',[
           'form' => $form->createView(),  'utilisateur' => $utilisateur]);
       
    }

    #[Route('/search', name: 'utilisateur_search')]

    public function search(Request $request, UtilisateurRepository $utilisateurRepository): Response
    {
        $nom = $request->query->get('nom');
    
        if (!$nom) {
            return $this->redirectToRoute('app_gerer_utilisateur_Liste');
        }
    
        $utilisateur = $utilisateurRepository->findBynomUtilisateur($nom);
    
        return $this->render('administrateur/gerer_utilisateur/liste.html.twig', [
            'utilisateurs' => $utilisateur,
        ]);
    }
    #[Route('/tripardate', name: 'utilisateur_tripardate')]

    public function tripardate(Request $request, UtilisateurRepository $utilisateurRepository): Response
    {
        
    
      
        $utilisateur = $utilisateurRepository->findOrderByDatedecreation();
    
        return $this->render('administrateur/gerer_utilisateur/liste.html.twig', [
            'utilisateurs' => $utilisateur,
        ]);
    }
    #[Route('/tripardatesup', name: 'utilisateur_tripardatesup')]

    public function tripardatesup(Request $request, UtilisateurRepository $utilisateurRepository): Response
    {
        
    
      
        $utilisateur = $utilisateurRepository->findOrderByDatedecreationsup();
    
        return $this->render('administrateur/gerer_utilisateur/liste.html.twig', [
            'utilisateurs' => $utilisateur,
        ]);
    }

   

  

    #[Route('/supprimer/{idUtilisateur}', name: 'app_gerer_utilisateur_sup')]
    public function delete(ManagerRegistry $em, int $idUtilisateur): Response
    { $repo=$em->getRepository(Utilisateur::class);
        $utilisateur=$repo->find($idUtilisateur);
          $em=$em->getManager();
      

        if ($utilisateur) {
             $em->remove($utilisateur);
              $em->flush();
        }
    
        return $this->redirectToRoute('app_gerer_utilisateur_Liste',[
            'utilisateur' => $utilisateur,
       
        ]);
       
    }
    #[Route('/supprimer_modif/{idUtilisateur}', name: 'app_gerer_utilisateur_modif_sup')]
    public function delete_mod(EntityManagerInterface $entityManager, Utilisateur $utilisateur): Response
    {   
        $session = $this->get('session');
        $utilisateur->setIsdelete(false);
        $entityManager->flush();
        $session->getFlashBag()->add('success', 'L\'utilisateur a été désactiver avec succès !');

        return $this->redirectToRoute('app_gerer_utilisateur_Liste',[
            'utilisateur' => $utilisateur,
       
        ]);
       
    }
    // #[Route('/statistique', name: 'stats')]
    // public function Statistique(Request $request,UtilisateurRepository $utilisateurRepository)
    // {   
       


    // $loginCountByDay = $utilisateurRepository->getLoginCountByDay();

    // // Retourner les données sous forme de réponse JSON
    // return $this->json($loginCountByDay);
        

       
    // } 

#[Route('/statistiques', name: 'stats')]

#[Template('/administrateur/stats.html.twig')]

public function Statistiques(UtilisateurRepository $utilisateurRepository)
{
    $loginCountByDay = $utilisateurRepository->getLoginCountByDay();

    // Passer les données au template Twig pour générer le graphique
    //La fonction json_encode() est une fonction PHP qui prend une valeur PHP et la convertit en une chaîne de caractères JSON.
    return [
        'loginCountByDay' => json_encode($loginCountByDay),
    ];
}





    // public function searchAction(Request $request,UtilisateurRepository $utilisateurRepository):Response
    // {
    //     $searchTerm = $request->query->get('searchTerm');

    //     if (!$searchTerm) {
    //         return $this->redirectToRoute('app_gerer_utilisateur_Liste');
    //     }
    
    //     $utilisateursNom = $utilisateurRepository->findBy(['nom' => $searchTerm]);
    //     //$utilisateursNom = $utilisateurRepository->findBynomUtilisateur($searchTerm);

    //    /* $utilisateursPrenom = $utilisateurRepository->findBy(['prenom' => $searchTerm]);
    //     $utilisateursEmail = $utilisateurRepository->findBy(['prenom' => $searchTerm]);
    //     $utilisateurs = array_unique(array_merge($utilisateursNom ,$utilisateursPrenom, $utilisateursEmail), SORT_REGULAR);
    //    */ $response = new JsonResponse();
    //     $response->setData(array('results' => $utilisateursNom));
    //    // $response = JsonResponse::fromJsonString('$');

    //     return $response;
    // }
    #[Route('/recherajax', name: 'app_gerer_utilisateur_chercherajax')]

    public function searchAction(Request $request, UtilisateurRepository $utilisateurRepository): Response
    {
        $searchTerm = $request->query->get('searchTerm');
    
        if (!$searchTerm) {
            return $this->redirectToRoute('app_gerer_utilisateur_Liste');
        }
    
        $utilisateursNom = $utilisateurRepository->findBy(['nom' => $searchTerm]);
        
        $results = array();
        foreach ($utilisateursNom as $utilisateur) {
            $result = array(
                'nom' => $utilisateur->getNom(),
                'email' => $utilisateur->getEmail(),
                'prenom' => $utilisateur->getPrenom(),
                'gender' => $utilisateur->getGender(),
                
            );
            $results[] = $result;
        }
    
        $response = new JsonResponse();
        $response->setData(array('results' => $results));
    
        return $response;
    }

    
}
