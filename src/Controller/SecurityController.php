<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginFormType;
use App\Form\SigninFormType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
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

        // login form generation
        $form = $this->createForm(LoginFormType::class);

        return $this->render('login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'loginForm' => $form->createView(),
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
    public function signin(AuthenticationUtils $authenticationUtils, Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $user = new User();
        $form = $this->createForm(SigninFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $user->setCreated(new DateTime());
            $user->setLastUpdate(new DateTime());
            $user->setActivated(false);

            // encode password from unmapped field 'plainPassword'
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('signin_form')['plainPassword']));

            // generate token (length 32) and insert in User
            $user->setToken(bin2hex(random_bytes(16)));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Votre inscription a été prise en compte, vous allez recevoir un mail pour confirmer et finaliser votre inscription !');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('signin.html.twig', [
            'signinForm' => $form->createView(),
        ]);
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
