<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class Mailer
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendSigninMessage(User $user)
    {
        $email = (new TemplatedEmail())
        ->from(new Address('hello@snowtricks.nayo.cloud', 'SnowTricks'))
        ->to(new Address($user->getEmail(), $user->getUsername()))
        ->context([
            'user' => $user,
        ])
        ->subject('Validation de votre inscription au site SnowTricks')
        ->text('Bonjour et bienvenue sur le site Snowtricks')
        ->htmlTemplate('email/signin.html.twig');

        $this->mailer->send($email);
    }

    public function sendPasswordResetMessage(User $user, string $resetToken)
    {
        $email = (new TemplatedEmail())
        ->from(new Address('hello@snowtricks.nayo.cloud', 'SnowTricks'))
        ->to($user->getEmail())
        ->subject('Votre demande de réinitialisation de mot de passe')
        ->context([
            'resetToken' => $resetToken,
            'tokenLifetime' => 2,
        ])
        ->htmlTemplate('email/reset.html.twig');

        $this->mailer->send($email);
    }
}
