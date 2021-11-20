<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\AccTransactionInfo;
use App\Models\AgentRecord;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $transaction_model;
	public function __construct()
	{
	    $this->middleware('auth');
        $this->transaction_model = new AccTransactionInfo();
	}
    public function index()
    {
        $bank_data = Bank::all();

        return view('bank.bank_list', compact('bank_data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bank.bank_create');

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
            'account_no' => ['required'],
        ]);

        $bank_data = new Bank();

        $bank_data->name            = $request->name;
        $bank_data->account_no      = $request->account_no;
        $bank_data->branch_name     = $request->branch_name;
        $bank_data->routing_number  = $request->routing_number;
        $bank_data->opening_balance = $request->opening_balance;
        $bank_data->type            = $request->type;
        $bank_data->is_active       = 1;
        $bank_data->created_by      = Auth::user()->id;
        $bank_data->created_ip      = request()->ip();
        $bank_data->created_at      = date('Y-m-d H:i:s');

        $save = $bank_data->save();

        // Account primary id
        $bank_id = DB::getPdo()->lastInsertId();

        $transaction_data = new  AccTransactionInfo();

        $transaction_data->debit_acc     = NULL;
        $transaction_data->credit_acc    = $bank_id;
        $transaction_data->debit_amount  = 0.00;
        $transaction_data->credit_amount = $request->opening_balance;
        $transaction_data->trans_type    = 4;
        $transaction_data->is_active     = 1;
        $transaction_data->trans_date    = date('Y-m-d');
        $transaction_data->created_by    = Auth::user()->id;
        $transaction_data->created_ip    = request()->ip();
        $transaction_data->created_at    = date('Y-m-d H:i:s');

        $save = $transaction_data->save();

        if($save){
            return redirect()->route('bank-list')->with('flash.message', 'Account  Sucessfully Added!')->with('flash.class', 'success');
        }else{
            return redirect()->route('bank-list')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
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
        $bank_info = Bank::find($id);
        return view('bank.bank_edit', compact('bank_info'));
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
            'account_no' => ['required'],
        ]);

        $bank_data =  Bank::find($id);

        $bank_data->name           = $request->name;
        $bank_data->account_no     = $request->account_no;
        $bank_data->branch_name    = $request->branch_name;
        $bank_data->routing_number = $request->routing_number;
        $bank_data->type           = $request->type;
        $bank_data->is_active      = 1;
        $bank_data->updated_by     = Auth::user()->id;
        $bank_data->updated_ip     = request()->ip();
        $bank_data->created_at     = date('Y-m-d H:i:s');

        $save = $bank_data->save();

        $transaction_data = AccTransactionInfo::where('credit_acc', $id)->first();

        $transaction_data->debit_acc     = NULL;
        $transaction_data->credit_acc    = $id;
        $transaction_data->debit_amount  = 0.00;
        $transaction_data->credit_amount = $request->opening_balance;
        $transaction_data->trans_type    = 4;
        $transaction_data->is_active     = 1;
        $transaction_data->trans_date    = date('Y-m-d');
        $transaction_data->created_by    = Auth::user()->id;
        $transaction_data->created_ip    = request()->ip();
        $transaction_data->created_at    = date('Y-m-d H:i:s');

        $save = $transaction_data->save();

        if($save){
            return redirect()->route('bank-list')->with('flash.message', 'Account  Sucessfully Updated!')->with('flash.class', 'success');
        }else{
            return redirect()->route('bank-list')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
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
        $delete = Bank::where('id', $id)->delete();

        if($delete){
            return redirect()->route('bank-list')->with('flash.message', 'Bank Sucessfully Deleted!')->with('flash.class', 'success');
        }else{
            return redirect()->route('bank-list')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
        }
    }
    public function account_report()
    {
        $bank         = Bank::orderBy('type', 'ASC')->get();
        $agent_info   = AgentRecord::all();

        return view('account_report.account_report', compact('bank','agent_info'));
    }

    public function get_account_report_data(Request $request)
    {
        header("Content-Type: application/json");

        $account_id= $request->account_id;
        $from_date = $request->from_date;
        $to_date   = $request->to_date;

        $start = $request->start;
        $limit = $request->length;
        $search_content = ($request['search']['value'] != '') ? $request['search']['value'] : false;

        $request_data = [
            'start'     => $start,
            'limit'     => $limit,
            'account_id'=> $account_id,
            'from_date' => $from_date,
            'to_date'   => $to_date,
        ];

        $response = $this->transaction_model->account_report_list_data($request_data, $search_content);

        $count = DB::select("SELECT FOUND_ROWS() as `row_count`")[0]->row_count;
        $response['recordsTotal']    = $count;
        $response['recordsFiltered'] = $count;
        $response['draw']            = $request->draw;
        
        echo json_encode($response);
    }
}
