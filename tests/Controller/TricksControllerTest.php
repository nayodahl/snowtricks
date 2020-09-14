<?php

namespace App\Tests\Controller;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Entity\User;
use DateTime;
use PHPUnit\Framework\TestCase;

class TricksControllerTest extends TestCase
{
    public function testCreateNewTrickWithoutMedia()
    {
        $trick = new Trick();
        $trick->setTitle('Titre test')
            ->setSlug('titre-test')
            ->setDescription('Description test')
            ->setCreated(new DateTime())
            ->setLastUpdate(new DateTime());

        $this->assertInstanceOf(Trick::class, $trick);
        $this->assertIsString($trick->getTitle());
        $this->assertIsString($trick->getDescription());
        $this->assertInstanceOf(DateTime::class, $trick->getCreated());
        $this->assertInstanceOf(DateTime::class, $trick->getLastUpdate());
    }

    public function testCreateNewComment()
    {
        $trick = new Trick();
        $trick->setTitle('Titre test')
            ->setSlug('titre-test')
            ->setDescription('Description test')
            ->setCreated(new DateTime())
            ->setLastUpdate(new DateTime());

        $user = new User();
        $user->setUsername('jimmy')
        ->setPassword('jimmy')
        ->setEmail('jimmy@snowtricks.fr')
        ->setPhoto('jimmy-avatar.jpg')
        ->setActivated('1')
        ->setCreated(new DateTime())
        ->setLastUpdate(new DateTime());

        $comment = new Comment();
        $comment->setContent('Commentaire de test');
        $comment->setCreated(new DateTime());
        $comment->setUser($user);
        $comment->setTrick($trick);

        $this->assertInstanceOf(Comment::class, $comment);
        $this->assertIsString($comment->getContent());
        $this->assertInstanceOf(DateTime::class, $comment->getCreated());
        $this->assertInstanceOf(User::class, $comment->getUser());
        $this->assertInstanceOf(Trick::class, $comment->getTrick());
    }

    public function testCreateNewTrickFormPersitsData()
    {
    }
}