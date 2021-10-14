<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AgentRecord;
use App\Models\Country;
use App\Models\State;
use Illuminate\Support\Facades\Auth;
use Session;

class AgentRecordController extends Controller
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
        $country = Country::all();
        $state   = State::all();
        return view('agent.add_agent', compact('country', 'state'));
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
            'name'         => ['required'],
            'mobile'       => ['required'],
            'company_name' => ['required'],
        ]);

        $agent_data = new AgentRecord();

        $agent_data->name            = $request->name;
        $agent_data->mobile          = $request->mobile;
        $agent_data->email           = $request->email;
        $agent_data->company_name    = $request->company_name;
        $agent_data->address         = $request->address;
        $agent_data->country         = $request->country;
        $agent_data->city            = $request->city;
        $agent_data->zip_code        = $request->zip_code;
        $agent_data->office_phone    = $request->office_phone;
        $agent_data->opening_balance = $request->opening_balance;
        $agent_data->is_active       = 1;
        $agent_data->created_by      = Auth::user()->id;
        $agent_data->created_ip      = request()->ip();
        $agent_data->created_at      = date('Y-m-d H:i:s');

        $save = $agent_data->save();

        if($save){
            return redirect()->route('add-agent')->with('flash.message', ' Sucessfully Added!')->with('flash.class', 'success');
        }else{
            return redirect()->route('add-agent')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
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

    // Get City
    public function get_city_info(Request $request)
    {
        $response = State::where('country_id', '=', $request->country_id)->get();
        
        if (!empty($response)) {
                echo json_encode(['status' => 'success', "message" => "data found", 'data' => $response]);
            }else{
                echo json_encode(['status' => 'error', "message" => "data not found", 'data' => []]);
            }
    }
}
