<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderApiTest extends TestCase
{
    use RefreshDatabase;
    public $created;
    public function test_it_creates_lists_and_updates_order_status(): void
    {
        // Create
        $this->created = $this->postJson('/api/orders', [
            'customer_name' => 'Alice',
            'item_name' => 'USB-C Cable',
            'price' => 9.99,
            'status' => 'pending',
        ])->assertCreated()->json();

        // List
        $this->getJson('/api/orders')
            ->assertOk()
            ->assertJsonFragment(['customer_name' => 'Alice']);

        // Update status
        $this->patchJson('/api/orders/'.$this->created['id'], ['status' => 'paid'])
            ->assertOk()
            ->assertJsonFragment(['status' => 'paid']);
    }

    
}
