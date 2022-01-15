<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class SaleDetail extends Model
{
    use HasFactory;
    public function sale_invoice_information($id){
        $sale_query = DB::table("sale_details AS SALED")
                    ->select('SALED.*','SALE.id as saleId','SALE.invoice_no','SALE.sale_date','AGNT.name as agent_name','AGNT.address', 'AGNT.mobile','AGNT.email','AIRS.airline_name as airline_name', 'SALE.discount as invoice_discount','SALE.agent_id as agent_id', 'SALE.remarks as saleRemarks','USER.name as userName')
                    ->leftJoin('airline_setups AS AIRS', function($join){
                            $join->on('AIRS.id', '=', 'SALED.airline_id');
                    })
                    ->leftJoin('sales AS SALE', function($join){
                        $join->on('SALE.id', '=', 'SALED.sale_id');
                    })
                    ->leftJoin('agent_records AS AGNT', function($join){
                        $join->on('AGNT.id', '=', 'SALE.agent_id');
                    })
                    ->leftJoin('users AS USER', function($join){
                        $join->on('USER.id', '=', 'SALE.created_by');
                    })
                   ->where('SALED.sale_id', '=',$id);

        return $data = $sale_query->get();
    }
    public function sale_info($id){
        $sale_query = DB::table("sales")
                    ->select('sales.*','users.name as userName')
                    ->join('users', function($join){
                        $join->on('users.id', '=', 'sales.created_by');
                    })
                   ->where('sales.id', '=',$id);
        if($sale_query->count()>0){
            return $sale_query->first();
        }else{
            return false;
        }
    }

}
