<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\BankRecord;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;

class BankRecordController extends Controller
{
    public $bank_record_model;
	public function __construct()
	{
	    $this->middleware('auth');
        $this->bank_record_model = new BankRecord();
	}
    public function bank_debit(){
        $bank_info = Bank::where('type', '=', 2)->orderBy('type', 'ASC')->get();

        return view('bank_record.bank_debit', compact('bank_info'));
    }
    public function get_bank_debit_list_data(Request $request)
    {
        header("Content-Type: application/json");
        $bank_id    = $request->bank_id;
        $trans_date = $request->trans_date;

        $start = $request->start;
        $limit = $request->length;
        $search_content = ($request['search']['value'] != '') ? $request['search']['value'] : false;

        $request_data = [
            'start'      => $start,
            'limit'      => $limit,
            'bank_id'    => $bank_id,
            'trans_date' => $trans_date,
        ];

        $response = $this->bank_record_model->get_bank_debit_list_data($request_data, $search_content);

        $count = DB::select("SELECT FOUND_ROWS() as `row_count`")[0]->row_count;
        $response['recordsTotal']    = $count;
        $response['recordsFiltered'] = $count;
        $response['draw']            = $request->draw;
        
        echo json_encode($response);
    }

    public function bank_debit_store(Request $request)
    {
        if((isset($request->id) && !empty($request->id)) ){
            $bank_debit_data = BankRecord::find($request->id);
            $bank_debit_data->updated_by = Auth::user()->id;
            $bank_debit_data->updated_ip =  request()->ip();
            $bank_debit_data->updated_at = date('Y-m-d H:i:s');
        }else{
            $bank_debit_data             = new BankRecord();
            $bank_debit_data->created_by = Auth::user()->id;
            $bank_debit_data->created_ip = request()->ip();
            $bank_debit_data->created_at = date('Y-m-d H:i:s');
        }
        // bank debit data
        $bank_debit_data->bank_id         = $request->bank_id;
        $bank_debit_data->amount          = $request->amount;
        $bank_debit_data->remarks         = $request->remarks;
        $bank_debit_data->type            = 1;
        $bank_debit_data->is_active       = 1;
        $bank_debit_data->transaction_date = date('Y-m-d', strtotime($request->transaction_date));
    
        $bank_data_save = $bank_debit_data->save();

        return response()->json([
            'status' => $bank_data_save ? 'success' : 'error',
            'msg'    => $bank_data_save ? 'Successfully Bank Debit' : 'Someting went wrong',
        ]);     

    }

    public function bank_debit_row_data(Request $request)
    {
        $data =  BankRecord::find($request->id);

        return response()->json([
            'status' => !empty($data) ? 'success' : 'error',
            'msg'    => !empty($data) ? 'Data Found' : 'Something went wrong',
            'data'   => !empty($data) ? $data : []
        ]);
    }

    public function bank_debit_delete(Request $request){
        $data =  BankRecord::find($request->id);
        $delete = $data->delete();
        return response()->json([
            'status' => !empty($delete) ? 'success' : 'error',
            'msg'    => !empty($delete) ? 'Bank Debit Delated' : 'Something went wrong',
        ]);
    }

    public function bank_credit(){
        $bank_info = Bank::where('type', '=', 2)->orderBy('type', 'ASC')->get();

        return view('bank_record.bank_credit', compact('bank_info'));
    }
    public function get_bank_credit_list_data(Request $request)
    {
        header("Content-Type: application/json");
        $bank_id    = $request->bank_id;
        $trans_date = $request->trans_date;

        $start = $request->start;
        $limit = $request->length;
        $search_content = ($request['search']['value'] != '') ? $request['search']['value'] : false;

        $request_data = [
            'start'      => $start,
            'limit'      => $limit,
            'bank_id'    => $bank_id,
            'trans_date' => $trans_date,
        ];

        $response = $this->bank_record_model->get_bank_credit_list_data($request_data, $search_content);

        $count = DB::select("SELECT FOUND_ROWS() as `row_count`")[0]->row_count;
        $response['recordsTotal']    = $count;
        $response['recordsFiltered'] = $count;
        $response['draw']            = $request->draw;
        
        echo json_encode($response);
    }

    public function bank_credit_store(Request $request)
    {
        if((isset($request->id) && !empty($request->id)) ){
            $bank_credit_data = BankRecord::find($request->id);
            $bank_credit_data->updated_by = Auth::user()->id;
            $bank_credit_data->updated_ip =  request()->ip();
            $bank_credit_data->updated_at = date('Y-m-d H:i:s');
        }else{
            $bank_credit_data             = new BankRecord();
            $bank_credit_data->created_by = Auth::user()->id;
            $bank_credit_data->created_ip = request()->ip();
            $bank_credit_data->created_at = date('Y-m-d H:i:s');
        }
        // bank debit data
        $bank_credit_data->bank_id         = $request->bank_id;
        $bank_credit_data->amount          = $request->amount;
        $bank_credit_data->remarks         = $request->remarks;
        $bank_credit_data->type            = 2;
        $bank_credit_data->is_active       = 1;
        $bank_credit_data->transaction_date = date('Y-m-d', strtotime($request->transaction_date));
    
        $bank_data_save = $bank_credit_data->save();

        return response()->json([
            'status' => $bank_data_save ? 'success' : 'error',
            'msg'    => $bank_data_save ? 'Successfully Bank Credit' : 'Someting went wrong',
        ]);     

    }

    public function bank_credit_row_data(Request $request)
    {
        $data =  BankRecord::find($request->id);
        return response()->json([
            'status' => !empty($data) ? 'success' : 'error',
            'msg'    => !empty($data) ? 'Data Found' : 'Something went wrong',
            'data'   => !empty($data) ? $data : []
        ]);
    }

    public function bank_credit_delete(Request $request){
        $data =  BankRecord::find($request->id);
        $delete = $data->delete();
        return response()->json([
            'status' => !empty($delete) ? 'success' : 'error',
            'msg'    => !empty($delete) ? 'Bank Credit Delated' : 'Something went wrong',
        ]);
    }
}
