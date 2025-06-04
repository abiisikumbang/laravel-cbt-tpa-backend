<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellTransaction extends Model
{
    protected $fillable = [
        'user_id',
        'address',
        'phone_number',
        'pickup_date',
    ];

    public function items() {
        return $this->hasMany(SellTransactionItem::class, 'transaction_id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}

