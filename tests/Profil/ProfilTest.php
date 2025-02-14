<?php

namespace App\Tests\Profil;

use App\Tests\Traits\LoginTrait;
use Symfony\Component\HttpFoundation\Response;
use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class ProfilTest extends ApiTestCase
{
    use LoginTrait;

    /**
     * testAccessRouteMeWithUserNotLogged.
     *
     * @dataProvider getDataProviderRoutes
     */
    public function testAccessRouteMeWithUserNotLogged(string $method): void
    {
        $client = self::createClient();
        $client->request($method, '/api/me');

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * getDataProviderRoutes.
     *
     * @return array<array<string>>
     */
    public static function getDataProviderRoutes(): array
    {
        return [
            ['GET'],
            ['PUT'],
        ];
    }

    /**
     * testAccessRouteMeWithUserLogged.
     */
    public function testAccessRouteMeWithUserLogged(): void
    {
        $client = self::createClient();
        $token = $this->getToken($client, 'admin', '0000');
        $client->request('GET', '/api/me', ['auth_bearer' => $token]);

        $this->assertResponseIsSuccessful();
    }

    /**
     * testReadProperties.
     */
    public function testReadProperties(): void
    {
        $client = self::createClient();
        $token = $this->getToken($client, 'admin', '0000');
        $client->request('GET', '/api/me', ['auth_bearer' => $token]);

        $response = $client->request('GET', '/api/me', ['auth_bearer' => $token]);
        $json = $response->toArray();

        $this->assertArrayNotHasKey('password', $json);
    }

    public function testEditProfil(): void
    {
        $client = self::createClient();
        $token = $this->getToken($client, 'admin', '0000');

        $client->request('PUT', '/api/me', [
            'auth_bearer' => $token,
            'headers' => ['Content-Type' => 'application/ld+json'],
            'json' => [
                'email' => 'email@domaine.fr',
            ],
        ]);

        $this->assertResponseIsSuccessful();
    }
}
