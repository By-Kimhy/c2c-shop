<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $fillable = ['name','email','password','role'];

    public function products(){ return $this->hasMany(Product::class); }
    public function orders(){ return $this->hasMany(Order::class); }
    public function isSeller(){ return $this->role === 'seller'; }
    public function isAdmin(){ return $this->role === 'admin'; }
}
