<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CityModel extends Model
{
    protected $table = 'cities';

    public function country(){
        return $this->belongsTo('App\CountryModel', 'country_id', 'id');
    }

    public function state(){
        return $this->hasMany('App\StateModel', 'city_id', 'id');
    }

    public function show($id){
        return self::where('country_id', $id)->where('status', 0)->get();
    }
}
