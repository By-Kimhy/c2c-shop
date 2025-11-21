<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SellerProfile extends Model
{
    protected $fillable = [
        'user_id',
        'shop_name',
        'slug',
        'phone',
        'address',
        'logo',
        'banner',
        'description',
        'status',
        'verified_at',
    ];

    // auto-generate slug if not provided
    public static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->slug) && !empty($model->shop_name)) {
                $model->slug = Str::slug($model->shop_name) . '-' . Str::random(4);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }
}
