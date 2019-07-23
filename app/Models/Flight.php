<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Battery;
use App\Models\Location;
use Spatie\Geocoder\Facades\Geocoder;
use Carbon\Carbon;



class Flight extends Model
{
    protected $fillable = ['id', 'name', 'sn'];

    protected $appends = ['duration', 'takeOff', 'landing'];

    public $incrementing = false;

    public function batteries()
    {
        return $this->hasMany(Battery::class);
    }

    public function getLocationCountAttribute()
    {
        return $this->locations()->count();
    }

    private function getGeo($location)
    {
            $geo = Geocoder::getAddressForCoordinates(
                $location['location']->getLat(),
                $location['location']->getLng()
            );
            unset($geo['address_components']);
            return $geo;
    }

    private function distance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
        cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }

    public function getDistanceAttribute()
    {
        $distance = 0;
        $prev_lat = false;
        $prev_lng = false;
        foreach ($this->locations as $location) {
            if ($prev_lat !== false) {
                $distance += $this->distance(
                    $location['location']->getLat(),
                    $location['location']->getLng(),
                    $prev_lat,
                    $prev_lng
                );
            }
            $prev_lat = $location['location']->getLat();
            $prev_lng = $location['location']->getLng();
        }
        return $distance;
    }

    public function getDurationAttribute()
    {
        if (!$this->locationFirst) {
            return null;
        }
        return
            $this->locationLast->created_at
            ->diffInSeconds($this->locationFirst->created_at);
    }

    public function getTakeoffAttribute()
    {
        if ($this->locationFirst) {
            return $this->getGeo($this->locationFirst);
        }
        return null;
    }

    public function getlandingAttribute()
    {
        if ($this->locationLast) {
            return $this->getGeo($this->locationFirst);
        }
        return null;
    }

    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    public function locationFirst()
    {
        return $this->hasOne(Location::class)->oldest();
    }
    public function locationLast()
    {
        return $this->hasOne(Location::class)->latest();
    }

}
