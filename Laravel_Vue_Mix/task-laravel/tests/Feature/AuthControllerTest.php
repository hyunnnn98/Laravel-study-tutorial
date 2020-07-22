<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_user_can_be_register()
    {
        $this->withoutExceptionHandling();
        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        $response = $this->post('/api/register', $data);

        // 넘어온 JSON값의 Key Value 까지 확인 가능하다.
        $response->assertStatus(201)
            ->assertJsonStructure(['user']);

        $this->assertDatabaseHas('users', [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
        ]);
    }
}
