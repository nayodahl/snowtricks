<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Trick;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TricksController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function showHome(): Response
    {
        $latestTricks = $this->getDoctrine()->getRepository(Trick::class)->findAllWithImage();

        return $this->render('home.html.twig', [
            'tricks' => $latestTricks,
        ]);
    }

    /**
     * @Route("/trick/{id}", name="app_trick")
     */
    public function showTrick($id): Response
    {
        $trick = $this->getDoctrine()->getRepository(Trick::class)->findOneByIdWithMedia($id);
        $comments = $this->getDoctrine()->getRepository(Comment::class)->getCommentsFromTrick($id);
    
        return $this->render('trick.html.twig', [
            'trick' => $trick,
            'comments' => $comments
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
