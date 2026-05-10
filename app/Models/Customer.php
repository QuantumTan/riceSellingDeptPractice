<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'first_name',
        'last_name',
        'contact_number',
    ];

    public function getFullName(): string
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function orders() : HasMany
    {
        return $this->hasMany(Order::class);
    }
}
