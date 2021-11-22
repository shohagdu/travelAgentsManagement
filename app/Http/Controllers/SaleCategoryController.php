<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaleCategory;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;
class SaleCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category_info = SaleCategory::where('type','!=', 19)->where('type','!=', 20)->get();

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
            return redirect()->route('sale-category-list')->with('flash.message', 'Sale Category Sucessfully Added!')->with('flash.class', 'success');
        }else{
            return redirect()->route('sale-category-list')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
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
        $category_info = SaleCategory::find($id);

        return view('sale_category.sale_category_edit', compact('category_info'));
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
            'title' => ['required'],
            'type'  => ['required'],
        ]);

        $category =  SaleCategory::find($id);

        $category->title      = $request->title;
        $category->type       = $request->type;
        $category->is_active  = 1;
        $category->updated_by = Auth::user()->id;
        $category->updated_ip = request()->ip();
        $category->updated_at = date('Y-m-d H:i:s');

        $save = $category->save();

        if($save){
            return redirect()->route('sale-category-list')->with('flash.message', 'Sale Category Sucessfully Updated!')->with('flash.class', 'success');
        }else{
            return redirect()->route('sale-category-list')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
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
        $delete = SaleCategory::find($id);
        $delete->delete();
        
        if($delete){
            return redirect()->route('sale-category-list')->with('flash.message', 'Sale Category Sucessfully delated!')->with('flash.class', 'success');
        }else{
            return redirect()->route('sale-category-list')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
        }
    } 
    
    public function towards_index()
    {
        $category_info = SaleCategory::where('type','=', 19)->orWhere('type','=', 20)->get();

        return view('towards_category.towards_category_list',compact('category_info'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function towards_create()
    {
        return view('towards_category.towards_category');
    }

    public function towards_store(Request $request)
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
            return redirect()->route('towards-category-list')->with('flash.message', 'Towards Category Sucessfully Added!')->with('flash.class', 'success');
        }else{
            return redirect()->route('towards-category-list')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
        }
    }
    public function towards_edit($id)
    {
        $category_info = SaleCategory::find($id);

        return view('towards_category.edit_towards_category', compact('category_info'));
    }

    public function towards_update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => ['required'],
            'type'  => ['required'],
        ]);

        $category =  SaleCategory::find($id);

        $category->title      = $request->title;
        $category->type       = $request->type;
        $category->is_active  = 1;
        $category->updated_by = Auth::user()->id;
        $category->updated_ip = request()->ip();
        $category->updated_at = date('Y-m-d H:i:s');

        $save = $category->save();

        if($save){
            return redirect()->route('towards-category-list')->with('flash.message', 'Towards Category Sucessfully Updated!')->with('flash.class', 'success');
        }else{
            return redirect()->route('towards-category-list')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
        }
    }

    public function towards_destroy($id)
    {
        $delete = SaleCategory::find($id);
        $delete->delete();
        
        if($delete){
            return redirect()->route('towards-category-list')->with('flash.message', 'Towards Category Sucessfully delated!')->with('flash.class', 'success');
        }else{
            return redirect()->route('towards-category-list')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
        }
    } 
}
