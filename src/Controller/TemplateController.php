<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TemplateController extends AbstractController{
    /**
     * @Route("/back", name="back")
     */
    public function baseBack(){
        return $this->render('backbase.html.twig');

    }
    /**
     * @Route("", name="")
     */
    #[Route('/front', name: 'front')]

    public function basefront(){
        return $this->render('frontUsers.html.twig');

    }
}