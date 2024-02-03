<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EndpointsTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_clients_returns_a_successful_response(): void
    {
        $response = $this->get('/api/clients');

        $response->assertStatus(200);
    }
    public function test_accounts_returns_a_successful_response(): void
    {
        $response = $this->get('/api/accounts');

        $response->assertStatus(200);
    }
    public function test_transactions_returns_a_successful_response(): void
    {
        $response = $this->get('/api/transactions');

        $response->assertStatus(200);
    }
}
