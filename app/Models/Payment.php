<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory;
            //  $table->id();
            // $table->foreignId('order_id')->constrained();
            // $table->decimal('amount_paid', 10, 2);
            // $table->enum('payment_status', ['paid', 'unpaid'])->default('unpaid');
            // $table->timestamps();

            protected $fillable = [
                'order_id',
                'amount_paid',
                'payment_status',
            ];

            public function order(){
                return $this->belongsTo(Order::class);
            }
}
