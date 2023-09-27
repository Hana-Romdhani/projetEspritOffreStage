<?php

namespace App\Controller;
use App\Form\ProfileformType;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
use App\Form\UserPasswordType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
class ProfileController extends AbstractController
{
    

    #[Route('/parametrer', name: 'app_gerer_utilisateur_param')]
    public function parameter(Request $request, UtilisateurRepository $utilisateurRepository): Response
    {
        // $utilisateur = new Utilisateur();
        // $form = $this->createForm(UtilisateurType::class, $utilisateur);
        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $utilisateurRepository->save($utilisateur, true);

        //     return $this->redirectToRoute('app_gerer_utilisateur_index');
        // }

        return $this->renderForm('/profile/Paramétragecompte.html.twig', [
            // 'utilisateur' => $utilisateur,
            // 'form' => $form,
        ]);
    }

    #[Route('/profile/edit', name: 'app_gerer_utilisateur_edit')]
    public function editController(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userRepository = $entityManager->getRepository(Utilisateur::class);
        
        $nom = $request->get('nom');
        $prenom = $request->get('prenom');
        $numero = $request->get('numero');
        $address = $request->get('address');
        $email = $request->get('Email');
    
        $user = $userRepository->findOneByEmail($email);
    
        if ($user === null) {
            // l'utilisateur n'a pas été trouvé dans la base de données
            $this->addFlash('erreur', 'Cet utilisateur n\'existe pas.');
            return $this->redirectToRoute('app_gerer_utilisateur_edit');
        }
    
        $user->setNom($nom);
        $user->setPrenom($prenom);
        $user->setNumeroTel($numero);
        $user->setAddress($address);
        $user->setEmail($email);
        $entityManager->persist($user);

        $entityManager->flush();
        $this->addFlash('success', 'Profil mis à jour avec succès !');
        
        return $this->render('/profile/Paramétragecompte.html.twig', [
            // Ajoutez les variables que vous souhaitez passer à votre template ici
        ]);
    }
    // #[Route('/utilisateur/edition/{id}', name: 'user.edit', methods: ['GET', 'POST'])]
    // public function edit(
    //     User $choosenUser,
    //     Request $request,
    //     EntityManagerInterface $manager,
    //     UserPasswordHasherInterface $hasher
    // ): Response {
    //     $form = $this->createForm(UserType::class, $choosenUser);

    //     $form->handleRequest($request);
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         if ($hasher->isPasswordValid($choosenUser, $form->getData()->getPlainPassword())) {
    //             $user = $form->getData();
    //             $manager->persist($user);
    //             $manager->flush();

    //             $this->addFlash(
    //                 'success',
    //                 'Les informations de votre compte ont bien été modifiées.'
    //             );

    //             return $this->redirectToRoute('recipe.index');
    //         } else {
    //             $this->addFlash(
    //                 'warning',
    //                 'Le mot de passe renseigné est incorrect.'
    //             );
    //         }
    //     }

    //     return $this->render('pages/user/edit.html.twig', [
    //         'form' => $form->createView(),
    //     ]);
    // }
    // #[Route('/profile/editionmotdepasse/{id}', name: 'user_edit_password', methods: ['GET', 'POST'])]
    // public function editPassword(
    //     Utilisateur $choosenUser,
    //     Request $request,
    //     EntityManagerInterface $manager,
    //     UserPasswordHasherInterface $hasher
    // ): Response {
    //     $form = $this->createForm(UserPasswordType::class, $choosenUser);
    //      $new=$request->get('new mot de passe');

    //      $pass=$request->get('Mot de passe');
    //     $form->handleRequest($request);
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         if ($hasher->isPasswordValid($choosenUser, $pass)) {
    //             $choosenUser->setDate(new \DateTimeImmutable());
    //             $choosenUser->setPassword($new
                  
    //             );

    //             $this->addFlash(
    //                 'success',
    //                 'Le mot de passe a été modifié.'
    //             );

    //             $manager->persist($choosenUser);
    //             $manager->flush();

    //             return $this->redirectToRoute('app_gerer_utilisateur_param');
    //         } else {
    //             $this->addFlash(
    //                 'warning',
    //                 'Le mot de passe renseigné est incorrect.'
    //             );
    //         }
    //     }

    //     return $this->render('/profile/editpassword.html.twig', [
    //         'form' => $form->createView()
    //     ]);
    // }


    #[Route('/profile/editionmotdepasse/{id}', name: 'user_edit_password', methods: ['GET', 'POST'])]
public function editPassword(Utilisateur $choosenUser, Request $request,EntityManagerInterface $manager,UserPasswordHasherInterface $hasher): Response {
  

   
   
   
    $form = $this->createForm(UserPasswordType::class, $choosenUser); 
    //$data = $form->getData();
    //$choosenUser = $manager->getRepository(Utilisateur::class)->findOneBy(['username' => $data['username']]);

    $form->handleRequest($request);//$data->getPassword()['first']$data->getPassword()['second']
    if ($form->isSubmitted() && $form->isValid()) {
        $passwordData = $form->get('password')->getData();

        // if ($hasher->isPasswordValid($choosenUser,$passwordData)) {

            // if ($choosenUser && $hasher->isPasswordValid($choosenUser, $data['password']['first'])) {

            $choosenUser->setDate(new \DateTimeImmutable());
            $choosenUser->setPassword(
                $hasher->hashPassword($choosenUser,$passwordData)
            );

            $this->addFlash(
                'success',
                'Le mot de passe a été modifié.'
            );

            $manager->persist($choosenUser);
            $manager->flush();

            return $this->redirectToRoute('app_gerer_utilisateur_param');
        // } else {
        //     $this->addFlash(
        //         'warning',
        //         'Le mot de passe renseigné est incorrect.'
        //     );
        // }
    }

    return $this->render('/profile/editpassword.html.twig', [
        'form' => $form->createView()
    ]);
}
    

#[Route('/userprofile', name: 'app_user_profile')]
    public function userprofile(Request $request): Response
    { 
        
       

        return $this->renderForm('profile/ProfileUser.html.twig', [
          
        ]);
    }
    #[Route('/userprofile/editionmotdepasse/{id}', name: 'edit_password', methods: ['GET', 'POST'])]
public function editPassworduser(Utilisateur $choosenUser, Request $request,EntityManagerInterface $manager,UserPasswordHasherInterface $hasher): Response {
  

   
   
   
    $form = $this->createForm(UserPasswordType::class, $choosenUser); 
    //$data = $form->getData();
    //$choosenUser = $manager->getRepository(Utilisateur::class)->findOneBy(['username' => $data['username']]);

    $form->handleRequest($request);//$data->getPassword()['first']$data->getPassword()['second']
    if ($form->isSubmitted() && $form->isValid()) {
        $passwordData = $form->get('password')->getData();

        // if ($hasher->isPasswordValid($choosenUser,$passwordData)) {

            // if ($choosenUser && $hasher->isPasswordValid($choosenUser, $data['password']['first'])) {

            $choosenUser->setDate(new \DateTimeImmutable());
            $choosenUser->setPassword(
                $hasher->hashPassword($choosenUser,$passwordData)
            );

            $this->addFlash(
                'success',
                'Le mot de passe a été modifié.'
            );

            $manager->persist($choosenUser);
            $manager->flush();

            return $this->redirectToRoute('app_user_profile');
        // } else {
        //     $this->addFlash(
        //         'warning',
        //         'Le mot de passe renseigné est incorrect.'
        //     );
        // }
    }

    return $this->render('/profile/modifiermotdepasse.html.twig', [
        'form' => $form->createView()
    ]);
}
   
}
