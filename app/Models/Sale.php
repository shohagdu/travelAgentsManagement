<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use DB;

class Sale extends Model
{
    use HasFactory;

    public function sale_list_data($receive, $search_content)
    {

        $query = DB::table("sales AS SALE")
            ->join('agent_records AS AGRD', function ($join) {
                $join->on('AGRD.id', '=', 'SALE.agent_id');

            })
            // DB::raw( 'Crypt::encrypt(SALE.id) as encryptedID'),
            ->select(DB::raw('SQL_CALC_FOUND_ROWS SALE.id'), 'SALE.sale_amount', 'SALE.discount', 'SALE.amount', 'SALE.sale_category_id','SALE.remarks', 'AGRD.name as agent_name')
            ->offset($receive['start'])
            ->limit($receive['limit'])
            ->orderBy('id', 'DESC');

        if ($search_content != false) {

            $query->Where("AGRD.name", "LIKE", $search_content)
                ->orWhere("AGRD.name", "LIKE", $search_content);

        }

        if ($receive['sale_category_id'] != '') {
            $query->Where("SALE.sale_category_id", "=", $receive['sale_category_id']);
        }
        if ($receive['agent_id'] != '') {
            $query->Where("SALE.agent_id", "=", $receive['agent_id']);
        }
        $info = $query->get();
        $allData = [];
        if (!empty($info)) {
            foreach ($info as $key => $row) {
                $allData[$key] = $row;
                $allData[$key]->encryptedID = Crypt::encrypt($row->id);
            }
        }
        $data['data'] = $allData;
        return $data;
    }

    // today sale list

    public function sale_today_list_data($receive, $search_content)
    {
        $query = DB::table("sales AS SALE")
            ->join('agent_records AS AGRD', function ($join) {
                $join->on('AGRD.id', '=', 'SALE.agent_id');

            })
            ->select(DB::raw('SQL_CALC_FOUND_ROWS SALE.id'), 'SALE.sale_amount', 'SALE.discount', 'SALE.amount', 'SALE.sale_category_id','SALE.remarks', 'AGRD.name as agent_name')
            ->offset($receive['start'])
            ->limit($receive['limit'])
            //->whereRaw('Date(SALE.created_at) = CURDATE()')
            ->where('SALE.created_at', '>=', date('Y-m-d') . ' 00:00:00')
            ->orderBy('id', 'DESC');

        if ($search_content != false) {

            $query->Where("AGRD.name", "LIKE", $search_content)
                ->orWhere("AGRD.name", "LIKE", $search_content);

        }

        if ($receive['sale_category_id'] != '') {
            $query->Where("SALE.sale_category_id", "=", $receive['sale_category_id']);
        }
        if ($receive['agent_id'] != '') {
            $query->Where("SALE.agent_id", "=", $receive['agent_id']);
        }

        $info = $query->get();
        $allData = [];
        if (!empty($info)) {
            foreach ($info as $key => $row) {
                $allData[$key] = $row;
                $allData[$key]->encryptedID = Crypt::encrypt($row->id);
            }
        }
        $data['data'] = $allData;
        return $data;
    }

    public function today_sale_balance()
    {
        return $query = DB::table("sales AS SALE")
            ->select('SALE.sale_amount', 'SALE.discount', 'SALE.amount', 'SALE.sale_category_id', 'AGRD.name as agent_name')
            ->join('agent_records AS AGRD', function ($join) {
                $join->on('AGRD.id', '=', 'SALE.agent_id');
            })
            ->where('SALE.created_at', '>=', date('Y-m-d') . ' 00:00:00')
            ->orderBy('SALE.id', 'DESC')
            ->get();
    }
    
    public function search_today_sale_balance($sale_category_id)
    {
        return $query = DB::table("sales AS SALE")
            ->select('SALE.sale_amount', 'SALE.discount', 'SALE.amount', 'SALE.sale_category_id', 'AGRD.name as agent_name')
            ->join('agent_records AS AGRD', function ($join) {
                $join->on('AGRD.id', '=', 'SALE.agent_id');
            })
            ->where('SALE.created_at', '>=', date('Y-m-d') . ' 00:00:00')
            ->where('SALE.sale_category_id', '=', $sale_category_id)
            ->orderBy('SALE.id', 'DESC')
            ->get();
    }

