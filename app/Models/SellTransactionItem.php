<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Waste;
use App\Models\SellTransaction;

/**
 * Class SellTransactionItem
 *
 * Model ini digunakan untuk mengelola data item transaksi penjualan.
 * Satu SellTransactionItem memiliki satu waste, waste yang dijual oleh user.
 * Satu SellTransactionItem juga dimiliki oleh satu sell transaction, sell transaction yang terkait dengan item.
 *
 * @package App\Models
 */
class SellTransactionItem extends Model
{
    protected $fillable = [
        'transaction_id',
        'waste_id',
        'quantity',
        'subtotal_point',
    ];

    /**
     * Satu SellTransactionItem memiliki satu waste, waste yang dibeli oleh pelanggan.
     * Relasi ini digunakan untuk mendapatkan data waste yang dibeli.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function waste()
    {
        return $this->belongsTo(Waste::class);
    }

    /**
     * Satu SellTransactionItem dimiliki oleh satu sell transaction, sell transaction yang terkait dengan item.
     * Relasi ini digunakan untuk mendapatkan data sell transaction yang terkait dengan item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaction()
    {
        return $this->belongsTo(SellTransaction::class, 'transaction_id');
    }
}

