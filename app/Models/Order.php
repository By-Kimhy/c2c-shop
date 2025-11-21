<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id','cart_id','order_number','subtotal','shipping_fee','total','currency','status','payment_method','payment_ref','shipping_name','shipping_phone','shipping_address','invoice_html'];
    public function user() { return $this->belongsTo(\App\Models\User::class); }
    public function items() { return $this->hasMany(\App\Models\OrderItem::class); }
    public function payments() { return $this->hasMany(\App\Models\Payment::class); }

}
