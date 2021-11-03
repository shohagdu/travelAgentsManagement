<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class SaleDetail extends Model
{
    use HasFactory;
    public function sale_details_data($id){
        $sale_query = DB::table("sale_details AS SALED")
                    ->select('SALED.*','AIRS.airline_name as airline_name', 'SALE.discount as invoice_discount','SALE.agent_id as agent_id')
                    ->leftJoin('airline_setups AS AIRS', function($join){
                    $join->on('AIRS.id', '=', 'SALED.airline_id');
                    })
                    ->leftJoin('sales AS SALE', function($join){
                        $join->on('SALE.id', '=', 'SALED.sale_id');
                    })
                   ->where('SALED.sale_id', '=',$id);

        return $data = $sale_query->get();
    }
}
