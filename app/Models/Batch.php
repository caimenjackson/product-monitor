<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity',
        'cooked_at',
        'expires_at',
        'fresh_sold',
        'waste',
        'expired_sold',
    ];

    protected $casts = [
        'cooked_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
