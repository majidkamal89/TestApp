<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StateModel extends Model
{
    protected $table = 'states';

    public function city(){
        return $this->belongsTo('App\CityModel', 'city_id', 'id');
    }

    public function area(){
        return $this->hasMany('App\AreaModel', 'state_id', 'id');
    }

    public function show($id){
        return self::where('city_id', $id)->where('status', 0)->get();
    }
}
