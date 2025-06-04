<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Waste;

class SellTransactionItem extends Model
{
    protected $fillable = [
    'transaction_id',
    'waste_id',
    'quantity',
    'subtotal_point',
];
    /**
     * Get the waste associated with this sell transaction item
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
   public function waste() {
    return $this->belongsTo(Waste::class);
}

public function transaction() {
    return $this->belongsTo(SellTransaction::class, 'transaction_id');
}

}
