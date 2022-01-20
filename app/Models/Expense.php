<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Expense extends Model
{
    use HasFactory;

    public function get_expense_list_data($receive, $search_content)
    {
    	$query = DB::table("expenses AS EXP")
    		->select(DB::raw('SQL_CALC_FOUND_ROWS EXP.id'),'EXP.amount','EXP.date', 'EXP.remarks', 'CAT.title')
            ->leftJoin('sale_categories AS CAT', function($join){
                $join->on('CAT.id', '=', 'EXP.category_id');
            })
            ->offset($receive['start'])
            ->limit($receive['limit'])
            ->orderBy('EXP.id', 'DESC');

        if($search_content != false){
            $query->Where("EXP.amount", "LIKE", $search_content)
                  ->orWhere("EXP.remarks", "LIKE", $search_content);
        }

        if($receive['trans_date'] !=''){
            $query->Where("date", "=", date('Y-m-d', strtotime($receive['trans_date'])));
        }

        $info = $query->get();
        $allData = [];
        if (!empty($info)) {
            foreach ($info as $key => $row) {
                $allData[$key] = $row;
                $allData[$key]->TransactionDate = date('d-m-Y', strtotime($row->date));
            }
        }
        $data['data'] = $allData;
        return $data;
    }
}
