<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AgentRecord;
use App\Models\AirlineSetup;
use App\Models\OrganizationSetup;
use Illuminate\Support\Facades\Auth;
use App\Models\Sale;
use App\Models\SaleDetail;
use Session;
use DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $sale_model;
	public function __construct()
	{
	    $this->middleware('auth');
        $this->sale_model = new Sale();

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
       
        $validated = $request->validate([
            'sale_category_id' => ['required'],
            'agent_id'         => ['required'],
            'net_total'        => ['required'],
        ]);

        $sale_category = $request->sale_category_id;

        // sale category 1= flight else others all
        if($sale_category == 1){

            $sale_data = [
                'sale_category_id' => $request->sale_category_id,
                'agent_id'         => $request->agent_id,
                'sale_amount'      => $request->net_total,
                'discount'         => $request->discount,
                'amount'           => $request->invoice_amount,
                "is_active"        => 1,
                'created_by'       => Auth::user()->id,
                'created_ip'       => request()->ip(),
                'created_at'       => date('Y-m-d H:i:s'),
            ];

            $sale_save = DB::table('sales')->insert($sale_data);


            $flight_id    = $request->flight_id;
            $fare         = $request->fare;
            $tax          = $request->tax;
            $commission   = $request->commission;
            $commissionPer= $request->commissionPer;
            $ait          = $request->ait;
            $aitPer       = $request->aitPer;
            $add          = $request->add;
            $amount       = $request->amount;

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
                    'commission_per'    => $commissionPer[$key],
                    'commission_amount' => $commission[$key],
                    'ait_per'           => $aitPer[$key],
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

        }else{
            $sale_data = [
                'sale_category_id' => $request->sale_category_id,
                'agent_id'         => $request->agent_id,
                'sale_amount'      => $request->net_total,
                'discount'         => $request->discount,
                'amount'           => $request->invoice_amount,
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
        }    

        if($sale_save){
            return redirect()->route('sale-list')->with('flash.message', 'Sale Sucessfully Saved!')->with('flash.class', 'success');
        }else{
            return redirect()->route('sale-list')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
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
        $agent_info   = AgentRecord::all();
        $airline_info = AirlineSetup::all();
        $sale_data = Sale::find($id);
        $sale_id = $sale_data->id;
        $sale_details = SaleDetail::where('sale_id', $sale_id)->get();
       
        return view('sale.edit_sale', compact('agent_info', 'airline_info','sale_data','sale_details'));
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
            'sale_category_id' => ['required'],
            'agent_id'         => ['required'],
            'net_total'        => ['required'],
        ]);

        $sale_category = $request->sale_category_id;

        // sale category 1= flight else others all
        if($sale_category == 1){

            $sale_data = [
                'sale_category_id' => $request->sale_category_id,
                'agent_id'         => $request->agent_id,
                'sale_amount'      => $request->net_total,
                'discount'         => $request->discount,
                'amount'           => $request->invoice_amount,
                "is_active"        => 1,
                'created_by'       => Auth::user()->id,
                'created_ip'       => request()->ip(),
                'created_at'       => date('Y-m-d H:i:s'),
            ];

         $sale_save = DB::table('sales')->where('id', $id)->update($sale_data);


            $flight_id    = $request->flight_id;
            $fare         = $request->fare;
            $tax          = $request->tax;
            $commission   = $request->commission;
            $commissionPer= $request->commissionPer;
            $ait          = $request->ait;
            $aitPer       = $request->aitPer;
            $add          = $request->add;
            $amount       = $request->amount;

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
                            'commission_per'    => $commissionPer[$i],
                            'commission_amount' => $commission[$i],
                            'ait_per'           => $aitPer[$i],
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
                        'commission_per'    => $commissionPer[$i],
                        'commission_amount' => $commission[$i],
                        'ait_per'           => $aitPer[$i],
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

          
        }else{

            $sale_data = [
                'sale_category_id' => $request->sale_category_id,
                'agent_id'         => $request->agent_id,
                'sale_amount'      => $request->net_total,
                'discount'         => $request->discount,
                'amount'           => $request->invoice_amount,
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
        }    

        if($sale_save){
            return redirect()->route('sale-list')->with('flash.message', 'Sale Sucessfully Updated!')->with('flash.class', 'success');
        }else{
            return redirect()->route('sale-list')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
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
