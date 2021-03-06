<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Flight;
use App\Models\Battery;

class Aircraft extends Model
{
    protected $fillable = ['name', 'sn'];

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }
}
