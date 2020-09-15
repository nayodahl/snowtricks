<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testVisitorCanAccessLogin()
    {
        $client = static::createClient();
        $client->request('GET', '/login');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString('Connexion', $client->getResponse()->getContent());        
    }

    public function testVisitorCanAccessSignin()
    {
        $client = static::createClient();
        $client->request('GET', '/signin');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString('Inscription', $client->getResponse()->getContent());        
    }
}