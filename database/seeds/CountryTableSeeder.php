<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountryTableSeeder extends Seeder
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
                'name' => 'Afghanistan',
                'status' => 0
            ],
            [
                'name' => 'Belgium',
                'status' => 0
            ],
            [
                'name' => 'Canada',
                'status' => 0
            ],
            [
                'name' => 'Denmark',
                'status' => 0
            ],
            [
                'name' => 'Egypt',
                'status' => 0
            ]
        );

        $cities['Afghanistan'] = array(['name' => 'Bombuflat'],['name' => 'Garacharma'],['name' => 'Chirala']);
        $cities['Belgium'] = array(['name' => 'Amozoc'],['name' => 'Atlixco'],['name' => 'Caltenco']);
        $cities['Canada'] = array(['name' => 'Ocotlan'],['name' => 'Puebla'],['name' => 'Sanctorum']);
        $cities['Denmark'] = array(['name' => 'Tecali'],['name' => 'Tenango'],['name' => 'Zaragoza']);
        $cities['Egypt'] = array(['name' => 'Amazcala'],['name' => 'Colon'],['name' => 'Jalpan']);

        foreach($dataArray as $key => $data) {
            $countryId = DB::table('countries')->insertGetId($data);
            for($i=$key; $i<=$key; $i++){
                for($j=0; $j<count($cities[$data['name']]); $j++){
                    $cities[$data['name']][$j]['country_id'] = $countryId;
                }
            }
            foreach($cities[$data['name']] as $key1 => $city){
                $cityId = DB::table('cities')->insertGetId($city);
                $stateAray = [];
                for($i=0; $i<=2; $i++){
                    array_push($stateAray, ['name' => $city['name'].' - state'.($i+1), 'city_id' => $cityId]);
                }
                foreach($stateAray as $key2 => $state){
                    $stateId = DB::table('states')->insertGetId($state);
                    $areaAray = [];
                    for($i=0; $i<=2; $i++){
                        array_push($areaAray, ['name' => $state['name'].' - area'.($i+1), 'state_id' => $stateId]);
                    }
                    foreach($areaAray as $area){
                        DB::table('area')->insert($area);
                    }
                }
            }
        }
    }
}
