<?php

namespace App\Tests\Integration\ApiPlatform;

use App\Tests\AbstractApiTestCase;
use App\Tests\Utility\Attribute\Authentication\AuthenticateAs;
use Symfony\Component\HttpFoundation\Response;

class UserTest extends AbstractApiTestCase
{
    #[AuthenticateAs(username: 'admin_user@test.com')]
    public function test_admin_can_get_all_users(): void
    {
        $response = $this->request('GET', '/api/users');

        $this->assertResponseIsSuccessful();

        $this->assertCount(3, $response->toArray()['hydra:member']);

        $this->assertJsonEquals([
            "@context" => "/api/contexts/User",
            "@id" => "/api/users",
            "@type" => "hydra:Collection",
            "hydra:totalItems" => 3,
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
                ],
                [
                    "@id" => "/api/users/3",
                    "@type" => "User",
                    "id" => 3,
                    "email" => "admin_user@test.com",
                    "roles" => ["ROLE_USER", "ROLE_ADMIN"],
                    "userGroup" => "standard",
                    "userPermissions" => []
                ]
            ]
        ]);
    }

    #[AuthenticateAs(username: 'dev_user@test.com')]
    public function test_non_admin_cannot_get_all_users(): void
    {
        $response = $this->request('GET', '/api/users');

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    #[AuthenticateAs(username: 'dev_user@test.com')]
    public function test_non_admin_user_can_only_view_their_user_details(): void
    {
        $response = $this->request('GET', '/api/users/2');

        $this->assertResponseIsSuccessful();

        $this->assertJsonEquals([
            "@context" => "/api/contexts/User",
            "@id" => "/api/users/2",
            "@type" => "User",
            "id" => 2,
            "email" => "dev_user@test.com",
            "roles" => ["ROLE_USER"],
            "userGroup" => "standard",
            "userPermissions" => []
        ]);
    }

    #[AuthenticateAs(username: 'test_user@test.com')]
    public function test_non_admin_user_cannot_view_another_user_details(): void
    {
        $response = $this->request('GET', '/api/users/2');

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    #[AuthenticateAs(username: 'admin_user@test.com')]
    public function test_only_admin_users_can_create_user_successfully(): void
    {
        $response = $this->request('POST', '/api/users', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                "email" => "new_user@test.com",
                "roles" => ["ROLE_USER"],
                "plainPassword" => "test23255"
            ],
        ]);
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(201);

        $this->assertJsonEquals([
            "@context" => "/api/contexts/User",
            "@id" => "/api/users/4",
            "@type" => "User",
            "id" => 4,
            "email" => "new_user@test.com",
            "roles" => ["ROLE_USER"],
        ]);
    }

    #[AuthenticateAs(username: 'dev_user@test.com')]
    public function test_non_admin_users_cannot_create_users(): void
    {
        $response = $this->request('POST', '/api/users', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                "email" => "new_user@test.com",
                "roles" => ["ROLE_USER"],
                "plainPassword" => "test23255"
            ],
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    #[AuthenticateAs(username: 'dev_user@test.com')]
    public function test_user_can_update_their_user_details_successfull(): void
    {
        $response = $this->request('PUT', '/api/users/2', [
            'json' => [
                "@id" => "/api/users/2",
                "email" => "new_user@test.com",
                "plainPassword" => "test25577",
                "userGroup" => "standard"
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

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

    #[AuthenticateAs(username: 'test_user@test.com')]
    public function test_user_cannot_update_another_user_details(): void
    {
        $response = $this->request('PUT', '/api/users/2', [
            'json' => [
                "@id" => "/api/users/2",
                "email" => "new_user@test.com",
                "plainPassword" => "test25577",
                "userGroup" => "standard"
            ],
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    #[AuthenticateAs(username: 'admin_user@test.com')]
    public function test_admin_user_can_delete_users(): void
    {
        $response = $this->request('DELETE','/api/users/2');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);
    }

    #[AuthenticateAs(username: 'dev_user@test.com')]
    public function test_non_admin_user_cannot_delete_users(): void
    {
        $response = $this->request('DELETE','/api/users/2');

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }
}