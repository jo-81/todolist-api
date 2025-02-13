<?php

namespace App\Tests\Profil;

use App\Tests\Traits\LoginTrait;
use Symfony\Component\HttpFoundation\Response;
use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class ProfilTest extends ApiTestCase
{
    use LoginTrait;

    public function testAccessRouteMeWithUserNotLogged(): void
    {
        $client = self::createClient();
        $client->request('GET', '/api/me');

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    public function testAccessRouteMeWithUserLogged(): void
    {
        $client = self::createClient();
        $token = $this->getToken($client, 'admin', '0000');
        $client->request('GET', '/api/me', ['auth_bearer' => $token]);

        $this->assertResponseIsSuccessful();
    }

    public function testReadProperties(): void
    {
        $client = self::createClient();
        $token = $this->getToken($client, 'admin', '0000');
        $client->request('GET', '/api/me', ['auth_bearer' => $token]);

        $response = $client->request('GET', '/api/me', ['auth_bearer' => $token]);
        $json = $response->toArray();

        $this->assertArrayNotHasKey('password', $json);
    }
}
