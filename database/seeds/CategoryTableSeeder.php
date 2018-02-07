<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataArray = array(
            [
                'name' => 'Technology'
            ],
            [
                'name' => 'Social Media'
            ],
            [
                'name' => 'Business'
            ],
            [
                'name' => 'Entertainment'
            ],
            [
                'name' => 'Design'
            ]
        );
        foreach($dataArray as $key => $val){
            $result = DB::table('categories')->insertGetId($val);
        }
    }
}
