<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $casts = ['payload'=>'array'];
    protected $fillable = ['order_id','amount','currency','status','provider','provider_ref','payload'];
    public function order()
    {
        return $this->belongsTo(\App\Models\Order::class);
    }

}

