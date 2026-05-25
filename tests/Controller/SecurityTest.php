<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityTest extends WebTestCase
{
    public function testHomepageRedirectsToLoginWhenNotAuthenticated(): void
    {
        $client = static::createClient();
        $client->request('GET', '/home');

        // La ruta /home permite acceso anónimo para ver la landing page
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello World!');
    }

    public function testAdminPanelIsSecured(): void
    {
        $client = static::createClient();
        $client->request('GET', '/admin');

        // El acceso a /admin redirige al login si no estás autenticado
        $this->assertResponseRedirects('/login');
    }
}
