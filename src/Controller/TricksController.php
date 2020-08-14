<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TricksController extends AbstractController
{
    /**
     * @Route("/")
     *
     */
    
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }

    /**
     * @Route("/trick")
     *
     */
    
    public function showTrick(): Response
    {
        return $this->render('trick.html.twig');
    }

        /**
     * @Route("/login")
     *
     */
    
    public function showLogin(): Response
    {
        return $this->render('login.html.twig');
    }
}
