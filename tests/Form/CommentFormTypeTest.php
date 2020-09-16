<?php

namespace App\Tests\Form;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommentFormTypeTest extends WebTestCase
{
    public function testMembercreatesCommentfromForm()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $jimmy = $userRepository->findOneBy(['username' => 'jimmy']);
        $client->loginUser($jimmy);

        $client->followRedirects();

        $client->request('GET', '/trick/backside-air');
        $client->submitForm('Ajouter un commentaire', [
            'comment_form[content]' => 'ceci est un commentaire de test',            
        ]);
        
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('ceci est un commentaire de test', $client->getResponse()->getContent());
    }
}