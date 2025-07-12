<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'name',
        'point_cost',
        'stock',
        'image',
    ];

    public function rewardRedeemItems()
    {
        return $this->hasMany(RewardRedeemItem::class);
    }
}
