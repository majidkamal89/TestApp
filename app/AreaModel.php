<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AreaModel extends Model
{
    protected $table = 'area';

    public function state(){
        return $this->belongsTo('App\StateModel', 'state_id', 'id');
    }

    public function show($id){
        return self::where('state_id', $id)->where('status', 0)->get();
    }
}
