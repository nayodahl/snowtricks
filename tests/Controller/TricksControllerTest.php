<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TrickControllerTest extends WebTestCase
{
    //////// ALLOWED ////////////
    public function testVisitorCanAccessHomepage()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString('Snowtricks', $client->getResponse()->getContent());
    }      

    public function testVisitorCanAccessSingleTrick()
    {
        $client = static::createClient();
        $client->request('GET', '/trick/backside-air');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString('ajouté le', $client->getResponse()->getContent());        
    }

    public function testMemberCanAccessEditTrick()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);

        $jimmy = $userRepository->findOneBy(['username' => 'jimmy']);
        $client->loginUser($jimmy);

        $client->request('GET', '/edit/backside-air');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString('Modifiez le titre', $client->getResponse()->getContent());  
    }

    public function testMemberCanAccessNewTrick()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);

        $jimmy = $userRepository->findOneBy(['username' => 'jimmy']);
        $client->loginUser($jimmy);

        $client->request('GET', '/new');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString('Nouveau Trick', $client->getResponse()->getContent());  
    }
    
    //////////////// FORBIDDEN //////////
    public function testVisitorCantAccessEditTrick()
    {
        $client = static::createClient();
        $client->request('GET', '/edit/backside-air');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    } 

    public function testVisitorCantAccessNewTrick()
    {
        $client = static::createClient();
        $client->request('GET', '/new');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    } 

    public function testVisitorCantAccessDeleteTrick()
    {
        $client = static::createClient();
        $client->request('GET', '/delete/backside-air');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testVisitorCantAccessEditFeatured()
    {
        $client = static::createClient();
        $client->request('GET', '/featured/4/9');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testVisitorCantAccessRemoveFeatured()
    {
        $client = static::createClient();
        $client->request('GET', '/unfeatured/4');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}