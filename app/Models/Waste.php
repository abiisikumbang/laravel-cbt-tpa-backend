<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Class Waste
 *
 * Model ini digunakan untuk mengelola data waste (sampah).
 * Satu waste memiliki nama, satuan, nilai point, dan gambar.
 * Model ini digunakan pada proses penjualan.
 *
 * @property int $id
 * @property string $name
 * @property string $satuan
 * @property int $point_value
 * @property string $image
 *
 * @package App\Models
 */
class Waste extends Model
{
    protected $fillable = [
        'id',
        'name',
        'satuan',
        'point_value',
        'image',
    ];

    protected static function booted()
    {
        static::deleting(function ($waste) {
            if ($waste->image && Storage::disk('public')->exists($waste->image)) {
                Storage::disk('public')->delete($waste->image);
            }
        });
    }
}

