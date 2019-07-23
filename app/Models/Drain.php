<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Flight;

class Drain extends Model
{
    protected $fillable = ['battery_id', 'percent', 'temperature'];

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }
}
