<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
    ];

    /**
     * Get the orders for the customer
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
