<?php

namespace App\Tests\Service;

use App\Entity\User;
use App\Service\Mailer;
use DateTime;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\WebpackEncoreBundle\Asset\EntrypointLookupInterface;
use Twig\Environment;

class MailerTest extends TestCase
{
    public function testSendSigninMessage()
    {
        $symfonyMailer = $this->createMock(MailerInterface::class);
        $symfonyMailer->expects($this->once())
            ->method('send');

        $twig = $this->createMock(Environment::class);
        $entrypointLookup = $this->createMock(EntrypointLookupInterface::class);

        $user = new User();
        $user->setUsername('jimmy')
        ->setPassword('jimmy')
        ->setEmail('jimmy@snowtricks.fr')
        ->setPhoto('jimmy-avatar.jpg')
        ->setActivated('1')
        ->setCreated(new DateTime())
        ->setLastUpdate(new DateTime());

        $mailer = new Mailer($symfonyMailer, $twig, $entrypointLookup);
        $email = $mailer->sendSigninMessage($user);
    }
}
