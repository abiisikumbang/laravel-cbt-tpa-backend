<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Waste extends Model
{
  protected $fillable = [
    'name',
    'point_value',
    'image',
  ];
}
