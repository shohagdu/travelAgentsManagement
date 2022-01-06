<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\AclMenuInfo;
use App\Models\AclRoleInfo;
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

    // role addd area

    public function role_list()
    {
        $role_info = AclRoleInfo::where('is_active', '!=', 0)->get();
        
        return view('user.role.list', compact('role_info'));

    }

    public function role_create()
    {
        $get_menu_info = AclMenuInfo::where(['is_active'=> 1,'is_main_menu'=>1])->get();
       
        if(!empty($get_menu_info)){
            foreach($get_menu_info as $key=> $mainMenu){
               $get_menu_info[$key]['mainChild']= AclMenuInfo::where(['is_active'=> 1,'is_main_menu'=>2,'parent_id'=> $mainMenu->id])->get();
            }
        }
        return view('user.role.create', compact('get_menu_info'));
    }

    public function role_store(Request $request){
        $role_info =  $request->role_info;

        $role_data = [
            'role_name'   => $request->role_name,
            'role_info'   => (!empty($role_info)? json_encode($role_info,JSON_NUMERIC_CHECK):NULL),
            'is_active'   => $request->is_active,
            'created_by'  => Auth::user()->id,
            'created_ip'  => request()->ip(),
            'created_at'  => date('Y-m-d H:i:s'),
        ];

        $data_save = DB::table('acl_role_infos')->insert($role_data);

        if($data_save){
            return redirect()->route('role.list')->with('flash.message', 'Sucessfully Role Added!')->with('flash.class', 'success');
        }else{
            return redirect()->route('role.create')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
        }
    }

    public function role_edit($id)
    {
        $menuAccessArray = [];
        $get_role_info = AclRoleInfo::where(['is_active'=> 1, 'id'=> $id])->first();
        $menuAccess = json_decode($get_role_info->role_info);
        foreach($menuAccess as $key=>$access){
            if(gettype($access) == 'object') {
                foreach($access as $asses) {
                    array_push($menuAccessArray, $asses);
                }
            }
            if(gettype($access) == 'integer') {
                array_push($menuAccessArray, $access);
            }

            array_push($menuAccessArray, $key);
        }

        $menus = AclMenuInfo::where(['is_active'=> 1,'is_main_menu'=>1])->get();
       
        if(!empty($menus)){
            foreach($menus as $key=> $mainMenu){
               $menus[$key]['mainChild']= AclMenuInfo::where(['is_active'=> 1,'is_main_menu'=>2,'parent_id'=> $mainMenu->id])->get();
            }
        }

        return view('user.role.edit', compact('menus', 'get_role_info', 'menuAccess', 'menuAccessArray'));
    }

    public function role_update(Request $request, $id){

        $role_info =  $request->role_info;
    
        $role_data = [
            'role_name'   => $request->role_name,
            'role_info'   => (!empty($role_info)? json_encode($role_info,JSON_NUMERIC_CHECK):NULL),
            'is_active'   => $request->is_active,
            'updated_by'  => Auth::user()->id,
            'updated_ip'  => request()->ip(),
            'updated_at'  => date('Y-m-d H:i:s'),
        ];

        $data_save = DB::table('acl_role_infos')->where('id', '=', $id)->update($role_data);

        if($data_save){
            return redirect()->route('role.list')->with('flash.message', 'Sucessfully Role Updated!')->with('flash.class', 'success');
        }else{
            return redirect()->route('role.create')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
        }
    }

    public function role_destroy($id){
    
        $role_data = [
            'is_active'   => 0,
            'updated_by'  => Auth::user()->id,
            'updated_ip'  => request()->ip(),
            'updated_at'  => date('Y-m-d H:i:s'),
        ];

        $data_delete = DB::table('acl_role_infos')->where('id', '=', $id)->update($role_data);

        if($data_delete){
            return redirect()->route('role.list')->with('flash.message', 'Sucessfully Role Delated!')->with('flash.class', 'success');
        }else{
            return redirect()->route('role.create')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
        }
    }
}
