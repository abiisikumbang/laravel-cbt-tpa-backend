<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;



/**
 * Class RewardRedeem
 *
 * Model ini digunakan untuk mengelola data penukaran reward.
 * Satu RewardRedeem memiliki banyak RewardRedeemItem dan dimiliki oleh satu User.
 * Model ini juga memiliki relasi dengan Stock melalui RewardRedeemItem.
 *
 * @package App\Models
 */
class RewardRedeem extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'total_points_spent',
        'status',
    ];

    /**
     * Mendapatkan daftar item reward redeem.
     *
     * Satu RewardRedeem memiliki banyak RewardRedeemItem. Relasi ini digunakan untuk
     * mendapatkan daftar item reward yang dibeli oleh user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(RewardRedeemItem::class, 'reward_redeem_id');
    }

    /**
     * Mendapatkan user yang melakukan penukaran reward.
     *
     * Satu RewardRedeem dimiliki oleh satu User. Relasi ini digunakan untuk
     * mendapatkan data user yang melakukan penukaran reward.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function redeemItems(): HasMany
    {
        return $this->hasMany(RewardRedeemItem::class);
    }

    /**
     * Mendapatkan stock yang terkait dengan penukaran reward.
     *
     * Satu RewardRedeem memiliki banyak Stock. Relasi ini digunakan untuk
     * mendapatkan daftar stock yang dibeli oleh user dan berapa banyak poin yang
     * dibutuhkan untuk membeli stock tersebut. Relasi ini dihubungkan oleh
     * RewardRedeemItem.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function stocks(): BelongsToMany
    {
        return $this->belongsToMany(Stock::class, 'reward_redeem_items', 'reward_redeem_id', 'stock_id')
                    ->withPivot(['quantity', 'point_spent_per_item']) // Kolom-kolom di tabel pivot
                    ->withTimestamps() // created_at dan updated_at di tabel pivot
                    ->using(RewardRedeemItem::class); // Menggunakan model pivot kustom
    }
}

