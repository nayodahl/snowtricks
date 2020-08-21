<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Entity\User;
use App\Form\Type\CommentFormType;
use App\Form\Type\TrickFormType;
use App\Repository\CommentRepository;
use App\Repository\ImageRepository;
use App\Repository\TrickRepository;
use App\Repository\UserRepository;
use App\Repository\VideoRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/trick/{id}", defaults={"page": "1", "_format"="html"}, name="app_trick", requirements={"id"="\d+"})
     *
     * @Route("/trick/{id}/{page<[1-9]\d*>}", defaults={"_format"="html"}, name="app_trick_paginated", requirements={"id"="\d+"})
     */
    public function showTrick(Request $request, int $id, int $page = 1, TrickRepository $trickRepo, CommentRepository $commentRepo, ImageRepository $imageRepo, VideoRepository $videoRepo): Response
    {
        // getting data
        $trick = $trickRepo->findOneByIdWithCategoryAndFeatured($id);
        $latestComments = $commentRepo->findAllCommentsFromTrick($id, $page);
        $images = $imageRepo->getImagesFromTrick($id);
        $videos = $videoRepo->getVideosFromTrick($id);

        // comment form generation
        $form = $this->createForm(CommentFormType::class);

        // handling comment form POST request if any
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();  
            $comment->setCreated(new DateTime());
            $comment->setLastUpdate(new DateTime());
            $comment->setUser($this->getDoctrine()->getRepository(User::class)->find(201));   // temporary arbitrary user, waiting for authentication
            $comment->setTrick($this->getDoctrine()->getRepository(Trick::class)->find($id));

            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();
            $this->addFlash('success', 'Votre commentaire a été ajouté !');

            return $this->redirectToRoute('app_trick', ['id' => $id, '_fragment' => 'comments']);
        }

        return $this->render('trick.html.twig', [
            'trick' => $trick,
            'comments' => $latestComments,
            'images' => $images,
            'videos' => $videos,
            'commentForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", defaults={"_format"="html"}, name="edit_trick", requirements={"id"="\d+"})
     *
     */
    public function editTrick(Request $request, int $id, TrickRepository $trickRepo, ImageRepository $imageRepo, VideoRepository $videoRepo): Response
    {
        // getting data
        $trick = $trickRepo->findOneByIdWithCategoryAndFeatured($id);
        $images = $imageRepo->getImagesFromTrick($id);
        $videos = $videoRepo->getVideosFromTrick($id);

        // trick form generation
        $form = $this->createForm(TrickFormType::class);

        // handling comment form POST request if any
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $trick = $form->getData();  
            $trick->setCreated(new DateTime());
            $trick->setLastUpdate(new DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($trick);
            $em->flush();
            $this->addFlash('success', 'Votre trick a été ajouté !');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('editTrick.html.twig', [
            'trick' => $trick,
            'images' => $images,
            'videos' => $videos,
            'commentForm' => $form->createView(),
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
