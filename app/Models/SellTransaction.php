<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SellTransaction
 *
 * Model ini digunakan untuk mengelola data transaksi penjualan
 * yang dilakukan oleh user. Satu SellTransaction memiliki banyak
 * SellTransactionItem dan dimiliki oleh satu User. Model ini juga
 * memiliki relasi dengan Waste melalui SellTransactionItem.
 *
 * @package App\Models
 */
class SellTransaction extends Model
{
    protected $fillable = [
        'user_id',
        'address',
        // 'phone_number',
        'phone',
        'pickup_date',
    ];

    /**
     * Hubungan antara model SellTransaction dengan SellTransactionItem.
     * Satu SellTransaction memiliki banyak SellTransactionItem.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items() {
        return $this->hasMany(SellTransactionItem::class, 'transaction_id');
    }

    /**
     * Hubungan antara model SellTransaction dengan User.
     * Satu SellTransaction dimiliki oleh satu User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Hubungan antara model SellTransaction dengan Waste.
     * Satu SellTransaction menggunakan banyak Waste.
     * Hubungan ini dihubungkan oleh SellTransactionItem.
     * Dan memiliki tambahan kolom quantity dan subtotal_point.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function wastes() {
        return $this->belongsToMany(Waste::class, 'sell_transaction_items', 'transaction_id', 'waste_id', '')
                    ->withPivot('quantity', 'subtotal_point')
                    ->withTimestamps();
    }
}

