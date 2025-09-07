<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RoboRoadNodes extends Model
{
    protected $table = 'RoboRoadNodes';
    protected $primaryKey = 'NodeId';
    public $incrementing = false;
    protected $fillable = ['NodeId', 'NodeName', 'NodeAddress'];
}