    public function today_credit_balance()
    {

        return $query = DB::table("acc_transaction_infos AS TRNS")
            ->select('TRNS.credit_amount', 'TRNS.trans_date', 'TRNS.remarks', 'AGRD.name as agent_name')
            ->join('agent_records AS AGRD', function ($join) {
                $join->on('AGRD.id', '=', 'TRNS.credit_acc');
            })
            ->where('TRNS.trans_type', '=', 2)
            ->where('TRNS.created_at', '>=', date('Y-m-d') . ' 00:00:00')
            ->orderBy('TRNS.id', 'DESC')
            ->get();
    }

    public function today_debit_balance()
    {
        return $query = DB::table("acc_transaction_infos AS TRNS")
            ->select('TRNS.debit_amount', 'TRNS.trans_date', 'TRNS.remarks', 'AGRD.name as agent_name')
            ->join('agent_records AS AGRD', function ($join) {
                $join->on('AGRD.id', '=', 'TRNS.debit_acc');
            })
            ->where('TRNS.trans_type', '=', 3)
            ->where('TRNS.created_at', '>=', date('Y-m-d') . ' 00:00:00')
            ->orderBy('TRNS.id', 'DESC')
            ->get();
    }

    public function due_list_view(){
        return $query  = DB::table("agent_records AS AGNT")
                        ->select('AGNT.address as agent_address','AGNT.mobile as agent_mobile','AGNT.company_name as company_name','AGNT.name as agent_name','cr.creditAmnt as credit_amount','dr.debitAmnt as debit_amount')
                        ->leftJoinSub(self::payableCreditSubQuery(), 'cr', function($pcs) {
                        $pcs->on('cr.credit_acc', '=', 'AGNT.id');
                        })
                        ->leftJoinSub(self::getDebitAmnt(), 'dr', function($pcs) {
                        $pcs->on('dr.debit_acc', '=', 'AGNT.id');
                        })
                        ->where('AGNT.is_active', '=',1)
                        ->orderBy('AGNT.id', 'DESC')
                        ->groupBy('AGNT.id')
                        ->get();
    }
    public function agent_due_balance_view($agent_id){
        return $query  = DB::table("agent_records AS AGNT")
                        ->select('AGNT.address as agent_address','AGNT.mobile as agent_mobile','AGNT.company_name as company_name','AGNT.name as agent_name','cr.creditAmnt as credit_amount','dr.debitAmnt as debit_amount')
                        ->leftJoinSub(self::payableCreditSubQuery(), 'cr', function($pcs) {
                        $pcs->on('cr.credit_acc', '=', 'AGNT.id');
                        })
                        ->leftJoinSub(self::getDebitAmnt(), 'dr', function($pcs) {
                        $pcs->on('dr.debit_acc', '=', 'AGNT.id');
                        })
                        ->where('AGNT.is_active', '=',1)
                        ->where('AGNT.id', '=', $agent_id)
                        ->orderBy('AGNT.id', 'DESC')
                        ->groupBy('AGNT.id')
                        ->get();
    }
    
    public static  function payableCreditSubQuery()
    {
        return DB::table("acc_transaction_infos")
            ->selectRaw('SUM(credit_amount) AS creditAmnt,credit_acc')->where('is_active','=',1)->groupBy('credit_acc');
    }
    public static  function getDebitAmnt()
    {
        return DB::table("acc_transaction_infos as drTbl")
            ->selectRaw('SUM(drTbl.debit_amount) AS debitAmnt,drTbl.debit_acc')->where('drTbl.is_active','=',1)->groupBy('debit_acc');
    }
    public function currentDueAmount(){
        return $query  = DB::table("agent_records AS AGNT")
            ->selectRaw('SUM(dr.debitAmnt)-SUM(cr.creditAmnt) as dueAmount')
            ->leftJoinSub(self::payableCreditSubQuery(), 'cr', function($pcs) {
                $pcs->on('cr.credit_acc', '=', 'AGNT.id');
            })
            ->leftJoinSub(self::getDebitAmnt(), 'dr', function($pcs) {
                $pcs->on('dr.debit_acc', '=', 'AGNT.id');
            })
            ->where('AGNT.is_active', '=',1)
            ->orderBy('AGNT.id', 'DESC')
            ->first();
    }

}
