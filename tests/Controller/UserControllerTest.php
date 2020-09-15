<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testVisitorCantAccessProfile()
    {
        $client = static::createClient();
        $client->request('GET', '/profile');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testVisitorCantAccessChangePassword()
    {
        $client = static::createClient();
        $client->request('GET', '/profile/change-password');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testMemberCanAccessEditProfile()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);

        $jimmy = $userRepository->findOneBy(['username' => 'jimmy']);
        $client->loginUser($jimmy);

        $client->request('GET', '/profile');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString('Changez votre identifiant de connexion (pseudo)', $client->getResponse()->getContent());  
    }

    public function testMemberCanAccessChangePassword()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);

        $jimmy = $userRepository->findOneBy(['username' => 'jimmy']);
        $client->loginUser($jimmy);

        $client->request('GET', '/profile/change-password');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString('Nouveau mot de passe', $client->getResponse()->getContent());  
    }
}