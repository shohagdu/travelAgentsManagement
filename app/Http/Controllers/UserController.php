<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AclRoleInfo;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Session;
use DB;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
      $this->middleware('auth');
    }
    public function index()
    {
        $user_info = DB::table('users AS USR')
                      ->leftJoin('acl_role_infos AS ROLE', 'ROLE.id', '=', 'USR.role_id')
                      ->select( 'USR.id as UserId','USR.name as user_name','USR.mobile','USR.email','USR.picture', 'ROLE.role_name')
                      ->orderBy('USR.id', 'desc')
                      ->get();

        return view('user.user_list', compact('user_info'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role_info = AclRoleInfo::where('is_active', '!=', 0)->get();
        return view('user.user_add', compact('role_info'));
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
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role_id'  => 'required',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if(isset($request->picture)){
            $imageName = 'picture_'.time().'.'.$request->picture->extension();  
            $request->picture->move(public_path('assets/images/users'), $imageName);
            $pictureName = $imageName;
          }else{
            $pictureName = "profile.jpg";
          }
          
        $data=  User::create([
            'name'      => $request['name'],
            'role_id'   => $request['role_id'],
            'mobile'    => $request['mobile'],
            'email'     => $request['email'],
            'picture'   => $pictureName,
            'password'  => Hash::make($request['password']),
            'created_by'=> Auth::user()->id,
            'created_ip'=> request()->ip(),
            'created_at'=> date('Y-m-d H:i:s'),
        ]);

        if($data){
            return redirect()->route('user-list')->with('flash.message', 'User Sucessfully Added!')->with('flash.class', 'success');
        }else{
            return redirect()->route('user-list')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
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
        $userId    = Crypt::decrypt($id);
        $user_info = User::find($userId);
        $role_info = AclRoleInfo::where('is_active', '!=', 0)->get();

        return view('user.user_edit' , compact('user_info','role_info'));
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
            'name'     => ['required', 'string', 'max:255'],
            'role_id'  => 'required',
            'email'    => ['required', 'string', 'email'],
        ]);

        if(isset($request->picture)){
            $imageName = 'picture_'.time().'.'.$request->picture->extension();  
            $request->picture->move(public_path('assets/images/users'), $imageName);
            $pictureName = $imageName;
          }else{
            $pictureName = $request->old_picture;
          }
          
        $user_data =  [
            'name'      => $request['name'],
            'role_id'   => $request['role_id'],
            'mobile'    => $request['mobile'],
            'email'     => $request['email'],
            'picture'   => $pictureName,
            'updated_by'=> Auth::user()->id,
            'updated_ip'=> request()->ip(),
            'updated_at'=> date('Y-m-d H:i:s'),
        ];
        $save_user = DB::table('users')->where('id', $id)->update($user_data);

        if($save_user){
            return redirect()->route('user-list')->with('flash.message', 'User Sucessfully Updated!')->with('flash.class', 'success');
        }else{
            return redirect()->route('user-list')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
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
        $delete_user = DB::table('users')->where('id', $id)->delete();

        if($delete_user){
            return redirect()->route('user-list')->with('flash.message', 'User Sucessfully Delated!')->with('flash.class', 'success');
        }else{
            return redirect()->route('user-list')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
        }
    }
    public function myProfile(){
        $id = Auth::user()->id;
        $user_info = User::findOrFail($id);
        return view('user.user_profile' , compact('user_info'));
    }
    public function changePassword(){
        return view('user.user_password_change');
    }

    public function change_password_stote(Request $request){
        $id = Auth::user()->id;
        $user_info = User::findOrFail($id);

        if (Hash::check($request->old_password, $user_info->password)) { 

            $validated = $request->validate([
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
    
            $user_data =  [
                'password'  => Hash::make($request['password']),
                'updated_by'=> Auth::user()->id,
                'updated_ip'=> request()->ip(),
                'updated_at'=> date('Y-m-d H:i:s'),
            ];
            $save_user = DB::table('users')->where('id', $id)->update($user_data);

            if($save_user){
                return redirect()->route('myProfile')->with('flash.message', 'Password Change Sucessfully')->with('flash.class', 'success');
            }else{
                return redirect()->route('changePassword')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
            }

        }else{
           
            return redirect()->route('changePassword')->with('flash.message', 'Password does not match. Please Try Again!')->with('flash.class', 'danger');
        }

    }
}
