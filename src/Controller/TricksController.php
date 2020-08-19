<?php

namespace App\Controller;

use App\Entity\Trick;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TricksController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function showHome(): Response
    {
        $latestTricks = $this->getDoctrine()->getRepository(Trick::class)->findAllWithImage();

        return $this->render('home.html.twig', [
            'tricks' => $latestTricks,
        ]);
    }

    /**
     * @Route("/trick/{id}")
     */
    public function showTrick($id): Response
    {
        $trick = $this->getDoctrine()->getRepository(Trick::class)->findOneByIdWithMedia($id);

        return $this->render('trick.html.twig', [
            'trick' => $trick[0],
        ]);
    }

    /**
     * @Route("/login")
     */
    public function showLogin(): Response
    {
        return $this->render('login.html.twig');
    }

    /**
     * @Route("/signin")
     */
    public function showSignin(): Response
    {
        return $this->render('signin.html.twig');
    }

    /**
     * @Route("/forgot")
     */
    public function showForgotPassword(): Response
    {
        return $this->render('forgot.html.twig');
    }

    /**
     * @Route("/reset")
     */
    public function showResetPassword(): Response
    {
        return $this->render('reset.html.twig');
    }
}
