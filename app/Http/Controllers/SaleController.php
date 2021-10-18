<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AgentRecord;
use App\Models\AirlineSetup;
use App\Models\OrganizationSetup;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $agent_info   = AgentRecord::all();
        $airline_info = AirlineSetup::all();
        
        return view('sale.sale', compact('agent_info', 'airline_info'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function get_flight_setup_info(Request $request){

        $filght_id = $request->filght_value_id;
        $filght_info = AirlineSetup::where('id', $filght_id)->first();
        $organization_info = OrganizationSetup::first();

        return response()->json([
            'status' => true,
            'message' => 'Data get successfully',
            'data' => [
                'flight_data'       => $filght_info,
                'organization_data' => $organization_info,
            ]
        ]);    

        // echo "<pre>";
        // print_r($organization_data);exit;
        
    }
}
