<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaleCategory;
use Illuminate\Support\Facades\Auth;
use Session;

class SaleCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category_info = SaleCategory::all();

        return view('sale_category.sale_category_list',compact('category_info'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sale_category.sale_category');
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
            'title' => ['required'],
            'type'  => ['required'],
        ]);

        $category = new SaleCategory();

        $category->title      = $request->title;
        $category->type       = $request->type;
        $category->is_active  = 1;
        $category->created_by = Auth::user()->id;
        $category->created_ip = request()->ip();
        $category->created_at = date('Y-m-d H:i:s');

        $save = $category->save();

        if($save){
            return redirect()->route('sale-category')->with('flash.message', 'Sale Category Sucessfully Added!')->with('flash.class', 'success');
        }else{
            return redirect()->route('sale-category')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
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
        //
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
        //
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
}
