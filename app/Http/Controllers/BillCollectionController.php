<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\AgentRecord;
use App\Models\SaleCategory;
use App\Models\AccTransactionInfo;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;


class BillCollectionController extends Controller
{
    public $transaction_model;
	public function __construct()
	{
	    $this->middleware('auth');
        $this->transaction_model = new AccTransactionInfo();
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bank          = Bank::orderBy('type', 'ASC')->get();
        $agent_info    = AgentRecord::all();
        $category_info = SaleCategory::where('type','=', 19)->get();

        return view('bill_collection.bill', compact('bank','agent_info','category_info'));
    }

    public function get_bill_collection_list_data(Request $request)
    {
        header("Content-Type: application/json");
        $agent_id    = $request->agent_id;
        $trans_date  = $request->trans_date;

        $start = $request->start;
        $limit = $request->length;
        $search_content = ($request['search']['value'] != '') ? $request['search']['value'] : false;

        $request_data = [
            'start'      => $start,
            'limit'      => $limit,
            'agent_id'   => $agent_id,
            'trans_date' => $trans_date,
        ];

        $response = $this->transaction_model->bill_collection_list_data($request_data, $search_content);

        // echo "<pre>";
        // print_r($response);exit;

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
       
        if((isset($request->id) && !empty($request->id)) ){
            $transaction_data = AccTransactionInfo::find($request->id);
            $transaction_data->updated_by = Auth::user()->id;
            $transaction_data->updated_ip =  request()->ip();
            $transaction_data->updated_at = date('Y-m-d H:i:s');
        }else{
            $transaction_data               = new AccTransactionInfo();
            $transaction_data->created_by   = Auth::user()->id;
            $transaction_data->created_ip   = request()->ip();
            $transaction_data->created_at   = date('Y-m-d H:i:s');

        }

        // transaction data
        $transaction_data->debit_acc         = NULL;
        $transaction_data->credit_acc        = $request->agent_id;
        $transaction_data->debit_amount      = 0.00;
        $transaction_data->towards_type      = $request->towards_type;
        $transaction_data->reference_number  = $request->reference_number;
        $transaction_data->credit_amount     = $request->payment_amount;
        $transaction_data->receipt_cheque_no = NULL;
        $transaction_data->remarks           = $request->remarks;
        $transaction_data->trans_type        = 2;
        $transaction_data->is_active         = 1;
        $transaction_data->trans_date        = date('Y-m-d', strtotime($request->payment_date));
        
        // echo "<pre>";
        // print_r($transaction_data);exit;

        $transaction_save = $transaction_data->save();

        return response()->json([
            'status' => $transaction_save ? 'success' : 'error',
            'msg'    => $transaction_save ? 'Successfully Credit Bill' : 'Someting went wrong',
        ]);     

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
    public function edit(Request $request)
    {
        $data =  AccTransactionInfo::find($request->id);

        return response()->json([
            'status' => !empty($data) ? 'success' : 'error',
            'msg'    => !empty($data) ? 'Data Found' : 'Something went wrong',
            'data'   => !empty($data) ? $data : []
        ]);
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
    public function bill_collection_delete(Request $request){
        $data =  AccTransactionInfo::find($request->id);

        $delete = $data->delete();

        return response()->json([
            'status' => !empty($delete) ? 'success' : 'error',
            'msg'    => !empty($delete) ? 'Information Delated' : 'Something went wrong',
        ]);
    }

    public function agent_bill_payment_data(Request $request){
         $agent_id = $request->id;

         $agent_name = AgentRecord::find($agent_id);
         $agent_debit  = DB::table('acc_transaction_infos')->select('debit_amount')->where('debit_acc', $agent_id)->sum('debit_amount');
         $agent_credit = DB::table('acc_transaction_infos')->select('credit_amount')->where('credit_acc', $agent_id)->sum('credit_amount');

        $due_balance =  $agent_debit-$agent_credit;

        return response()->json([
            'status' => !empty($agent_id) ? 'success' : 'error',
            'msg'    => !empty($agent_id) ? 'Data Found' : 'Something went wrong',
            'data'   => !empty($agent_id) ? $data=[
                'agent_name'   => $agent_name,
                'agent_credit' => $agent_credit,
                'due_balance'  => $due_balance,
            ] : []
        ]);

    }

    // debit bill
    public function debit_bill_index()
    {
        $bank          = Bank::orderBy('type', 'ASC')->get();
        $agent_info    = AgentRecord::all();
        $category_info = SaleCategory::where('type','=', 20)->get();

        return view('bill_collection.debit_bill', compact('bank','agent_info','category_info'));
    }

    public function get_debit_bill_list_data(Request $request)
    {
        header("Content-Type: application/json");
        $agent_id    = $request->agent_id;
        $trans_date  = $request->trans_date;

        $start = $request->start;
        $limit = $request->length;
        $search_content = ($request['search']['value'] != '') ? $request['search']['value'] : false;

        $request_data = [
            'start'      => $start,
            'limit'      => $limit,
            'agent_id'   => $agent_id,
            'trans_date' => $trans_date,
        ];

        $response = $this->transaction_model->debit_bill_list_data($request_data, $search_content);

        $count = DB::select("SELECT FOUND_ROWS() as `row_count`")[0]->row_count;
        $response['recordsTotal']    = $count;
        $response['recordsFiltered'] = $count;
        $response['draw']            = $request->draw;
        
        echo json_encode($response);
    }

    public function debit_bill_store(Request $request)
    {
        if((isset($request->id) && !empty($request->id)) ){
            $transaction_data = AccTransactionInfo::find($request->id);
            $transaction_data->updated_by = Auth::user()->id;
            $transaction_data->updated_ip =  request()->ip();
            $transaction_data->updated_at = date('Y-m-d H:i:s');
        }else{
            $transaction_data               = new AccTransactionInfo();
            $transaction_data->created_by   = Auth::user()->id;
            $transaction_data->created_ip   = request()->ip();
            $transaction_data->created_at   = date('Y-m-d H:i:s');

        }

        // transaction data
        $transaction_data->debit_acc         = $request->agent_id;
        $transaction_data->credit_acc        = isset($request->bank_name) ? $request->bank_name : NULL;
        $transaction_data->debit_amount      = $request->payment_amount;
        $transaction_data->towards_type      = $request->towards_type;
        $transaction_data->reference_number  = $request->reference_number;
        $transaction_data->credit_amount     = 0.00;
        $transaction_data->receipt_cheque_no = $request->receipt_cheque_no;
        $transaction_data->remarks           = $request->remarks;
        $transaction_data->trans_type        = 3;
        $transaction_data->is_active         = 1;
        $transaction_data->trans_date        = date('Y-m-d', strtotime($request->payment_date));
        
        // echo "<pre>";
        // print_r($transaction_data);exit;

        $transaction_save = $transaction_data->save();

        return response()->json([
            'status' => $transaction_save ? 'success' : 'error',
            'msg'    => $transaction_save ? 'Successfully Debit Bill' : 'Someting went wrong',
        ]);     

    }

    public function agent_debit_bill_payment_data(Request $request){
        $agent_id = $request->id;

        $agent_name = AgentRecord::find($agent_id);
        $agent_debit  = DB::table('acc_transaction_infos')->select('debit_amount')->where('debit_acc', $agent_id)->sum('debit_amount');
        $agent_credit = DB::table('acc_transaction_infos')->select('credit_amount')->where('credit_acc', $agent_id)->sum('credit_amount');

       $due_balance =  $agent_debit-$agent_credit;

       return response()->json([
           'status' => !empty($agent_id) ? 'success' : 'error',
           'msg'    => !empty($agent_id) ? 'Data Found' : 'Something went wrong',
           'data'   => !empty($agent_id) ? $data=[
               'agent_name'   => $agent_name,
               'agent_debit' => $agent_debit,
               'due_balance'  => $due_balance,
           ] : []
       ]);

   }


    public function bill_refund()
    {
        $bank         = Bank::orderBy('type', 'ASC')->get();
        $agent_info   = AgentRecord::all();

        return view('refund.refund', compact('bank','agent_info'));
    }

    public function get_bill_refund_list_data(Request $request)
    {
        header("Content-Type: application/json");
        $agent_id    = $request->agent_id;
        $trans_date  = $request->trans_date;

        $start = $request->start;
        $limit = $request->length;
        $search_content = ($request['search']['value'] != '') ? $request['search']['value'] : false;

        $request_data = [
            'start'      => $start,
            'limit'      => $limit,
            'agent_id'   => $agent_id,
            'trans_date' => $trans_date,
        ];

        $response = $this->transaction_model->bill_refund_list_data($request_data, $search_content);
        $count = DB::select("SELECT FOUND_ROWS() as `row_count`")[0]->row_count;
        $response['recordsTotal']    = $count;
        $response['recordsFiltered'] = $count;
        $response['draw']            = $request->draw;
        
        echo json_encode($response);
    }

    public function bill_refund_save(Request $request)
    {
        if((isset($request->id) && !empty($request->id)) ){
            $transaction_data = AccTransactionInfo::find($request->id);
            $transaction_data->updated_by = Auth::user()->id;
            $transaction_data->updated_ip =  request()->ip();
            $transaction_data->updated_at = date('Y-m-d H:i:s');
        }else{
            $transaction_data               = new AccTransactionInfo();
            $transaction_data->created_by   = Auth::user()->id;
            $transaction_data->created_ip   = request()->ip();
            $transaction_data->created_at   = date('Y-m-d H:i:s');

        }

        // transaction data
        $transaction_data->debit_acc         = isset($request->bank_name) ? $request->bank_name : NULL;
        $transaction_data->credit_acc        = $request->agent_id;
        $transaction_data->debit_amount      = 0.00;
        $transaction_data->credit_amount     = $request->refund_amount;
        $transaction_data->receipt_cheque_no = $request->receipt_cheque_no;
        $transaction_data->remarks           = $request->remarks;
        $transaction_data->trans_type        = 4;
        $transaction_data->is_active         = 1;
        $transaction_data->trans_date        = date('Y-m-d', strtotime($request->refund_date));
        
        $transaction_save = $transaction_data->save();

        return response()->json([
            'status' => $transaction_save ? 'success' : 'error',
            'msg'    => $transaction_save ? 'Successfully Bill Refund' : 'Someting went wrong',
        ]);     

    }

    public function bill_refund_row_data(Request $request)
    {
        $data =  AccTransactionInfo::find($request->id);


        return response()->json([
            'status' => !empty($data) ? 'success' : 'error',
            'msg'    => !empty($data) ? 'Data Found' : 'Something went wrong',
            'data'   => !empty($data) ? $data : []
        ]);
    }
    public function bill_refund_delete(Request $request){
        $data =  AccTransactionInfo::find($request->id);
    
        $delete = $data->delete();
    
        return response()->json([
            'status' => !empty($delete) ? 'success' : 'error',
            'msg'    => !empty($delete) ? 'Information Delated' : 'Something went wrong',
        ]);
    }
}

