<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountryModel extends Model
{
    protected $table = 'countries';

    public function index(){
        return self::get();
    }

    public function getAllData(){
        $result = self::with(['city.state.area'])->get();
        return response()->json($result);
    }

    public function city(){
        return $this->hasMany('App\CityModel', 'country_id', 'id')->orderBy('id', 'DESC');
    }

}
