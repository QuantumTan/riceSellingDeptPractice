<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rice extends Model
{
    /** @use HasFactory<\Database\Factories\RiceFactory> */
    use HasFactory;

            //     $table->id();
            // $table->enum('rice_name',['Jasmine, Brown, Dinorado']);
            // $table->decimal('price',10,2);
            // $table->decimal('qty', 10, 2);
            // $table->string('description');
            // $table->timestamps();
        // });

        protected $fillable = [
            'rice_name',
            'price',
            'qty',
            'description',
        ];

        public function order_items(){
            return $this->hasMany(Order_item::class);
        }
}
