<?php

namespace App\Security;

use App\Entity\Utilisateur;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Expr\Cast\String_;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Validator\Constraints\DateTime;

class UsersAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;
    private $urlGenerator;
    public const LOGIN_ROUTE = 'app_login';
    private  $entityManager;
    public function __construct(UrlGeneratorInterface $urlGenerator,EntityManagerInterface $entityManager)
    {
          $this->urlGenerator=$urlGenerator;
          $this->entityManager = $entityManager;


    }
    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email', '');

        $request->getSession()->set(Security::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName ): ?Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }
        // $user=$token->getUser();
        // $roles = $token->getUser()->getRoles();
        // $redirectRoute = '';
        // $aujourdhui = new  DateTimeImmutable();

        // if (in_array('admin', $roles)) {
        //     $redirectRoute = 'app_admin';
        //  //   $user->date = $aujourdhui;
        //     // $user->setDate();
        // }  else 
        // {
        //     $redirectRoute = 'app_test_front';
        //     // récupérer l'utilisateur actuellement authentifié
        
        // }
        // For example:

        // $roles = $token->getUser()->getRoles();
        
    
        // if (in_array('admin', $roles)) {
           
        //     return new RedirectResponse($this->urlGenerator->generate('app_admin')); 

        // } 
        // else {
           // $entityManager = $this->entityManager;
            // récupérer l'utilisateur actuellement authentifié
        //$client = $token->getUser();
        //

        //      return new RedirectResponse($this->urlGenerator->generate('app_test_front')); 
       
        // }
         
        //throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
        $userRepository =  $this->entityManager->getRepository(Utilisateur::class);
        
          $roles = $token->getUser()->getRoles();
           $user=$token->getUser();
           $user2 = $userRepository->findOneByEmail($user->getUsername());
           
           $aujourdhui = new \DateTime();

        if (in_array('Admin', $roles)) {
            $user2->setDatederniereconnx($aujourdhui);

            $this->entityManager->persist($user2);
            $this->entityManager->flush();
            return new RedirectResponse($this->urlGenerator->generate('app_admin'));
        } elseif ($user2->isVerified()==true ) {
            if ($user2->isIsdelete()==false ) {
               
                return new Response('vous avez désactiver tu peux envoyer un reclamation  ');
            }
            $user2->setDatederniereconnx($aujourdhui);

            $this->entityManager->persist($user2);
            $this->entityManager->flush();
            return new RedirectResponse($this->urlGenerator->generate('front'));
        }


        return new RedirectResponse($this->urlGenerator->generate('app_verificer'));


    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
