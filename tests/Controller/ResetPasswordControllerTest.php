<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ResetPasswordControllerTest extends WebTestCase
{
    public function testVisitorCanAccessResetPassword()
    {
        $client = static::createClient();
        $client->request('GET', '/reset-password');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString('Mot de passe oublié', $client->getResponse()->getContent());        
    }

    public function testVisitorCanAccessResetPasswordCheckEmail()
    {
        $client = static::createClient();
        $client->request('GET', '/reset-password/check-email');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString('pour réinitialiser votre mot de passe.', $client->getResponse()->getContent());        
    }
}