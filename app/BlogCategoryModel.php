<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogCategoryModel extends Model
{
    protected $table = 'blog_categories';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'blog_id', 'category_id'
    ];

    public function saveBlogCategory($dataArray){
        $result = self::where('blog_id', $dataArray[0]['blog_id'])->delete();
        return self::insert($dataArray);
    }

    public function category(){
        return $this->belongsTo('App\CategoryModel');
    }
}
