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
        $number = random_int(0, 100);

        return $this->render('home.html.twig');
    }
}