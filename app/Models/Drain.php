<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Flight;

class Drain extends Model
{
    protected $fillable = ['flight_id', 'name', 'sn', 'percent', 'temperature'];

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }
}
