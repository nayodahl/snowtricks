<?php

namespace App\Controller;

use App\Form\ChangePasswordFormType;
use App\Form\UserFormType;
use App\Service\UploaderHelper;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Controller used to manage current user.
 *
 * @IsGranted("ROLE_USER")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/profile", methods="GET|POST", name="app_profile")
     */
    public function editProfile(Request $request, UploaderHelper $uploaderHelper): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setLastUpdate(new DateTime());

            $uploadedFile = $form['photo']->getData();
            if ($uploadedFile) {
                $newFilename = $uploaderHelper->uploadAvatar($uploadedFile);
                $user->setPhoto($newFilename);
            }

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Votre profil a été mis à jour !');

            return $this->redirectToRoute('app_profile');
        }

        return $this->render('profile.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profile/change-password", methods="GET|POST", name="app_change_password")
     *
     * @IsGranted("ROLE_USER")
     */
    public function changePassword(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($encoder->encodePassword($user, $form->get('plainPassword')->getData()));
            $user->setLastUpdate(new DateTime());
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Votre mot de passe a été modifié !');

            return $this->redirectToRoute('app_profile');
        }

        return $this->render('change_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
