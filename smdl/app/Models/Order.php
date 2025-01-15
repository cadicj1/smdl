<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'address',
        'basket'
    ];


    public function basketItems(){
        return $this->hasMany(BasketItems::class);
    }
}
