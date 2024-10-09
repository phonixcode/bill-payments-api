<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransactionControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_transaction_successfully()
    {
        $user = User::factory()->create();
        $data = [
            'user_id' => $user->id,
            'amount' => 90.50,
            'description' => 'Test Transaction',
            'status' => 'completed',
        ];

        $response = $this->postJson('/api/transactions', $data);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'status',
                     'message',
                     'data' => [
                         'id', 'user_id', 'amount', 'description', 'created_at', 'updated_at'
                     ]
                 ]);

        $this->assertDatabaseHas('transactions', ['amount' => 90.50]);
    }

    /** @test */
    public function it_fails_to_create_a_transaction_due_to_validation_errors()
    {
        $data = [
            'user_id' => null,
            'amount' => -10,
            'description' => ''
        ];

        $response = $this->postJson('/api/transactions', $data);

        $response->assertStatus(422)
                 ->assertJsonStructure([
                     'status',
                     'message',
                     'errors' => ['user_id', 'amount', 'description']
                 ]);
    }

    /** @test */
    public function it_fetches_a_transaction_successfully()
    {
        $transaction = Transaction::factory()->create();

        $response = $this->getJson("/api/transactions/{$transaction->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'Transaction retrieved successfully',
                     'data' => [
                         'id' => $transaction->id,
                         'user_id' => $transaction->user_id,
                         'amount' => $transaction->amount,
                     ]
                 ]);
    }

    /** @test */
    public function it_updates_a_transaction_successfully()
    {
        $transaction = Transaction::factory()->create();

        $data = [
            'amount' => 200.00,
            'description' => 'Updated Description',
        ];

        $response = $this->putJson("/api/transactions/{$transaction->id}", $data);

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'Transaction updated successfully',
                     'data' => [
                         'amount' => 200.00,
                         'description' => 'Updated Description',
                     ]
                 ]);

        $this->assertDatabaseHas('transactions', ['amount' => 200.00]);
    }

    /** @test */
    public function it_deletes_a_transaction_successfully()
    {
        $transaction = Transaction::factory()->create();

        $response = $this->deleteJson("/api/transactions/{$transaction->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('transactions', ['id' => $transaction->id]);
    }

    /** @test */
    public function it_returns_not_found_for_non_existing_transaction()
    {
        $response = $this->getJson('/api/transactions/9999');

        $response->assertStatus(404)
                ->assertJson([
                    'status' => 'error',
                    'message' => 'Resource not found'
                ]);
    }
}

