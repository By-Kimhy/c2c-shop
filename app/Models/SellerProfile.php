<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SellerProfile extends Model
{

    use SoftDeletes;
    use HasFactory;
    protected $table = 'seller_profiles';

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

    protected $casts = [
        'verified_at' => 'datetime',
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
