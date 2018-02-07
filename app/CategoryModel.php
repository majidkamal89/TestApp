<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'status'
    ];

    public function index(){
        return self::get();
    }

    public function savePost($dataArray){
        if(!empty($dataArray['id'])){
            return self::updateOrCreate(['id'=>$dataArray['id']],['name'=>$dataArray['name']]);
        }
        return self::Create($dataArray);
    }
}
