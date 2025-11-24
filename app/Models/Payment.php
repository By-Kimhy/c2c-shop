<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public const STATUS_PENDING   = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_FAILED    = 'failed';
    public const STATUS_PAID      = 'paid';

    protected $fillable = [
        'order_id',
        'amount',
        'currency',
        'status',
        'provider',
        'provider_ref',
        'payload',
        'md5',
        'paid_at',
    ];


    protected $casts = [
        'payload' => 'array',
        'amount' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
