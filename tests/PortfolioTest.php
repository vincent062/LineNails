<?php

namespace App\Tests;

use App\Entity\Portfolio;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PortfolioTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $client->request('GET', '/portfolio');
        $this->assertResponseIsSuccessful();
    }
}
