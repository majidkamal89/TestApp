<?php
/**
 * Created by PhpStorm.
 * User: Vb-003
 * Date: 2/7/2018
 * Time: 9:51 PM
 */

namespace App\Services;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class BlogValidationService
{

    public function validateForm($request)
    {
        $validator = Validator::make($request, [
            'title' => 'required|min:3',
            'content' => 'required|min:3',
            'country_id' => 'required',
            'city_id' => 'required',
            'state_id' => 'required',
            'area_id' => 'required',
        ]);
        if($validator->fails()){
            return ['status' => 1, 'message' => $validator->errors()->all()];
        }
        return ['status' => 0, 'message' => ['Success']];
    }

}