<?php

namespace App\Http\Controllers;

use App\Models\CountrySetup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class CountrySetupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $country_info = CountrySetup::all();

        return view('country_setup.country_setup_list', compact('country_info'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('country_setup.country_setup');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'country_code' => ['required'],
        ]);

        $country_data = new CountrySetup();

        $country_data->name         = $request->name;
        $country_data->country_code = $request->country_code;
        $country_data->is_active    = 1;
        $country_data->created_by   = Auth::user()->id;
        $country_data->created_ip   = request()->ip();
        $country_data->created_at   = date('Y-m-d H:i:s');

        $save = $country_data->save();

        if($save){
            return redirect()->route('country-setup-list')->with('flash.message', 'Country  Sucessfully Added!')->with('flash.class', 'success');
        }else{
            return redirect()->route('country-setup-list')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
        }
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
        $country_data= CountrySetup::find($id);

        return view('country_setup.country_setup_edit', compact('country_data'));
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
        $validated = $request->validate([
            'name' => ['required'],
            'country_code' => ['required'],
        ]);

        $country_data =  CountrySetup::find($id);

        $country_data->name         = $request->name;
        $country_data->country_code = $request->country_code;
        $country_data->is_active    = 1;
        $country_data->created_by   = Auth::user()->id;
        $country_data->created_ip   = request()->ip();
        $country_data->created_at   = date('Y-m-d H:i:s');

        $save = $country_data->save();

        if($save){
            return redirect()->route('country-setup-list')->with('flash.message', 'Country  Sucessfully Updated!')->with('flash.class', 'success');
        }else{
            return redirect()->route('country-setup-list')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = CountrySetup::find($id);
        $delete->delete();

        if($delete){
            return redirect()->route('country-setup-list')->with('flash.message', 'Country  Sucessfully Deleted!')->with('flash.class', 'success');
        }else{
            return redirect()->route('country-setup-list')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
        }
    }
}
