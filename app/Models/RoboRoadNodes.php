<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RoboRoadNodes extends Model
{
    protected $table = 'RoboRoadNodes';
    protected $fillable = ['NodeID','NodeAddress'];
}
