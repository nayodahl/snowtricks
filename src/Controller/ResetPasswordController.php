<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Form\ResetPasswordRequestFormType;
use App\Service\Mailer;
use DateInterval;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/reset-password")
 */
class ResetPasswordController extends AbstractController
{
    /**
     * Display & process form to request a password reset.
     *
     * @Route("", name="app_forgot_password_request")
     */
    public function request(Request $request, Mailer $mailer): Response
    {
        $this->denyAccessUnlessGranted('IS_ANONYMOUS');

        $form = $this->createForm(ResetPasswordRequestFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->processSendingPasswordResetEmail($form->get('email')->getData(), $mailer);
        }

        return $this->render('request.html.twig', [
            'requestForm' => $form->createView(),
        ]);
    }

    /**
     * Confirmation page after a user has requested a password reset.
     *
     * @Route("/check-email", name="app_check_email")
     */
    public function checkEmail(): Response
    {
        $this->denyAccessUnlessGranted('IS_ANONYMOUS');

        return $this->render('check_email.html.twig', [
            'tokenLifetime' => 2,
        ]);
    }

    /**
     * Validates and process the reset URL that the user clicked in their email.
     *
     * @Route("/reset/{token}", name="app_reset_password", requirements={"token"="[0-9a-zA-Z]{32}"} )
     */
    public function resetPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder, string $token = null): Response
    {
        $this->denyAccessUnlessGranted('IS_ANONYMOUS');

        if (null === $token) {
            $this->addFlash('error', 'Il y a eu un problème pour valider votre demande');

            return $this->redirectToRoute('app_forgot_password_request');
        }

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy([
            'token' => $token,
        ]);

        if (null === $user) {
            $this->addFlash('error', 'Il y a eu un problème pour valider votre demande, veuillez vérifier votre lien ou refaire une demande');

            return $this->redirectToRoute('app_forgot_password_request');
        }

        //check if token has been inserted less than 2h app_forgot_password_request
        $creation = $user->getLastUpdate();
        $creation->add(new DateInterval('PT2H')); // add 2 hours
        $now = new DateTime();
        if ($creation < $now) {
            $this->addFlash('error', 'Votre demande n\'est plus valide, veuillez refaire une demande');

            return $this->redirectToRoute('app_forgot_password_request');
        }

        // The token is valid; allow the user to change their password.
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // A password reset token should be used only once, remove it.
            $user->setToken(null);

            // Encode the plain password, and set it.
            $encodedPassword = $passwordEncoder->encodePassword(
                $user,
                $form->get('plainPassword')->getData()
            );

            $user->setPassword($encodedPassword)->setLastUpdate(new DateTime());
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Votre mot de passe a été réinitialisé ! Vous pouvez vous connecter');

            return $this->redirectToRoute('app_home', ['_fragment' => 'tricks']);
        }

        return $this->render('reset.html.twig', [
            'resetForm' => $form->createView(),
        ]);
    }

    private function processSendingPasswordResetEmail(string $emailFormData, Mailer $mailer): RedirectResponse
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy([
            'email' => $emailFormData,
        ]);

        // Do not reveal whether a user account was found or not.
        if (!$user) {
            return $this->redirectToRoute('app_check_email');
        }

        // Do not reveal whether the found user is activated or not.
        if (false === $user->getActivated()) {
            return $this->redirectToRoute('app_check_email');
        }

        // generate token (length 32) and insert in User
        $user->setToken(bin2hex(random_bytes(16)))
        // this lastUpdate info will be used to check the age of the reset request
            ->setLastUpdate(new DateTime());

        // save entity
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        // send mail
        $mailer->sendPasswordResetMessage($user, $user->getToken());

        return $this->redirectToRoute('app_check_email');
    }
}
