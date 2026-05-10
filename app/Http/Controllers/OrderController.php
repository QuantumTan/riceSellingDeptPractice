<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Rice;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
// fetch the rice products
        $rices = Rice::orderBy('rice_name')->get();

        return view('sale.index', compact('rices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
                return redirect()->route('sale.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $validated = $request->validated();

        $order = DB::transaction(function () use ($validated, $request) {
            $customer = \App\Models\Customer::create([
                'first_name' => $validated['customer_first_name'],
                'last_name' => $validated['customer_last_name'],
                'contact_number' => $validated['customer_contact_number'],
            ]);

            $rices = Rice::query()
                ->whereIn('id', collect($validated['items'])->pluck('rice_id'))
                ->get()
                ->keyBy('id');

            $totalAmount = 0;
            $orderItems = [];

            foreach ($validated['items'] as $item) {
                $rice = $rices->get((int) $item['rice_id']);
                $quantity = (float) $item['qty'];
                $subtotal = round($quantity * (float) $rice->price, 2);

                $totalAmount += $subtotal;

                $orderItems[] = [
                    'rices_id' => $rice->id,
                    'qty' => $quantity,
                    'subtotal' => number_format($subtotal, 2, '.', ''),
                ];
            }

            $order = Order::create([
                'user_id' => $request->user()->id,
                'customer_id' => $customer->id,
                'total_amount' => number_format($totalAmount, 2, '.', ''),
            ]);

            $order->order_items()->createMany($orderItems);

            return $order;
        });

        $order->load(['customer', 'user', 'order_items.rices']);

        return redirect()->route('sale.show', $order)->with('success', 'Order saved successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(['customer', 'user', 'order_items.rices']);

        return view('sale.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
