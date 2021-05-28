<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Feature;
use App\Models\Settings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class HomeController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index()
    {
        return view('auth.login');
    }

    public function userHomePage()
    {
        if (Auth::user()) {
            return redirect()->intended('/dashboard');
        } else {
            return redirect()->intended('/login');
        }
    }


    // for dashboard create user
    public function dashboard()
    {
        // dd(\Request::ip());
        $user_count = User::count();
        $feature_count = Feature::count();
        return view('admin.dashboard.index', compact('user_count','feature_count'));
    }


    public function manageUserPage()
    {
        $roles = Role::all();
        return view("admin.users.users", compact('roles'));
    }

    public function UserLogin(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        
        if ($user) {

            if ($user->is_deleted == 1) {
                return redirect()->back()->with('nouser', 'No such user find.');
            } else if ($user->status != 1) {
                return redirect()->back()->with('deactive', 'Contact admin for account activation');
            } else {

                $credentials = $request->only('email', 'password');
                if (Auth::attempt($credentials)) {

                    $user_role =  Role::where('id',$user->role_id)->first();

                    $role_features = DB::table('role_has_permissions')
                        ->join('feature', 'role_has_permissions.feature_id', '=', 'feature.id')
                        ->where('feature.parent_id', '=', 0)
                        ->where("is_active", "=", 1)
                        ->where('role_has_permissions.role_id', Auth::user()->role_id)->get();

                    foreach ($role_features as $feature) {
                        $sub_menus = DB::table("feature")->where('parent_id', '=', $feature->id)->where("is_active", "=", 1)->orderBy("sequence")->get();
                        $sub_menu = array();
                        foreach ($sub_menus as $sub) {
                            $ft_prmt = DB::table('role_has_permissions')
                                ->where('role_has_permissions.feature_id', $sub->id)
                                ->where('role_has_permissions.role_id', Auth::user()->role_id)->first();
                            if ($ft_prmt) {
                                array_push($sub_menu, $sub);
                            }
                        }
                        $feature->sub_menu = $sub_menu;
                    }
                    Session::put('menus', $role_features->sortBy('sequence'));

                    $setting = Settings::where('created_by', Auth::user()->id)->first();
                    if($setting) {
                        Session::put('logo', $setting->dashboard_logo);
                    }                    

                    $usr_ip = User::where('id', Auth::user()->id)->first();
                    $usr_ip->login_ip = \Request::ip();
                    $usr_ip->save();

                    if($user_role->name == 'Admin') {
                        return redirect()->intended('/dashboard');
                    }else{
                        if($user->login_ip != \Request::ip()) {
                            return redirect()->back()->with('deactive', 'Contact admin for account activation');
                        }else{
                            return redirect()->intended('/dashboard');
                        }
                    }

                    
                } else {
                    return redirect()->back()->with('deactive', 'Password not matched');
                }
            }
        } else {
            return redirect()->back()->with('nouser', 'No such user find.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function createUser(Request $request)
    {

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->facebook = $request->facebook;
        $user->linkedin = $request->linkedin;
        $user->instagram = $request->instagram;
        $user->twitter = $request->twitter;
        $user->status = $request->status;
        $user->created_ip = \Request::ip();

        if($request->hasFile('profile_pic')) {
            $image = $request->file('profile_pic');
            $imageName = rand() . '.' . $image->extension();
            $image->move(public_path('users'), $imageName);
            $user->profile_pic = $imageName;
        }

        $user->created_by = Auth::user()->id;
        $user->save();
        return response()->json([
            'message' => 'User Successfully Created',
            'success' => true,
            'status' => 200
        ]);
    }

    public function getAllUsers()
    {
        return User::all();
    }

    public function updateUser(Request $request)
    {

        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->facebook = $request->facebook;
        $user->linkedin = $request->linkedin;
        $user->instagram = $request->instagram;
        $user->twitter = $request->twitter;
        $user->status = $request->status;

        if ($request->hasFile('edit_profile_pic')) {

            $image = $request->file('edit_profile_pic');
            $imageName = rand() . '.' . $image->extension();
            $image->move(public_path('users'), $imageName);

            $user->profile_pic = $imageName;
        }

        $user->created_by = Auth::user()->id;
        $user->save();
        return response()->json([
            'message' => 'User Detail Updated Successfully',
            'success' => true,
            'status' => 200
        ]);
    }

    public function resetUserIP(Request $request) {
        $user = User::findOrFail($request->id);
        $user->login_ip = NULL;
        $user->created_by = Auth::user()->id;
        $user->save();
        return response()->json([
            'message' => 'User Reset Successfully',
            'success' => true,
            'status' => 200
        ]);
    }


}
