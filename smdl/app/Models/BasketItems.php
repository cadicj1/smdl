<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BasketItems extends Model
{
    //

    protected $fillable =[
        'name',
        'type',
        'price'
    ];


    public function order(){
        return $this->belongsTo(Order::class);
    }
}
