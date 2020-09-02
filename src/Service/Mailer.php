<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

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
        ->from(new Address('contact@snowtricks.nayo.cloud', 'SnowTricks'))
        ->to(new Address($user->getEmail(), $user->getUsername()))
        ->context([
            'user' => $user,
        ])
        ->subject('Confirmation de votre inscription')
        ->text('Bonjour et bienvenue sur le site Snowtricks')
        ->htmlTemplate('email/signin.html.twig')
        ;

        $this->mailer->send($email);
    }
}
