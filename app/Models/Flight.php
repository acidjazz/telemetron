<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Battery;
use App\Models\Location;

class Flight extends Model
{
    protected $fillable = ['id', 'name', 'sn'];

    protected $appends = ['locationCount'];

    public $incrementing = false;

    public function batteries()
    {
        return $this->hasMany(Battery::class);
    }

    public function getLocationCountAttribute()
    {
        return $this->locations()->count();
    }


    public function locations()
    {
        return $this->hasMany(Location::class);
    }

}
