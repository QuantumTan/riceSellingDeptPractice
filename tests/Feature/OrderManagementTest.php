<?php

use App\Models\Customer;
use App\Models\Order;
use App\Models\Rice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows the order form', function () {
    $user = User::factory()->create();

    Customer::create([
        'first_name' => 'Maria',
        'last_name' => 'Santos',
        'contact_number' => '09171234567',
    ]);

    Rice::create([
        'rice_name' => 'Jasmine',
        'price' => 55,
        'qty' => 100,
        'description' => 'Fragrant rice',
    ]);

    $this->actingAs($user)
        ->get(route('sale.index'))
        ->assertSuccessful()
        ->assertSee('Create a New Order');
});

it('stores a new order with its rice items', function () {
    $user = User::factory()->create();

    $rice = Rice::create([
        'rice_name' => 'Jasmine',
        'price' => 55,
        'qty' => 100,
        'description' => 'Fragrant rice',
    ]);

    $this->actingAs($user)
        ->post(route('sale.store'), [
            'customer_first_name' => 'Maria',
            'customer_last_name' => 'Santos',
            'customer_contact_number' => '09171234567',
            'items' => [
                [
                    'rice_id' => $rice->id,
                    'qty' => 2.5,
                ],
            ],
        ])
        ->assertRedirect();

    $order = Order::query()->with('order_items')->first();

    expect($order)->not->toBeNull();
    expect(number_format((float) $order?->total_amount, 2, '.', ''))->toBe('137.50');
    expect($order?->order_items)->toHaveCount(1);
    expect(number_format((float) $order?->order_items->first()?->subtotal, 2, '.', ''))->toBe('137.50');
    expect($order?->customer?->first_name)->toBe('Maria');
});