<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoboRoadNodes extends Model
{
    protected $table = 'RoboRoadNodes';
    protected $primaryKey = 'NodeId';
    public $incrementing = false;
    protected $fillable = ['NodeId', 'NodeName', 'NodeAddress'];
}
