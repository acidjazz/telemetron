<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;

class Location extends Model
{
    use SpatialTrait;
    protected $fillable = ['flight_id', 'location', 'created_at', 'updated_at'];
    protected $spatialFields = ['location'];
}
