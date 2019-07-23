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

    private function distance($lat1, $lon1, $lat2, $lon2) {
      if (($lat1 == $lat2) && ($lon1 == $lon2)) {
        return 0;
      } else {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1))
            * sin(deg2rad($lat2))
            + cos(deg2rad($lat1))
            * cos(deg2rad($lat2))
            * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $meters = $miles * 1609.34;
        return $meters;
      }
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
