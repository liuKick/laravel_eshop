<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
class ApiController extends Controller
{ 
   // @Get Product
   public function getProduct() {
      return $this->responeJson(DB::table('product')->get());
   }

   // @Add Logo
   public function addLogo(Request $request) {
       $file = $request->file('thumbnail');
       $fileName = $this->uploadFile($file);
       
       $Logo = DB::table('logo')->insert([
         'thumbnail'  => $fileName,
         'created_at' => $this->mydate(),
         'updated_at' => $this->mydate()
       ]);

       if($Logo) {
         return [
            'code'    => 200,
            'message' => 'Logo inserted success'
         ];
       }
   }

  //  @User Login
   public function signin(Request $request) {
      return $this->responeLogin($request);
   }

   // @Get News
   public function getNews() {
      return $this->responeJson(DB::table('news')->orderByDesc('id')->limit(8)->get());
   }

   

   
 

}
