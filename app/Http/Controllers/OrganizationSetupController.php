<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrganizationSetup;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;


class OrganizationSetupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organization_info =  OrganizationSetup::first();
        $time_zone_list = TimeZoneList();
        $currency_list  = currencyList();
        return view('organization_setup', compact('organization_info','time_zone_list','currency_list'));
    }

    public function organization_save(Request $request)
    {  

      $validated = $request->validate([
        'name'    => ['required'],
        'mobile'  => ['required'],
        'address' => ['required'],
       ]);
       
        if(isset($request->logo)){
            $imageName = 'logo_'.time().'.'.$request->logo->extension();  
            $request->logo->move(public_path('assets/images'), $imageName);
            $logo = $imageName;
          }else{
            $logo = $request->pre_logo;
          }

        if(isset($request->templete_logo)){
            $imageName = 'templete_logo_'.time().'.'.$request->templete_logo->extension();  
            $request->templete_logo->move(public_path('assets/images'), $imageName);
            $templete_logo = $imageName;
          }else{
            $templete_logo = $request->pre_templete_logo;
          }

        if(isset($request->favicon)){
            $imageName = 'favicon_'.time().'.'.$request->favicon->extension();  
            $request->favicon->move(public_path('assets/images'), $imageName);
            $favicon = $imageName;
          }else{
            $favicon = $request->pre_favicon;
          }

        $organization_info =  OrganizationSetup::first();
      
        if(empty($organization_info)){
              $organization_data =[
                "name"            => $request->name,
                "address"         => $request->address,
                "mobile"          => $request->mobile,
                "email"           => $request->email,
                "telephone"       => $request->telephone,
                "website_address" => $request->website_address,
                "logo"            => $logo,
                "templete_logo"   => $templete_logo,
                "favicon"         => $favicon,
                "footer_text"     => $request->footer_text,
                "time_zone"       => $request->time_zone,
                "currency"        => $request->currency,
                "tradelicense_no" => $request->tradelicense_no,
                "vat_no"          => $request->vat_no,
                "per_invoice_deduction_amount" => $request->per_invoice_deduction_amount,
                "tax_amount"      => $request->tax_amount	,
                "ait"             => $request->ait,
                "is_active"       => 1,
                'created_by' => Auth::user()->id,
                'created_ip' => request()->ip(),
                'created_at' => date('Y-m-d H:i:s'),
              ];

              $save = DB::table('organization_setups')->insert($organization_data);
        }else{
            $id = $organization_info->id;

            $organization_data =[
              "name"            => $request->name,
              "address"         => $request->address,
              "mobile"          => $request->mobile,
              "email"           => $request->email,
              "telephone"       => $request->telephone,
              "website_address" => $request->website_address,
              "logo"            => $logo,
              "templete_logo"   => $templete_logo,
              "favicon"         => $favicon,
              "footer_text"     => $request->footer_text,
              "time_zone"       => $request->time_zone,
              "currency"        => $request->currency,
              "tradelicense_no" => $request->tradelicense_no,
              "vat_no"          => $request->vat_no,
              "per_invoice_deduction_amount" => $request->per_invoice_deduction_amount,
              "tax_amount"      => $request->tax_amount	,
              "ait"             => $request->ait,
              "is_active"       => 1,
              'updated_by' => Auth::user()->id,
              'updated_ip' => request()->ip(),
              'updated_at' => date('Y-m-d H:i:s'),
            ];

            $save = DB::table('organization_setups')->where('id', $id)->update($organization_data);
        }
          
        if($save){
            return redirect()->route('organization-setup')->with('flash.message', 'Organization Sucessfully Saved!')->with('flash.class', 'success');
        }else{
            return redirect()->route('organization-setup')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
        }
    }

}
