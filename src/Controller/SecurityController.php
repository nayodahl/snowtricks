<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(AuthenticationUtils $authenticationUtils): Response
    {
        throw new \Exception('Will be intercepted before getting here');
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
