<?php

namespace App\Tests;

use App\Entity\Portfolio;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PortfolioTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();  // Création d'un client test
        $client->request('GET', '/portfolio'); // Simuler une requéte avec le client
        $this->assertResponseIsSuccessful(); // Signifie que la page Portfolio se charge sans erreur serveur
    }
}
