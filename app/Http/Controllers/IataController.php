<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IataTransactionInfo;
use App\Models\AgentRecord;
use App\Models\OrganizationSetup;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;
use PDF;

class IataController extends Controller
{
    public $iata_transaction_model;
	public function __construct()
	{
	    $this->middleware('auth');
        $this->iata_transaction_model = new IataTransactionInfo();
	}
    public function iata_sale_list()
    {
        $agent_info   = AgentRecord::all();
        return view('iata_report.iata_sale_list', compact('agent_info'));
    }
    public function get_iata_sale_list_data(Request $request)
    {
        header("Content-Type: application/json");
        $sale_category_id   = $request->sale_category_id;
        $start = $request->start;
        $limit = $request->length;
        $search_content = ($request['search']['value'] != '') ? $request['search']['value'] : false;


        $request_data = [
            'start'   => $start,
            'limit'   => $limit,
            'sale_category_id' => $sale_category_id,
        ];

        // echo "<pre>";
        // print_r($request_data);exit;

        $response = $this->iata_transaction_model->get_iata_sale_list_data($request_data, $search_content);

        $count = DB::select("SELECT FOUND_ROWS() as `row_count`")[0]->row_count;
        $response['recordsTotal']    = $count;
        $response['recordsFiltered'] = $count;
        $response['draw']            = $request->draw;

        echo json_encode($response);
    }

    public function iata_debit(){
      
        return view('iata_report.iata_debit');
    }
    public function get_iata_debit_list_data(Request $request)
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

        $response = $this->iata_transaction_model->get_iata_debit_list_data($request_data, $search_content);

        $count = DB::select("SELECT FOUND_ROWS() as `row_count`")[0]->row_count;
        $response['recordsTotal']    = $count;
        $response['recordsFiltered'] = $count;
        $response['draw']            = $request->draw;
        
