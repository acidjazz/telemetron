<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Flight;

class Battery extends Model
{
    protected $fillable = ['flight_id', 'name', 'sn'];

    protected $appends = ['drainCount'];

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }
    public function drains()
    {
        return $this->hasMany(Drain::class);
    }

    public function getDrainCountAttribute()
    {
        return $this->drains()->count();
    }

}
