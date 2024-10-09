<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /** @test */
    public function it_creates_a_user_successfully()
    {
        $data = [
            'name' => 'Alan Abiodun',
            'email' => 'alanson@example.com',
            'password' => 'Secret2024',
        ];

        $response = $this->postJson('/api/users', $data);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'status',
                     'message',
                     'data' => [
                         'id', 'name', 'email', 'created_at', 'updated_at'
                     ]
                 ]);

        $this->assertDatabaseHas('users', ['email' => 'alanson@example.com']);
    }

    /** @test */
    public function it_fails_to_create_a_user_due_to_validation_errors()
    {
        $data = [
            'name' => '',
            'email' => 'invalid-email',
            'password' => 'short',
        ];

        $response = $this->postJson('/api/users', $data);

        $response->assertStatus(422)
                 ->assertJsonStructure([
                     'status',
                     'message',
                     'errors' => ['name', 'email', 'password']
                 ]);
    }

    /** @test */
    public function it_fetches_a_user_successfully()
    {
        $user = User::factory()->create();

        $response = $this->getJson("/api/users/{$user->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'User retrieved successfully',
                     'data' => [
                         'id' => $user->id,
                         'name' => $user->name,
                         'email' => $user->email,
                     ]
                 ]);
    }

    /** @test */
    public function it_updates_a_user_successfully()
    {
        $user = User::factory()->create();

        $data = [
            'name' => 'Updated Name',
            'email' => $user->email,
        ];

        $response = $this->putJson("/api/users/{$user->id}", $data);

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'User updated successfully',
                     'data' => [
                         'name' => 'Updated Name',
                     ]
                 ]);

        $this->assertDatabaseHas('users', ['name' => 'Updated Name']);
    }

    /** @test */
    public function it_deletes_a_user_successfully()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson("/api/users/{$user->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /** @test */
    public function it_returns_not_found_for_non_existing_user()
    {
        $response = $this->getJson('/api/users/9999');

        $response->assertStatus(404)
                 ->assertJson([
                     'status' => 'error',
                     'message' => 'Resource not found'
                 ]);
    }
}

