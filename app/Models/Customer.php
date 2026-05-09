<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'contact_number',
    ];

    public function getFullName(){
        return $this->first_name . " " . $this->last_name;
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }
}
