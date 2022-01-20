<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\SaleCategory;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;

class ExpenseController extends Controller
{
    public $expense_model;
	public function __construct()
	{
	    $this->middleware('auth');
        $this->expense_model = new Expense();
	}
    public function expense(){
        $category_info = SaleCategory::where('type','=', 21)->get();
        return view('expense.expense',compact('category_info'));
    }
    public function get_expense_list_data(Request $request)
    {
        header("Content-Type: application/json");
        $trans_date = $request->trans_date;

        $start = $request->start;
        $limit = $request->length;
        $search_content = ($request['search']['value'] != '') ? $request['search']['value'] : false;

        $request_data = [
            'start'      => $start,
            'limit'      => $limit,
            'trans_date' => $trans_date,
        ];

        $response = $this->expense_model->get_expense_list_data($request_data, $search_content);

        $count = DB::select("SELECT FOUND_ROWS() as `row_count`")[0]->row_count;
        $response['recordsTotal']    = $count;
        $response['recordsFiltered'] = $count;
        $response['draw']            = $request->draw;

        echo json_encode($response);
    }

    public function expense_save(Request $request)
    {
        if((isset($request->id) && !empty($request->id)) ){
            $expense_data = Expense::find($request->id);
            $expense_data->updated_by = Auth::user()->id;
            $expense_data->updated_ip =  request()->ip();
            $expense_data->updated_at = date('Y-m-d H:i:s');
        }else{
            $expense_data             = new Expense();
            $expense_data->created_by = Auth::user()->id;
            $expense_data->created_ip = request()->ip();
            $expense_data->created_at = date('Y-m-d H:i:s');
        }
        // expense data
        $expense_data->category_id = $request->category_id;
        $expense_data->amount      = $request->amount;
        $expense_data->remarks     = $request->remarks;
        $expense_data->is_active   = 1;
        $expense_data->date        = date('Y-m-d', strtotime($request->transaction_date));

        $expense_data_save = $expense_data->save();

        return response()->json([
            'status' => $expense_data_save ? 'success' : 'error',
            'msg'    => $expense_data_save ? 'Successfully Expensed' : 'Someting went wrong',
        ]);

    }

    public function expense_row_data(Request $request)
    {
        $data =  Expense::find($request->id);
        return response()->json([
            'status' => !empty($data) ? 'success' : 'error',
            'msg'    => !empty($data) ? 'Data Found' : 'Something went wrong',
            'data'   => !empty($data) ? $data : []
        ]);
    }

    public function expense_delete(Request $request){
        $data =  Expense::find($request->id);
        $delete = $data->delete();
        return response()->json([
            'status' => !empty($delete) ? 'success' : 'error',
            'msg'    => !empty($delete) ? 'Expense Delated' : 'Something went wrong',
        ]);
    }
}
