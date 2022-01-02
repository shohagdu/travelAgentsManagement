<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\AclMenuInfo;
use DB;
use session;
class AclMenuRoleController extends Controller
{
    public function index()
    {
        $menu_info = AclMenuInfo::where('is_active', '!=', 0)->get();
        return view('user.menu.list', compact('menu_info'));

    }

    public function create()
    {
        $get_menu_info = AclMenuInfo::where('is_active', '!=', 0)->get();
        return view('user.menu.create', compact('get_menu_info'));
    }
    public function store(Request $request)
    {
        $menu_info = new AclMenuInfo();

        $menu_info->title            = $request->title;
        $menu_info->link             = $request->link;
        $menu_info->parent_id        = $request->parent_id;
        $menu_info->glyphicon_icon   = $request->glyphicon_icon;
        $menu_info->display_position = $request->display_position;
        $menu_info->is_main_menu     = $request->is_main_menu;
        $menu_info->is_active        = $request->is_active;
        $menu_info->created_by       = Auth::user()->id;
        $menu_info->created_ip       = request()->ip();
        $menu_info->created_at       = date('Y-m-d H:i:s');

        $data_save = $menu_info->save();

        if($data_save){
            return redirect()->route('menu.list')->with('flash.message', 'Sucessfully Menu Added!')->with('flash.class', 'success');
        }else{
            return redirect()->route('menu.create')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
        }
    }
    public function edit($id)
    {
        $menu_info = AclMenuInfo::find($id);
        $get_menu_info = AclMenuInfo::where('is_active', '!=', 0)->get();

        return view('user.menu.edit', compact('menu_info','get_menu_info'));
    }

    
    public function update(Request $request, $id)
    {
        $menu_info =  AclMenuInfo::find($id);

        $menu_info->title            = $request->title;
        $menu_info->link             = $request->link;
        $menu_info->parent_id        = $request->parent_id;
        $menu_info->glyphicon_icon   = $request->glyphicon_icon;
        $menu_info->display_position = $request->display_position;
        $menu_info->is_main_menu     = $request->is_main_menu;
        $menu_info->is_active        = $request->is_active;
        $menu_info->updated_by       = Auth::user()->id;
        $menu_info->updated_ip       = request()->ip();
        $menu_info->updated_at       = date('Y-m-d H:i:s');

        $data_save = $menu_info->save();

        if($data_save){
            return redirect()->route('menu.list')->with('flash.message', 'Sucessfully Menu Updated!')->with('flash.class', 'success');
        }else{
            return redirect()->route('menu.create')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
        }
    }

    public function destroy($id)
    {
        $menu_info =  AclMenuInfo::find($id);

        $menu_info->is_active        = 0;
        $menu_info->updated_by       = Auth::user()->id;
        $menu_info->updated_ip       = request()->ip();
        $menu_info->updated_at       = date('Y-m-d H:i:s');

        $data_delete = $menu_info->save();

        if($data_delete){
            return redirect()->route('menu.list')->with('flash.message', 'Sucessfully Menu Delated!')->with('flash.class', 'success');
        }else{
            return redirect()->route('menu.create')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
        }
    }
}
