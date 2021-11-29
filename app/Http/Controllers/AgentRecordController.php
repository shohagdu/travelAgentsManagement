<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AgentRecord;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use App\Models\OrganizationSetup;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
Use DB;
use Session;

class AgentRecordController extends Controller
{
    public $agent_model;
	public function __construct()
	{
	    $this->middleware('auth');
        $this->agent_model = new AgentRecord();

	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $country = Country::all();
        $state   = State::all();
        return view('agent.agent_list', compact('country', 'state'));
    }
    public function get_agent_list_data(Request $request)
    {
        header("Content-Type: application/json");
         $country   = $request->country;
         $city      = $request->city;
         $mobile    = $request->mobile;

        $start = $request->start;
        $limit = $request->length;
        $search_content = ($request['search']['value'] != '') ? $request['search']['value'] : false;

        $request_data = [
            'start'   => $start,
            'limit'   => $limit,
            'country' => $country,
            'city'    => $city,
            'mobile'  => $mobile,
        ];

        $response = $this->agent_model->agent_list_data($request_data, $search_content);
        $count = DB::select("SELECT FOUND_ROWS() as `row_count`")[0]->row_count;
        $response['recordsTotal']    = $count;
        $response['recordsFiltered'] = $count;
        $response['draw']            = $request->draw;

        echo json_encode($response);
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

        // agent primary id
        $agent_id = DB::getPdo()->lastInsertId();

        $user_data = new User();

        $user_data->record_id  = $agent_id;
        $user_data->name       = $request->name;
        $user_data->email      = $request->email;
        $user_data->password   = Hash::make($request['mobile']);
        $user_data->created_by = Auth::user()->id;
        $user_data->created_ip = request()->ip();
        $user_data->created_at = date('Y-m-d H:i:s');

        $user_save =  $user_data->save();

        if($user_data){
            return redirect()->route('agent-list')->with('flash.message', 'Agent Sucessfully Added!')->with('flash.class', 'success');
        }else{
            return redirect()->route('agent-list')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
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
        $country    = Country::all();
        $state      = State::all();
        $agent_data = AgentRecord::find($id);

        return view('agent.edit_agent', compact('country', 'state','agent_data'));
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
            'name'         => ['required'],
            'mobile'       => ['required'],
            'company_name' => ['required'],
        ]);

        $agent_data = AgentRecord::find($id);

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
        $agent_data->updated_by      = Auth::user()->id;
        $agent_data->updated_ip      = request()->ip();
        $agent_data->created_at      = date('Y-m-d H:i:s');

        $save = $agent_data->save();

        if($save){
            return redirect()->route('agent-list')->with('flash.message', 'Agent Sucessfully Updated!')->with('flash.class', 'success');
        }else{
            return redirect()->route('agent-list')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
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
        $delete = AgentRecord::find($id);
        $delete->delete();

        if($delete){
            return redirect()->route('agent-list')->with('flash.message', 'Agent Sucessfully delated!')->with('flash.class', 'success');
        }else{
            return redirect()->route('agent-list')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
        }
    }

    public function agent_statement($id){

        $organization_info = OrganizationSetup::first();
        $agent_info        = AgentRecord::find($id);
        $transaction_info  = $this->agent_model->transaction_info_data($id);

        $totalTran=  count($transaction_info);
        $frist_date = $transaction_info[0]->trans_date;
        $last_date  = $transaction_info[$totalTran-1]->trans_date;


        return view('agent.agent_statement', compact('organization_info', 'agent_info', 'transaction_info', 'frist_date', 'last_date'));
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
    public function pdf_agent_statement($id){

        $organization_info = OrganizationSetup::first();
        $agent_info        = AgentRecord::find($id);
        $transaction_info  = $this->agent_model->transaction_info_data($id);

        $totalTran=  count($transaction_info);
        $frist_date = $transaction_info[0]->trans_date;
        $last_date  = $transaction_info[$totalTran-1]->trans_date;


        return view('agent.agent_statement', compact('organization_info', 'agent_info', 'transaction_info', 'frist_date', 'last_date'));
    }
}
