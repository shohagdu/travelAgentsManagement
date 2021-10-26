<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;
use Illuminate\Support\Facades\Auth;
use Session;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bank_data = Bank::all();

        return view('bank.bank_list', compact('bank_data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bank.bank_create');

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
            'name' => ['required'],
            'account_no' => ['required'],
        ]);

        $bank_data = new Bank();

        $bank_data->name       = $request->name;
        $bank_data->account_no = $request->account_no;
        $bank_data->is_active  = 1;
        $bank_data->created_by = Auth::user()->id;
        $bank_data->created_ip = request()->ip();
        $bank_data->created_at = date('Y-m-d H:i:s');

        $save = $bank_data->save();

        if($save){
            return redirect()->route('bank-list')->with('flash.message', 'Bank  Sucessfully Added!')->with('flash.class', 'success');
        }else{
            return redirect()->route('bank-list')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
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
        $bank_info = Bank::find($id);
        return view('bank.bank_edit', compact('bank_info'));
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
            'name' => ['required'],
            'account_no' => ['required'],
        ]);

        $bank_data =  Bank::find($id);

        $bank_data->name       = $request->name;
        $bank_data->account_no = $request->account_no;
        $bank_data->is_active  = 1;
        $bank_data->updated_by = Auth::user()->id;
        $bank_data->updated_ip = request()->ip();
        $bank_data->created_at = date('Y-m-d H:i:s');

        $save = $bank_data->save();

        if($save){
            return redirect()->route('bank-list')->with('flash.message', 'Bank  Sucessfully Updated!')->with('flash.class', 'success');
        }else{
            return redirect()->route('bank-list')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
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
        $delete = Bank::where('id', $id)->delete();

        if($delete){
            return redirect()->route('bank-list')->with('flash.message', 'Bank Sucessfully Deleted!')->with('flash.class', 'success');
        }else{
            return redirect()->route('bank-list')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
        }
    }
}
