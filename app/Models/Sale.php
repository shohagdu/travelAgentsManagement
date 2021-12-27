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
}
