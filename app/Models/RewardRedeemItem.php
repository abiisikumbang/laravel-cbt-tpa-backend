<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RewardRedeemItem extends Model
{
    /**
     * Fillable fields yang diizinkan untuk diisi.
     *
     * @var array
     */
    protected $fillable = [
        'reward_redeem_id',
        'stock_id',
        'quantity',
        'point_spent_per_item',
    ];
    /**
     * Hubungan antara model RewardRedeemItem dengan Stock.
     * Satu RewardRedeemItem memiliki satu Stock.
     * Hubungan ini digunakan untuk mendapatkan data waste yang dibeli.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stock() {
        return $this->belongsTo(Stock::class);
    }

    /**
     * Hubungan antara model RewardRedeemItem dengan RewardRedeem.
     * Satu RewardRedeemItem dimiliki oleh satu RewardRedeem.
     * Hubungan ini digunakan untuk mendapatkan data RewardRedeem yang terkait dengan item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
   public function rewardRedeem(): BelongsTo
    {
        return $this->belongsTo(RewardRedeem::class);
    }
}

