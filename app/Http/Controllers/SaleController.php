<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AgentRecord;
use App\Models\AirlineSetup;
use App\Models\SaleCategory;
use App\Models\OrganizationSetup;
use Illuminate\Support\Facades\Auth;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\AccTransactionInfo;
use Illuminate\Support\Facades\Crypt;
use Session;
use DB;
use PDF;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $sale_model;
    public $sale_details_model;
	public function __construct()
	{
	    $this->middleware('auth');
        $this->sale_model = new Sale();
        $this->sale_details_model = new SaleDetail();

	}
    public function index()
    {
        $agent_info   = AgentRecord::all();

        return view('sale.sale_list', compact('agent_info'));
    }
    public function get_sale_list_data(Request $request)
    {
        header("Content-Type: application/json");
        $sale_category_id   = $request->sale_category_id;
        $agent_id           = $request->agent_id;


        $start = $request->start;
        $limit = $request->length;
        $search_content = ($request['search']['value'] != '') ? $request['search']['value'] : false;


        $request_data = [
            'start'   => $start,
            'limit'   => $limit,
            'sale_category_id' => $sale_category_id,
            'agent_id'    => $agent_id,
        ];

        // echo "<pre>";
        // print_r($request_data);exit;

        $response = $this->sale_model->sale_list_data($request_data, $search_content);

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
        $agent_info         = AgentRecord::all();
        $airline_info       = AirlineSetup::all();
        $sale_category_info = SaleCategory::take(7)->get();

        return view('sale.sale', compact('agent_info', 'airline_info', 'sale_category_info'));
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
            'sale_category_id' => ['required'],
            'agent_id'         => ['required'],
            'net_total'        => ['required'],
        ]);
        $total_count = DB::table('sales')
                           ->where('is_active','=',1 )
                           ->count();
        $serial       = $total_count+1;
        $invoice_key  = $this->invoiceGenerator($serial);
        $dayMonthYear = date('dmY');
        $invoice_no   = $dayMonthYear.$invoice_key;

        $sale_category = $request->sale_category_id;

        // sale category 1= flight else others all
        if($sale_category == 1){

            $sale_data = [
                'invoice_no'       => $invoice_no,
                'sale_category_id' => $request->sale_category_id,
                'agent_id'         => $request->agent_id,
                'sale_amount'      => $request->net_total,
                'discount'         => $request->discount,
                'amount'           => $request->invoice_amount,
                'remarks'          => $request->remarks,
                "is_active"        => 1,
                'created_by'       => Auth::user()->id,
                'created_ip'       => request()->ip(),
                'created_at'       => date('Y-m-d H:i:s'),
            ];

            $sale_save = DB::table('sales')->insert($sale_data);


            $flight_id      = $request->flight_id;
            $fare           = $request->fare;
            $tax            = $request->tax;
            $commission_per = $request->commissionPer;
            $commission     = $request->commission;
            $ait_per        = $request->aitPer;
            $ait            = $request->ait;
            $add            = $request->add;
            $amount         = $request->amount;

            $sale_id   = DB::getPdo()->lastInsertId();

            $sale_detail_data = [];

            foreach($flight_id as $key => $item){
                $sale_detail_data[] = [
                    'sale_id'           => $sale_id,
                    'airline_id'        => $item,
                    'fare'              => $fare[$key],
                    'tax_per'           => $tax[$key],
                    'tax_amount'        => $tax[$key],
                    'total_amount'      => $fare[$key]+$tax[$key],
                    'commission_per'    => $commission_per[$key],
                    'commission_amount' => $commission[$key],
                    'ait_per'           => $ait_per[$key],
                    'ait_amount'        => $ait[$key],
                    'add_per'           => $add[$key],
                    'add_amount'        => $add[$key],
                    'invoice_amount'    => $amount[$key],
                    'net_amount'        => $amount[$key],
                    "is_active"         => 1,
                    'created_by'        => Auth::user()->id,
                    'created_ip'        => request()->ip(),
                    'created_at'        => date('Y-m-d H:i:s'),
                ];
            }

            $sale_save = DB::table('sale_details')->insert($sale_detail_data);

            // transaction data
            $transaction_data = new  AccTransactionInfo();

            $transaction_data->sales_id      = $sale_id;
            $transaction_data->debit_acc     = $request->agent_id;
            $transaction_data->credit_acc    = 0;
            $transaction_data->debit_amount  = $request->invoice_amount;
            $transaction_data->credit_amount = 0.00;
            $transaction_data->trans_type    = 1;
            $transaction_data->remarks       = $request->remarks;
            $transaction_data->is_active     = 1;
            $transaction_data->trans_date    = date('Y-m-d');
            $transaction_data->created_by    = Auth::user()->id;
            $transaction_data->created_ip    = request()->ip();
            $transaction_data->created_at    = date('Y-m-d H:i:s');

            $transaction_save = $transaction_data->save();

        }else{

            $sale_data = [
                'invoice_no'       => $invoice_no,
                'sale_category_id' => $request->sale_category_id,
                'agent_id'         => $request->agent_id,
                'sale_amount'      => $request->net_total,
                'discount'         => $request->discount,
                'amount'           => $request->invoice_amount,
                'remarks'          => $request->remarks,
                "is_active"        => 1,
                'created_by'       => Auth::user()->id,
                'created_ip'       => request()->ip(),
                'created_at'       => date('Y-m-d H:i:s'),
            ];

            $sale_save = DB::table('sales')->insert($sale_data);

            $details       = $request->details;
            $discount      = $request->discount2;
            $amount        = $request->amount2;
            $net_total_row = $request->net_total_row;

            $sale_id   = DB::getPdo()->lastInsertId();

            $sale_detail_data = [];

            foreach($details as $key => $item){
                $sale_detail_data[] = [
                    'sale_id'           => $sale_id,
                    'details'           => $item,
                    'discount'          => $discount[$key],
                    'net_amount'        => $amount[$key],
                    'invoice_amount'    => $net_total_row[$key],
                    "is_active"         => 1,
                    'created_by'        => Auth::user()->id,
                    'created_ip'        => request()->ip(),
                    'created_at'        => date('Y-m-d H:i:s'),
                ];
            }

            $sale_save = DB::table('sale_details')->insert($sale_detail_data);

            // transaction data
            $transaction_data = new  AccTransactionInfo();

            $transaction_data->sales_id      = $sale_id;
            $transaction_data->debit_acc     = $request->agent_id;
            $transaction_data->credit_acc    = 0;
            $transaction_data->debit_amount  = $request->invoice_amount;
            $transaction_data->credit_amount = 0.00;
            $transaction_data->trans_type    = 1;
            $transaction_data->remarks       = $request->remarks;
            $transaction_data->is_active     = 1;
            $transaction_data->trans_date    = date('Y-m-d');
            $transaction_data->created_by    = Auth::user()->id;
            $transaction_data->created_ip    = request()->ip();
            $transaction_data->created_at    = date('Y-m-d H:i:s');

            $transaction_save = $transaction_data->save();
        }

        $saleEncryptId = Crypt::encrypt($sale_id);

        return response()->json([
            'status' => $sale_save ? 'success' : 'error',
            'msg'    => $sale_save ? 'Successfully Sale' : 'Someting went wrong',
            'data'   => $saleEncryptId,
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
    public function edit($encodedID)
    {
        $id=($encodedID?crypt::decrypt($encodedID):'');
        if(!empty($id)) {
            $agent_info = AgentRecord::all();
            $airline_info = AirlineSetup::all();
            $sale_data = Sale::find($id);
            $sale_id = $sale_data->id;
            $sale_details = SaleDetail::where('sale_id', $sale_id)->get();
            $transaction_data = AccTransactionInfo::where('sales_id', $sale_id)->first();

            return view('sale.edit_sale', compact('agent_info', 'airline_info', 'sale_data', 'sale_details', 'transaction_data'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $sale_category = $request->sale_category_id;
        $id = $request->id;
        // sale category 1= flight else others all
        if($sale_category == 1){

            $sale_data = [
                'sale_category_id' => $request->sale_category_id,
                'agent_id'         => $request->agent_id,
                'sale_amount'      => $request->net_total,
                'discount'         => $request->discount,
                'amount'           => $request->invoice_amount,
                'remarks'          => $request->remarks,
                "is_active"        => 1,
                'updated_by'       => Auth::user()->id,
                'updated_ip'       => request()->ip(),
                'updated_at'       => date('Y-m-d H:i:s'),
            ];

         $sale_save = DB::table('sales')->where('id', $id)->update($sale_data);


            $flight_id      = $request->flight_id;
            $fare           = $request->fare;
            $tax            = $request->tax;
            $commission_per = $request->commissionPer;
            $commission     = $request->commission;
            $ait_per        = $request->aitPer;
            $ait            = $request->ait;
            $add            = $request->add;
            $amount         = $request->amount;

            //$sale_detail_data = [];
            $sale_detail_data_new = [];

            for($i=0;$i<count($flight_id);$i++){

                if(isset($request->data_primary_id[$i]) > 0){

                        $sale_detail_data = [
                            'id'                => $request->data_primary_id[$i],
                            'sale_id'           => $id,
                            'airline_id'        => $flight_id[$i],
                            'fare'              => $fare[$i],
                            'tax_per'           => $tax[$i],
                            'tax_amount'        => $tax[$i],
                            'total_amount'      => $fare[$i]+$tax[$i],
                            'commission_per'    => $commission_per[$i],
                            'commission_amount' => $commission[$i],
                            'ait_per'           => $ait_per[$i],
                            'ait_amount'        => $ait[$i],
                            'add_per'           => $add[$i],
                            'add_amount'        => $add[$i],
                            'invoice_amount'    => $amount[$i],
                            'net_amount'        => $amount[$i],
                            "is_active"         => 1,
                            'created_by'        => Auth::user()->id,
                            'created_ip'        => request()->ip(),
                            'created_at'        => date('Y-m-d H:i:s'),
                        ];

                        $sale_save = DB::table('sale_details')->where('id', $request->data_primary_id[$i])->update($sale_detail_data);
                }else{

                    $sale_detail_data_new[] = [
                        'sale_id'           => $id,
                        'airline_id'        => $flight_id[$i],
                        'fare'              => $fare[$i],
                        'tax_per'           => $tax[$i],
                        'tax_amount'        => $tax[$i],
                        'total_amount'      => $fare[$i]+$tax[$i],
                        'commission_per'    => $commission_per[$i],
                        'commission_amount' => $commission[$i],
                        'ait_per'           => $ait_per[$i],
                        'ait_amount'        => $ait[$i],
                        'add_per'           => $add[$i],
                        'add_amount'        => $add[$i],
                        'invoice_amount'    => $amount[$i],
                        'net_amount'        => $amount[$i],
                        "is_active"         => 1,
                        'created_by'        => Auth::user()->id,
                        'created_ip'        => request()->ip(),
                        'created_at'        => date('Y-m-d H:i:s'),
                    ];
                }

            }

            if($sale_detail_data_new !='' ){
              $sale_save = DB::table('sale_details')->insert($sale_detail_data_new);
            }

            // transaction data
            $transaction_data = AccTransactionInfo::where('sales_id', $id)->first();

            $transaction_data->sales_id      = $id;
            $transaction_data->debit_acc     = $request->agent_id;
            $transaction_data->credit_acc    = 0;
            $transaction_data->debit_amount  = $request->invoice_amount;
            $transaction_data->credit_amount = 0.00;
            $transaction_data->trans_type    = 1;
            $transaction_data->remarks       = $request->remarks;
            $transaction_data->is_active     = 1;
            $transaction_data->trans_date    = date('Y-m-d');
            $transaction_data->updated_by    = Auth::user()->id;
            $transaction_data->updated_ip    = request()->ip();
            $transaction_data->created_at    = date('Y-m-d H:i:s');

            $transaction_save = $transaction_data->save();


        }else{

            $sale_data = [
                'sale_category_id' => $request->sale_category_id,
                'agent_id'         => $request->agent_id,
                'sale_amount'      => $request->net_total,
                'discount'         => $request->discount,
                'amount'           => $request->invoice_amount,
                'remarks'          => $request->remarks,
                "is_active"        => 1,
                'updated_by'       => Auth::user()->id,
                'updated_ip'       => request()->ip(),
                'updated_at'       => date('Y-m-d H:i:s'),
            ];

            $sale_save = DB::table('sales')->where('id', $id)->update($sale_data);

            $details       = $request->details;
            $discount      = $request->discount2;
            $amount        = $request->amount2;
            $net_total_row = $request->net_total_row;

            $sale_detail_data_new = [];

            for($i=0;$i<count($details);$i++){

                if(isset($request->data_primary_id2[$i]) > 0){
                    $sale_detail_data = [
                        'id'                => $request->data_primary_id2[$i],
                        'sale_id'           => $id,
                        'details'           => $details[$i],
                        'discount'          => $discount[$i],
                        'net_amount'        => $amount[$i],
                        'invoice_amount'    => $net_total_row[$i],
                        "is_active"         => 1,
                        'created_by'        => Auth::user()->id,
                        'created_ip'        => request()->ip(),
                        'created_at'        => date('Y-m-d H:i:s'),
                    ];

                    $sale_save = DB::table('sale_details')->where('id', $request->data_primary_id2[$i])->update($sale_detail_data);

                }else{
                    $sale_detail_data_new[] = [
                        'sale_id'           => $id,
                        'details'           => $details[$i],
                        'discount'          => $discount[$i],
                        'net_amount'        => $amount[$i],
                        'invoice_amount'    => $net_total_row[$i],
                        "is_active"         => 1,
                        'created_by'        => Auth::user()->id,
                        'created_ip'        => request()->ip(),
                        'created_at'        => date('Y-m-d H:i:s'),
                    ];
                }
            }

            if($sale_detail_data_new !='' ){
                $sale_save = DB::table('sale_details')->insert($sale_detail_data_new);
              }

            // transaction data
            $transaction_data = AccTransactionInfo::where('sales_id', $id)->first();

            $transaction_data->sales_id      = $id;
            $transaction_data->debit_acc     = $request->agent_id;
            $transaction_data->credit_acc    = 0;
            $transaction_data->debit_amount  = $request->invoice_amount;
            $transaction_data->credit_amount = 0.00;
            $transaction_data->trans_type    = 1;
            $transaction_data->remarks       = $request->remarks;
            $transaction_data->is_active     = 1;
            $transaction_data->trans_date    = date('Y-m-d');
            $transaction_data->updated_by    = Auth::user()->id;
            $transaction_data->updated_ip    = request()->ip();
            $transaction_data->updated_at    = date('Y-m-d H:i:s');

            $transaction_save = $transaction_data->save();

        }
        return response()->json([
            'status' => $sale_save ? 'success' : 'error',
            'msg'    => $sale_save ? 'Successfully Sale' : 'Something went wrong',
            'data'   => ($id?crypt::encrypt($id):'')
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $sale_delete = Sale::where('id', $id)->delete();
        $sale_details_delete = SaleDetail::where('sale_id', $id)->delete();
        $transaction_delete  = AccTransactionInfo::where('sales_id', $id)->delete();

        return response()->json([
            'status' => $sale_delete ? 'success' : 'error',
            'msg'    => $sale_delete ? 'Successfully Sale Delated' : 'Someting went wrong',
        ]);
    }
    // today sale list
    public function today_sale_list()
    {
        $agent_info   = AgentRecord::all();

        return view('sale.today_sale_list', compact('agent_info'));
    }
    public function get_today_sale_list_data(Request $request)
    {
        header("Content-Type: application/json");
        $sale_category_id   = $request->sale_category_id;
        $agent_id           = $request->agent_id;


        $start = $request->start;
        $limit = $request->length;
        $search_content = ($request['search']['value'] != '') ? $request['search']['value'] : false;


        $request_data = [
            'start'   => $start,
            'limit'   => $limit,
            'sale_category_id' => $sale_category_id,
            'agent_id'    => $agent_id,
        ];

        $response = $this->sale_model->sale_today_list_data($request_data, $search_content);
        $count = DB::select("SELECT FOUND_ROWS() as `row_count`")[0]->row_count;
        $response['recordsTotal']    = $count;
        $response['recordsFiltered'] = $count;
        $response['draw']            = $request->draw;

        echo json_encode($response);
    }

    public function sale_invoice($encodedID){
        $id=($encodedID?crypt::decrypt($encodedID):'');
        if(!empty($id)) {
            $organization_info = OrganizationSetup::first();
            $sale_invoice_information = $this->sale_details_model->sale_invoice_information($id);

            return view('sale.sale_invoice', compact('organization_info', 'sale_invoice_information'));
        }
    }
    public function get_flight_setup_info(Request $request){

        $filght_id   = $request->filght_value_id;
        $filght_info = AirlineSetup::where('id', $filght_id)->first();
       // $organization_info = OrganizationSetup::first();

        return response()->json([
            'status' => true,
            'message' => 'Data get successfully',
            'data' => [
                'flight_data'       => $filght_info,
                //'organization_data' => $organization_info,
            ]
        ]);

    }
    public function salesInvoicePdf($encodedID) {
        $id=($encodedID?crypt::decrypt($encodedID):'');

        $organization_info        = OrganizationSetup::first();
        $sale_invoice_information = $this->sale_details_model->sale_invoice_information($id);

        $config = ['instanceConfigurator' => function ($mpdf) use($organization_info) {
            $mpdf->SetWatermarkImage(asset('public/assets/images/'.$organization_info->logo));
            $mpdf->SetWatermarkImage(
                asset('public/assets/images/'.$organization_info->logo) . "", .1,
                array(70, 20),
                array(77, 150)
            );
            $mpdf->showWatermarkImage = true;
            $mpdf->SetTitle('Sales Invoice');
            $page_footer_html = view()->make('pdf.pdfHeader', ['organization_info'=>$organization_info])->render();

            $mpdf->SetHTMLHeader($page_footer_html);

            $pagefooter="If you have any question, please contact ".(!empty($organization_info->mobile)?" Mobile:".$organization_info->mobile:'').(!empty($organization_info->email)?", Email: ".$organization_info->email:'').". Printed Date: ".date('d M, Y');
            $mpdf->SetHTMLFooter("<div style='text-align: center;font-size:10px;color:gray;'>".$pagefooter." || Page No: {PAGENO} of {nb}</div>");

            $margin_left = 5;
            $margin_right = 5;
            $margin_top = 10;
            $margin_bottom = 5;
            $paper_type = 'a4';

            $mpdf->AddPage('P', '', '', '', '', $margin_left, $margin_right, $margin_top, $margin_bottom, 5, 5, '', '', '', '', '', '', '', '', '', $paper_type);
        }];

        $pdf = PDF::loadHtml(view('pdf.document', compact('organization_info','sale_invoice_information')), $config);

        return $pdf->stream('SalesInvoice.pdf');

    }
    // Invoice Generate  key
    public function invoiceGenerator($serial_no, $length = 4)
    {
        return str_repeat("0", ($length - strlen($serial_no))) . $serial_no;
    }
}
