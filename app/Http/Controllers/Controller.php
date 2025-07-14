<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //Move File Upload
    public function uploadFile($File) {
        $fileName  = rand(1,999).'-'.$File->getClientOriginalName();
        $path      = 'uploads';
        $File->move($path, $fileName);
        return $fileName;
    }

    //Log Activities
    public function logActivity($title, $type, $action, $date) {
        DB::table('log_activity')->insert([
            'author'     => Auth::user()->id,
            'title'      => $title,
            'type'       => $type,
            'action'     => $action,
            'created_at' => $date,
            'updated_at' => $date
        ]);
    }

    // @Generate Slug
    public function GenerateSlug($text) {
        return strtolower(preg_replace('/[^A-Za-z0-9]+/', '-', $text));
    }

    // @Respone Api
    public function responeJson($status) {
        if($status) {
            return [
                'code' => 200,
                'data' => $status,
            ];
           }else {
            return [
                'code' => 500,
                'data' => '123'
            ];
        }
    } 
    
    // @Get date
    public function mydate() {
        return date('Y:m:d h-i-s');
    }
    

    public function responeLogin($request) {
        if(Auth::attempt([
            'email'    => $request->input('email'),
            'password' => $request->input('password')
          ])) {
            $user = Auth::user(); 
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['id']    = $user->id;
            $success['name']   = $user->name; 
   
            return $success;
          }else if(Auth::attempt([
           'name'     => $request->input('email'),
           'password' => $request->input('password')
           
           ])){ 
             $user = Auth::user(); 
             $success['token']  = $user->createToken('MyApp')->plainTextToken;
             $success['id']     = $user->id;
             $success['name']   = $user->name;

             return $success;
          }
          return 'false';
    }

    
}
