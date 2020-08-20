<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TricksController extends AbstractController
{
    /**
     * 
     * 
     * @Route("/", name="app_home")
     */
    public function showHome(): Response
    {
        $latestTricks = $this->getDoctrine()->getRepository(Trick::class)->findAllWithFeatured();

        return $this->render('home.html.twig', [
            'tricks' => $latestTricks,
        ]);
    }

    /**
     * Matches /trick/*
     * 
     * @Route("/trick/{id}", name="app_trick", requirements={"id"="\d+"})
     */
    public function showTrick($id): Response
    {
        $trick = $this->getDoctrine()->getRepository(Trick::class)->findOneByIdWithCategoryAndFeatured($id);
        $comments = $this->getDoctrine()->getRepository(Comment::class)->getCommentsFromTrick($id);
        $images = $this->getDoctrine()->getRepository(Image::class)->getImagesFromTrick($id);
        $videos = $this->getDoctrine()->getRepository(Video::class)->getVideosFromTrick($id);
    
        return $this->render('trick.html.twig', [
            'trick' => $trick,
            'comments' => $comments,
            'images' => $images,
            'videos' => $videos
        ]);
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function showLogin(): Response
    {
        return $this->render('login.html.twig');
    }

    /**
     * @Route("/signin", name="app_signin")
     */
    public function showSignin(): Response
    {
        return $this->render('signin.html.twig');
    }

    /**
     * @Route("/forgot", name="app_forgot")
     */
    public function showForgotPassword(): Response
    {
        return $this->render('forgot.html.twig');
    }

    /**
     * @Route("/reset", name="app_reset")
     */
    public function showResetPassword(): Response
    {
        return $this->render('reset.html.twig');
    }
}
