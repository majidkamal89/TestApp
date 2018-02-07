<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CountryModel;
use Illuminate\Support\Facades\View;

class CountryController extends Controller
{

    public function __construct()
    {
        $this->country = new CountryModel();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $result = $this->country->index();
            return response()->json($result);
        }
        return View::make('country.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $delete = CountryModel::find($request->id)->delete();
        return response()->json(['status' => 1]);
    }

    /**
     * Display a country with city,state,area.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCountryData(){
        return $this->country->getAllData();
    }
}
