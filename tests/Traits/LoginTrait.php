<?php

namespace App\Tests\Traits;

use ApiPlatform\Symfony\Bundle\Test\Client;

trait LoginTrait
{
    public function getToken(Client $client, string $username, string $password): mixed
    {
        $response = $client->request('POST', '/auth', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'username' => $username,
                'password' => $password,
            ],
        ]);

        $json = $response->toArray();

        return $json['token'] ?? null;
    }
}
