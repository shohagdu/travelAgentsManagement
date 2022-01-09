<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\BankRecord;
use App\Models\OrganizationSetup;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;
use PDF;

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

     //  bank deposit list 
     public function bank_deposit(){
        $bank_deposit = $this->bank_record_model->bank_deposit();
        return view('bank_record.bank_deposit', compact('bank_deposit'));
    }
    public function bank_deposit_pdf() {
        $organization_info  = OrganizationSetup::first();
        $bank_deposit_data = $this->bank_record_model->bank_deposit();

        $config = ['instanceConfigurator' => function ($mpdf) use($organization_info) {
            $mpdf->SetWatermarkImage(asset('public/assets/images/'.$organization_info->logo));
            $mpdf->SetWatermarkImage(
                asset('public/assets/images/'.$organization_info->logo) . "", .1,
                array(70, 20),
                array(77, 150)
            );
            $mpdf->showWatermarkImage = true;
            $mpdf->SetTitle('Bank Deposit');
            $page_footer_html = view()->make('pdf.pdfHeader', ['organization_info'=>$organization_info])->render();

            $mpdf->SetHTMLHeader($page_footer_html);

            $pagefooter="If you have any question, please contact ".(!empty($organization_info->mobile)?" Mobile:".$organization_info->mobile:'').(!empty($organization_info->email)?", Email: ".$organization_info->email:'').". Printed Date:".date('d M, Y');
            $mpdf->SetHTMLFooter("<div style='text-align: center;font-size:10px;color:gray;'>".$pagefooter." || Page No: {PAGENO} of {nb}</div>");

            $margin_left   = 5;
            $margin_right  = 5;
            $margin_top    = 10;
            $margin_bottom = 5;
            $paper_type    = 'a4';

            $mpdf->AddPage('P', '', '', '', '', $margin_left, $margin_right, $margin_top, $margin_bottom, 5, 5, '', '', '', '', '', '', '', '', '', $paper_type);
            }];

        $pdf = PDF::loadHtml(view('pdf.bank_deposit_pdf', compact('bank_deposit_data')), $config);

        return $pdf->stream('bank_deposit_pdf.pdf');
    }

    // bank report statement
    public function bank_statement()
    {
        $bank_info = Bank::where('type', '=', 2)->orderBy('type', 'ASC')->get();
        return view('bank_record.bank_statement', compact('bank_info'));
    }

    public function bankStatementAction(Request $request)
    {
        $param['bank_id']    = (!empty($request->bank_id) ? $request->bank_id : '');
        $param['from_date']   = (!empty($request->from_date) ? date('Y-m-d', strtotime($request->from_date)) : '');
        $param['to_date']     = (!empty($request->to_date) ? date('Y-m-d', strtotime($request->to_date)) : '');

        if(!empty($param['from_date'])) {
            $bank_debit_balance  = $this->bank_record_model->BankDebitBalance($param);
            $bank_credit_balance = $this->bank_record_model->BankCreditBalance($param);
            $balance = ($bank_debit_balance - $bank_credit_balance);
        }else{
            $balance=0;
        }

        $data  = $this->bank_record_model->searchBankStatement($param);

        return view('bank_record.bankStatementAction', ['record'=>$data, 'balance' => $balance, 'param_info' => $param]);
    }
    // statement pdf
    public function bank_statement_pdf($bank_id, $from_date=NULL, $to_date=NULL)
    {
        $organization_info  = OrganizationSetup::first();
        $from_date          =(($from_date=='0000-00-00')?'':$from_date);
        $to_date          =(($to_date=='0000-00-00')?'':$to_date);

        if(!empty($bank_id)){
            $param['bank_id']= $bank_id;
        }else{
            echo "<h1> Bank ID is required</h1>";exit;
        }
        if(!empty($from_date)){
            $param['from_date']= $from_date;
        }
        if(!empty($to_date)){
            $param['to_date']= $to_date;
        }
        if(!empty($from_date)) {
            $bank_debit_balance  = $this->bank_record_model->BankDebitBalance($param);
            $bank_credit_balance = $this->bank_record_model->BankCreditBalance($param);
            $balance = ($bank_debit_balance - $bank_credit_balance);
        }else{
            $balance=0;
        }

        $data  = $this->bank_record_model->searchBankStatement($param);

        //  echo "<pre>";
        // print_r($data);exit;      

        $config = ['instanceConfigurator' => function ($mpdf) use($organization_info) {
            $mpdf->SetWatermarkImage(asset('public/assets/images/'.$organization_info->logo));
            $mpdf->SetWatermarkImage(
                asset('public/assets/images/'.$organization_info->logo) . "", .1,
                array(70, 20),
                array(77, 150)
            );
            $mpdf->showWatermarkImage = true;
            $mpdf->SetTitle('Bank Statement');
            $page_footer_html = view()->make('pdf.pdfHeader', ['organization_info'=>$organization_info])->render();

            $mpdf->SetHTMLHeader($page_footer_html);

            $pagefooter="If you have any question, please contact ".(!empty($organization_info->mobile)?" Mobile:".$organization_info->mobile:'').(!empty($organization_info->email)?", Email: ".$organization_info->email:'').". Printed Date:".date('d M, Y');
            $mpdf->SetHTMLFooter("<div style='text-align: center;font-size:10px;color:gray;'>".$pagefooter." || Page No: {PAGENO} of {nb}</div>");

            $margin_left   = 5;
            $margin_right  = 5;
            $margin_top    = 10;
            $margin_bottom = 5;
            $paper_type    = 'a4';

            $mpdf->AddPage('P', '', '', '', '', $margin_left, $margin_right, $margin_top, $margin_bottom, 5, 5, '', '', '', '', '', '', '', '', '', $paper_type);
            }];

            $pdf = PDF::loadHtml(view('pdf.bank_statement_pdf', compact('balance', 'from_date','to_date','data')), $config);
       
            return $pdf->stream('bank_statement_pdf.pdf');
    }
}
