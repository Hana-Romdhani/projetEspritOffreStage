<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {      $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
        // if (!$this->getUser()) {
        //     // return login page
          
        // }
    
        // get the user's role
        // $userRole = $this->getUser()->getRoles()[0];
        // redirect based on user role
        // if ($userRole == 'admin') {
        //     return $this->redirectToRoute('app_admin');
        // } else {
        //     return $this->redirectToRoute('app_test_front');
        // }
    }

    #[Route(path: '/deconnexion', name: 'app_logout')]
    public function logout(): void
    {    
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


    #[Route('/role', name: 'app_role')]

    public function selectRole(Request $request): Response
    {
        if ($request->isXmlHttpRequest()) {
            // Requête Ajax, renvoyer le contenu de la boîte de dialogue
            $content = $this->renderView('registration/register.html.twig');
           return new JsonResponse(['content' => $content]);
            //return $this->redirectToRoute('app_register');
        }
    
        // Requête normale, afficher la page avec le lien pour ouvrir la boîte de dialogue
        return $this->render('role/select_role.html.twig');
         

    }




    
    #[Route('/verifierem', name: 'app_verificer')]

    public function verifier(Request $request): Response
    {
        
    
        return $this->render('/error-500.html');
         

    }
   




}
