<?php

use App\Models\Customer;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Payment;
use App\Models\Rice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function createOrderForPayment(float $totalAmount = 100.00): Order
{
    $customer = Customer::create([
        'first_name' => 'Maria',
        'last_name' => 'Santos',
        'contact_number' => '09171234567',
    ]);

    $rice = Rice::create([
        'rice_name' => 'Jasmine',
        'price' => 50,
        'qty' => 100,
        'description' => 'Fragrant rice',
    ]);

    $order = Order::create([
        'user_id' => User::factory()->create()->id,
        'customer_id' => $customer->id,
        'total_amount' => number_format($totalAmount, 2, '.', ''),
    ]);

    Order_item::create([
        'rices_id' => $rice->id,
        'order_id' => $order->id,
        'qty' => 2,
        'subtotal' => number_format($totalAmount, 2, '.', ''),
    ]);

    return $order;
}

it('shows the payment history page', function () {
    $user = User::factory()->create();
    $order = createOrderForPayment();

    Payment::create([
        'order_id' => $order->id,
        'amount_paid' => 25,
        'payment_status' => 'unpaid',
    ]);

    $this->actingAs($user)
        ->get(route('payments.index'))
        ->assertSuccessful()
        ->assertSee('Payment Transactions');
});

it('records a payment and marks it paid when the balance is covered', function () {
    $user = User::factory()->create();
    $order = createOrderForPayment(100);

    $this->actingAs($user)
        ->post(route('payments.store'), [
            'order_id' => $order->id,
            'amount_paid' => 100,
        ])
        ->assertRedirect(route('sale.show', $order));

    $this->assertDatabaseHas('payments', [
        'order_id' => $order->id,
        'amount_paid' => '100.00',
        'payment_status' => 'paid',
    ]);
});

it('updates a payment status', function () {
    $user = User::factory()->create();
    $order = createOrderForPayment();

    $payment = Payment::create([
        'order_id' => $order->id,
        'amount_paid' => 25,
        'payment_status' => 'unpaid',
    ]);

    $this->actingAs($user)
        ->put(route('payments.update', $payment), [
            'payment_status' => 'paid',
        ])
        ->assertRedirect();

    $this->assertDatabaseHas('payments', [
        'id' => $payment->id,
        'payment_status' => 'paid',
    ]);
});
