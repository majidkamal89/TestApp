<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogModel extends Model
{
    protected $table = 'blogs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'content', 'image', 'country_id', 'city_id', 'state_id', 'area_id', 'status', 'created_at', 'updated_at'
    ];

    public function savePost($dataArray){
        if(!empty($dataArray['id'])){
            $update = self::where('id', $dataArray['id'])->update($dataArray);
            return $dataArray['id'];
        }
        return self::insertGetId($dataArray);
    }

    public function index(){
        return self::with(['blogCategory.category', 'country','city','state','area'])->latest()->get();
    }

    public function country(){
        return $this->hasOne('App\CountryModel', 'id', 'country_id')->orderBy('id', 'DESC');
    }

    public function city(){
        return $this->hasOne('App\CityModel', 'id', 'city_id')->orderBy('id', 'DESC');
    }

    public function state(){
        return $this->hasOne('App\StateModel', 'id', 'state_id')->orderBy('id', 'DESC');
    }

    public function area(){
        return $this->hasOne('App\AreaModel', 'id', 'area_id')->orderBy('id', 'DESC');
    }

    public function blogCategory(){
        return $this->hasMany('App\BlogCategoryModel', 'blog_id', 'id')->orderBy('blog_id', 'DESC');
    }
}