        echo json_encode($response);
    }

    public function iata_debit_store(Request $request)
    {
        if((isset($request->id) && !empty($request->id)) ){
            $iata_debit_data = IataTransactionInfo::find($request->id);
            $iata_debit_data->updated_by = Auth::user()->id;
            $iata_debit_data->updated_ip =  request()->ip();
            $iata_debit_data->updated_at = date('Y-m-d H:i:s');
        }else{
            $iata_debit_data             = new IataTransactionInfo();
            $iata_debit_data->created_by = Auth::user()->id;
            $iata_debit_data->created_ip = request()->ip();
            $iata_debit_data->created_at = date('Y-m-d H:i:s');
        }
        // iata debit data
        $iata_debit_data->amount     = $request->amount;
        $iata_debit_data->remarks    = $request->remarks;
        $iata_debit_data->type       = 2;
        $iata_debit_data->is_active  = 1;
        $iata_debit_data->date       = date('Y-m-d', strtotime($request->transaction_date));

        // echo "<pre>";
        // print_r($iata_debit_data);exit;
    
        $iata_data_save = $iata_debit_data->save();

        return response()->json([
            'status' => $iata_data_save ? 'success' : 'error',
            'msg'    => $iata_data_save ? 'Successfully IATA Debit' : 'Someting went wrong',
        ]);     

    }

    public function iata_debit_row_data(Request $request)
    {
        $data =  IataTransactionInfo::find($request->id);
        return response()->json([
            'status' => !empty($data) ? 'success' : 'error',
            'msg'    => !empty($data) ? 'Data Found' : 'Something went wrong',
            'data'   => !empty($data) ? $data : []
        ]);
    }

    public function iata_debit_delete(Request $request){
        $data =  IataTransactionInfo::find($request->id);
        $delete = $data->delete();
        return response()->json([
            'status' => !empty($delete) ? 'success' : 'error',
            'msg'    => !empty($delete) ? 'IATA Debit Delated' : 'Something went wrong',
        ]);
    }
    public function iata_credit(){
      
        return view('iata_report.iata_credit');
    }
    public function get_iata_credit_list_data(Request $request)
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

        $response = $this->iata_transaction_model->get_iata_credit_list_data($request_data, $search_content);

        $count = DB::select("SELECT FOUND_ROWS() as `row_count`")[0]->row_count;
        $response['recordsTotal']    = $count;
        $response['recordsFiltered'] = $count;
        $response['draw']            = $request->draw;
        
        echo json_encode($response);
    }

    public function iata_credit_store(Request $request)
    {
        if((isset($request->id) && !empty($request->id)) ){
            $iata_credit_data = IataTransactionInfo::find($request->id);
            $iata_credit_data->updated_by = Auth::user()->id;
            $iata_credit_data->updated_ip =  request()->ip();
            $iata_credit_data->updated_at = date('Y-m-d H:i:s');
        }else{
            $iata_credit_data             = new IataTransactionInfo();
            $iata_credit_data->created_by = Auth::user()->id;
            $iata_credit_data->created_ip = request()->ip();
            $iata_credit_data->created_at = date('Y-m-d H:i:s');
        }
        // iata debit data
        $iata_credit_data->amount     = $request->amount;
        $iata_credit_data->remarks    = $request->remarks;
        $iata_credit_data->type       = 3;
        $iata_credit_data->is_active  = 1;
        $iata_credit_data->date       = date('Y-m-d', strtotime($request->transaction_date));

        // echo "<pre>";
        // print_r($iata_debit_data);exit;
    
        $iata_data_save = $iata_credit_data->save();

        return response()->json([
            'status' => $iata_data_save ? 'success' : 'error',
            'msg'    => $iata_data_save ? 'Successfully IATA Credit' : 'Someting went wrong',
        ]);     

    }

    public function iata_credit_row_data(Request $request)
    {
        $data =  IataTransactionInfo::find($request->id);
        return response()->json([
            'status' => !empty($data) ? 'success' : 'error',
            'msg'    => !empty($data) ? 'Data Found' : 'Something went wrong',
            'data'   => !empty($data) ? $data : []
        ]);
    }

    public function iata_credit_delete(Request $request){
        $data =  IataTransactionInfo::find($request->id);
        $delete = $data->delete();
        return response()->json([
            'status' => !empty($delete) ? 'success' : 'error',
            'msg'    => !empty($delete) ? 'IATA Credit Delated' : 'Something went wrong',
        ]);
    }

     // iata report statement
     public function iata_statement()
     {
         return view('iata_report.iata_statement');
     }
 
     public function iataStatementAction(Request $request)
     {
         $param['from_date']   = (!empty($request->from_date) ? date('Y-m-d', strtotime($request->from_date)) : '');
         $param['to_date']     = (!empty($request->to_date) ? date('Y-m-d', strtotime($request->to_date)) : '');
 
         $data  = $this->iata_transaction_model->searchIataStatement($param);
 
         return view('iata_report.iataStatementAction', ['record'=>$data, 'param_info' => $param]);
     }
     // statement pdf
     public function iata_statement_pdf($from_date=NULL, $to_date=NULL)
     {
         $organization_info = OrganizationSetup::first();
         $from_date         = (($from_date=='0000-00-00')?'':$from_date);
         $to_date           = (($to_date=='0000-00-00')?'':$to_date);
 
         if(!empty($from_date)){
             $param['from_date']= $from_date;
         }
         if(!empty($to_date)){
             $param['to_date']= $to_date;
         }
    
         $data  = $this->iata_transaction_model->searchIataStatement($param);
 
         $config = ['instanceConfigurator' => function ($mpdf) use($organization_info) {
             $mpdf->SetWatermarkImage(asset('public/assets/images/'.$organization_info->logo));
             $mpdf->SetWatermarkImage(
                 asset('public/assets/images/'.$organization_info->logo) . "", .1,
                 array(70, 20),
                 array(77, 150)
             );
             $mpdf->showWatermarkImage = true;
             $mpdf->SetTitle('IATA Statement');
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
 
             $pdf = PDF::loadHtml(view('pdf.iata_statement_pdf', compact('from_date','to_date','data')), $config);
        
             return $pdf->stream('iata_statement_pdf.pdf');
     }
}
