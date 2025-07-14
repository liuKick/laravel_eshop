<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\View\ViewServiceProvider;

class newsController extends Controller
{
    // @Add news
    public function addNews() {
        // return 123;
        return view('backend.add-news');
    }
    // @Add news submit
    public function addNewsSubmit(Request $request) {
        if(DB::table('news')->insert([
              'thumbnail'    => $this->uploadFile($request->file('thumbnail')),
              'title'        => $request->title,
              'description'  => $request->description,
              'author'       => Auth::user()->id,
              'viewer'       => 0,
              'created_at'   => $this->mydate(),
              'updated_at'   => $this->mydate()
        ])) {
            $this->logActivity('News', 'News', 'Insert', $this->mydate());
            return redirect('/admin/add-news')->with('message', 'news created success');
        }
        return redirect('/admin/add-news')->with('message', 'Have something when wrong'); 
    }
     

    
    // @Add Api
    // @Add news from postman
   public function apiAddNews(Request $request) {
    if(DB::table('news')->insert([
       'title'        => $request->input('title'),
       'author'       => $request->input('author'),
       'description'  => $request->input('description'),
       'thumbnail'    => $this->uploadFile($request->file('thumbnail')),
       'created_at'   => $this->mydate(),
       'updated_at'   => $this->mydate(),
       'viewer'       => 0
    ])) return 'news created success';
    return 'false create news';
 }
    // @list news 
    public function listNews() {
        return view('backend.list-news', [
                'news' => !(empty($news = DB::table('news')
                ->where('author', Auth::user()->id)
                ->join('users', 'users.id', '=', 'ns.author')
                ->select('users.name As username', 'news.*')
                ->orderBy('news.id','DESC')
                ->get()))? $news: 500
        ]);
    }

    public function updateNews($id) {
        return view('backend.update-news', [
            'news' => DB::table('news')->where('id', $id)->get()
        ]);
    }
    
    
      // @Update news Submit
      public function updateNewsSubmit(Request $request) {
         if(DB::table('news')->where('id', $request->id)->update([
          'title'       => $request->title,
          'thumbnail'   => $request->thumbnail==''? $request->old_thumbnail : $this->uploadFile($request->file('thumbnail')),
          'description' => $request->description
         ])) $this->logActivity('News', 'News' ,'UPDATE', $this->mydate()); return redirect('/admin/list-news') ;
      }
    
      // @Remove News
      public function removeNewsSubmit(Request $request) {
        if(DB::table('news')->where('id', $request->remove_id)->delete()) return redirect('/admin/list-news');
      }


      // @New Detail
      public function newsDetail($id) {
          $news =  DB::table('news')->where('id', $id)->get();
          DB::table('news')
                ->where('id', $id)
                ->update(['viewer'=> $news[0]->viewer+1]);
          return view('frontend.news-detail', [
            'news' => $news
          ]);
      }

      public function getNews() {
        return view('frontend.news', [
            'news' => DB::table('news')
                      ->orderBy('id', 'DESC')
                      ->limit(8)
                      ->get()
        ]);
      }
      
      public function apiUpdateNews(Request $request) {
        if( DB::table('news')
                ->where('id', $request->input('id'))
                ->update(
                  [
                    'title'         => $request->input('title'),
                    'description'   => $request->input('description'),
                    'thumbnail'     => !empty($file = $request->file('thumbnail'))? $this->uploadFile($file) : DB::table('news')->where('id', $request->id)->get()[0]->thumbnail,
                    'updated_at'    => $this->mydate()
                  ]
            )) {
              return [
                'code' => 200,
              ];
         }
      }

      // Delete news
      public function removeNews(Request $request) {
        if(DB::table('news')->where('id', $request->input('id'))->delete()) return ['code'=> 200];
        return ['code' => 500, 'data'=> 'false'];
      }

      
}
