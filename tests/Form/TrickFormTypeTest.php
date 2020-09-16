<?php

namespace App\Tests\Form;

use App\Repository\TrickRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TrickFormTypeTest extends WebTestCase
{
    public function testMembercreatesNewTrickfromForm()
    {
        // create client and login, to be able to create a new tricl
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $jimmy = $userRepository->findOneBy(['username' => 'jimmy']);
        $client->loginUser($jimmy);

        $client->followRedirects();

        // request creation page and submit newTrick form
        $client->request('GET', '/new');
        $client->submitForm('Enregistrer', [
            'trick_form[title]' => 'titre de nouveau trick de test',   
            'trick_form[description]' => 'description de nouveau trick de test',  
            'trick_form[category]' => '3',       
        ]);
        
        // tests
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('titre de nouveau trick de test', $client->getResponse()->getContent());
        $this->assertContains('Votre trick a été ajouté !', $client->getResponse()->getContent());
    }
}