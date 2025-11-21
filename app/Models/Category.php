<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name','slug'];

    protected static function booted()
    {
        static::creating(function ($c) { $c->slug = Str::slug($c->name) . '-' . substr(uniqid(), -6); });
    }

    public function products() { return $this->hasMany(Product::class); }
}
