<?php

namespace App\Http\Controllers;

use App\Models\AirlineSetup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class AirlineSetupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $airline_info = AirlineSetup::all();

        return view('airline_setup.airline_setup_list', compact('airline_info'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('airline_setup.airline_setup');
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
            'airline_title' => ['required'],
            'country_name'  => ['required'],
        ]);

        $airline_data = new AirlineSetup();

        $airline_data->airline_title = $request->airline_title;
        $airline_data->country_name  = $request->country_name;
        $airline_data->fare          = $request->fare;
        $airline_data->commission    = $request->commission;
        $airline_data->add           = $request->add;
        $airline_data->is_active     = 1;
        $airline_data->created_by    = Auth::user()->id;
        $airline_data->created_ip    = request()->ip();
        $airline_data->created_at    = date('Y-m-d H:i:s');

        $save = $airline_data->save();

        if($save){
            return redirect()->route('airline-setup-list')->with('flash.message', 'Airline  Sucessfully Added!')->with('flash.class', 'success');
        }else{
            return redirect()->route('airline-setup-list')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
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
        $airline_info = AirlineSetup::find($id);

        return view('airline_setup.airline_setup_edit', compact('airline_info'));
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
            'airline_title' => ['required'],
            'country_name'  => ['required'],
        ]);

        $airline_data =  AirlineSetup::find($id);

        $airline_data->airline_title = $request->airline_title;
        $airline_data->country_name  = $request->country_name;
        $airline_data->fare          = $request->fare;
        $airline_data->commission    = $request->commission;
        $airline_data->add           = $request->add;
        $airline_data->is_active     = 1;
        $airline_data->created_by    = Auth::user()->id;
        $airline_data->created_ip    = request()->ip();
        $airline_data->created_at    = date('Y-m-d H:i:s');

        $save = $airline_data->save();

        if($save){
            return redirect()->route('airline-setup-list')->with('flash.message', 'Airline  Sucessfully Updated!')->with('flash.class', 'success');
        }else{
            return redirect()->route('airline-setup-list')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
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
        $delete = AirlineSetup::find($id);
        $delete->delete();
        if($delete){
            return redirect()->route('airline-setup-list')->with('flash.message', 'Airline  Sucessfully Delated!')->with('flash.class', 'success');
        }else{
            return redirect()->route('airline-setup-list')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
        }
    }
}
