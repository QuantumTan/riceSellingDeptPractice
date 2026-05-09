<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_item extends Model
{
    /** @use HasFactory<\Database\Factories\OrderItemFactory> */
    use HasFactory;

    //     $table->foreignId('rice_id')->constrained();
    // $table->foreignId('order_id')->constrained()->cascadeOnDelete();
    // $table->decimal('qty', 10, 2);
    // $table->decimal('subtotal', 10, 2);


    protected $fillable = [
        'rice_id',
        'order_id',
        'qty',
        'subtotal',
    ];

    public function rice()
    {
        return $this->belongsTo(Rice::class);
    }


    public function orders()
    {
        return $this->belongsTo(Order::class);
    }
}
