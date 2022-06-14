<?php namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_authenticate_using_the_login()
    {
        $user = User::factory()->create();

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ], ['Accept' => 'application/json']);

        $response->assertStatus(200)
            ->assertJsonStructure(
                [
                    'user' => [
                        'id' , 'name','email','email_verified_at','created_at','updated_at',
                    ],
                    'access_token'
                ]
            );
    }

    public function test_can_register_an_user()
    {
        $userData = $this->userData();
        $userData['password_confirmation'] = 'testtest';

        $response = $this->post('/api/register', $userData, ['Accept' => 'application/json']);

        $response->assertStatus(201)
            ->assertJsonStructure(
                [
                    'user' => [
                      'name','email','created_at','updated_at','id',
                    ],
                    'access_token'
                ]
            );
    }

    public function test_missing_password_confirmation_with_code_422()
    {
        $userData = $this->userData();

        $response = $this->post('/api/register', $userData, ['Accept' => 'application/json']);
        $response->assertStatus(422)
            ->assertJsonStructure(
                [
                   'message',
                    'errors' => [
                        "password"
                    ]
                ]
            );

    }
}
