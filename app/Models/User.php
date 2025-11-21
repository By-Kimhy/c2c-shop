<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    // protected $fillable = ['name','email','password','role'];
    protected $guarded = []; // quick: allow mass assignment for seeding/testing
    public $timestamps = true;

    public function products(){ return $this->hasMany(Product::class); }
    public function orders(){ return $this->hasMany(Order::class); }
    public function isAdmin(){ return $this->role === 'admin'; }

    public function roles()
    {
        return $this->belongsToMany(\App\Models\Role::class, 'role_user');
    }

    // Check if user has a role
    public function hasRole($name)
    {
        return $this->roles()->where('name', $name)->exists();
    }   
    // Check if user has any role in array
    public function hasAnyRole(array $roles)
    {
        return $this->roles->pluck('name')->intersect($roles)->isNotEmpty();
    }

    public function sellerProfile()
    {
        return $this->hasOne(\App\Models\SellerProfile::class);
    }

    public function isSeller()
    {
        // role pivot or role string - you have roles pivot, so:
        return $this->hasRole('seller') || $this->hasAnyRole(['seller']);
    }


}
