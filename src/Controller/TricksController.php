<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use App\Repository\ImageRepository;
use App\Repository\TrickRepository;
use App\Repository\VideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TricksController extends AbstractController
{
    /**
     * @Route("/", defaults={"page": "1", "_format"="html"}, methods="GET", name="app_home")
     *
     * @Route("/{page<[1-9]\d*>}", defaults={"_format"="html"}, methods="GET", name="app_home_paginated")
     */
    public function showHome(int $page = 1, TrickRepository $trickRepo): Response
    {
        $latestTricks = $trickRepo->findAllWithFeatured($page);

        return $this->render('home.html.twig', [
            'tricks' => $latestTricks,
        ]);
    }

    /**
     * @Route("/trick/{id}", defaults={"page": "1", "_format"="html"}, methods="GET", name="app_trick", requirements={"id"="\d+"})
     *
     * @Route("/trick/{id}/{page<[1-9]\d*>}", defaults={"_format"="html"}, methods="GET", name="app_trick_paginated", requirements={"id"="\d+"})
     */
    public function showTrick(int $id, int $page = 1, TrickRepository $trickRepo, CommentRepository $commentRepo, ImageRepository $imageRepo, VideoRepository $videoRepo): Response
    {
        $trick = $trickRepo->findOneByIdWithCategoryAndFeatured($id);
        $latestComments = $commentRepo->findAllCommentsFromTrick($id, $page);
        $images = $imageRepo->getImagesFromTrick($id);
        $videos = $videoRepo->getVideosFromTrick($id);

        return $this->render('trick.html.twig', [
            'trick' => $trick,
            'comments' => $latestComments,
            'images' => $images,
            'videos' => $videos,
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
