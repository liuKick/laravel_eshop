<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Sign In
    public function Signin(){
        return view('/backend.login');
    }
    public function SigninSubmit(Request $request){
        $nameEmail = $request->name_email;
        $password  = $request->password;
        $remember  = $request->remember;
        if(Auth::attempt([
            'name'     => $nameEmail,
            'password' => $password
        ], $remember)){
            return redirect('/admin');
        }
        else if(Auth::attempt([
            'email'    => $nameEmail,
            'password' => $password
        ], $remember)){
            return redirect('/admin');
        }else{
            return redirect('/signin')->with('message','Invalid Credentail');
        }
    }

    // Sign Up
    public function Signup() {
        return view('backend.register');
    }
    public function SignupSubmit(Request $request) {
        $name     = $request->name;
        $email    = $request->email;
        $password = $request->password;
        $file     = $request->file('profile');
        $profile  = $this->uploadFile($file); 
        
        $user = DB::table('users')->insert([
            'name'       => $name,
            'email'      => $email,
            'password'   => Hash::make($password),
            'profile'    => $profile,
            'remember_token' => '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'), 
        ]);

        if($user){
            return redirect('/signup')->with('message', 'Your account register successfully');
        }else{
            return redirect('/signup')->with('message', 'Oopp Error');
        }
    }



    //Logout
    public function SignOut() {
        Auth::logout();
        return redirect('signin');
    }
}
