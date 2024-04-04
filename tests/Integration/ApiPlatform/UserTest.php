<?php

namespace App\Tests\Integration\ApiPlatform;

use App\Tests\AbstractApiTestCase;

class UserTest extends AbstractApiTestCase
{
    public function test_get_clients(): void
    {
        $response = $this->client()->request('GET', '/api/users');

        $this->assertResponseIsSuccessful();

        $this->assertCount(2, $response->toArray()['hydra:member']);

        $this->assertJsonEquals([
            "@context" => "/api/contexts/User",
            "@id" => "/api/users",
            "@type" => "hydra:Collection",
            "hydra:totalItems" => 2,
            "hydra:member" => [
                [
                    "@id" => "/api/users/1",
                    "@type" => "User",
                    "id" => 1,
                    "email" => "test_user@test.com",
                    "roles" => ["ROLE_USER"],
                    "userGroup" => "standard",
                    "userPermissions" => []
                ],
                [
                    "@id" => "/api/users/2",
                    "@type" => "User",
                    "id" => 2,
                    "email" => "dev_user@test.com",
                    "roles" => ["ROLE_USER"],
                    "userGroup" => "standard",
                    "userPermissions" => []
                ]
            ]
        ]);
    }

    public function test_create_user_is_successfull(): void
    {
        $response = $this->client()->request('POST', '/api/users', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                "email" => "new_user@test.com",
                "roles" => ["ROLE_USER"],
                "plainPassword" => "test232"
            ],
        ]);
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(201);

        $this->assertJsonEquals([
            "@context" => "/api/contexts/User",
            "@id" => "/api/users/3",
            "@type" => "User",
            "id" => 3,
            "email" => "new_user@test.com",
            "roles" => ["ROLE_USER"],
        ]);
    }

    public function test_update_user_is_successfull(): void
    {
        $response = $this->client()->request('PUT', '/api/users/2', [
            'json' => [
                "@id" => "/api/users/2",
                "email" => "new_user@test.com",
                "plainPassword" => "test255",
                "userGroup" => "standard"
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);

        $this->assertJsonEquals([
            "@context" => "/api/contexts/User",
            "@id" => "/api/users/2",
            "@type" => "User",
            "id" => 2,
            "email" => "new_user@test.com",
            "roles" => ["ROLE_USER"],
            "userGroup" => "standard"
        ]);
    }

    public function test_delete_user_is_successfull(): void
    {

    }
}