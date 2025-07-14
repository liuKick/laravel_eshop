<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Psy\Command\WhereamiCommand;

class HomeController extends Controller
{

    public function Home() {
        
          $newProduct = DB::table('product')
            ->orderByDesc('id')
            ->limit(4)
            ->get();
        
        

        
        // $offset = 0;
        // for($i=0; $i < 4; $i++){
        //     $newp = DB::table('product')
        //     ->orderByDesc('id')
        //     ->offset($i)
        //     ->limit(1)
        //     ->get();
        //     if($newp[$i]->sale_price > 0) {
        //        $offset++;
        //     }
        // }
         
        

        // return DB::table('product')
        // ->where('sale_price', '<>', 0)
        // ->offset($offset)
        // ->orderByDesc('id')
        // ->limit(4)
        // ->get();

        return view('frontend.home',
            [
                'newProduct'      =>  $newProduct,
                'promoProduct'    =>  DB::table('product')
                                        ->where('sale_price', '<>', 0)
                                        // ->offset($offset)
                                        ->orderByDesc('id')
                                        ->limit(4)
                                        ->get(),
                'popular_product' => DB::table('product')
                                        ->orderByDesc('viewer')
                                        ->limit(4)
                                        ->get()
            ]
        );
    }

    public function Shop(Request $request) {
        
        $limitPerpage = 6;

        if(empty($request->page)) {
            $currentPage =  1;
        } else {
            $currentPage = $request->page;
        }
         
         // @Get current Page
         $offset = ($currentPage - 1) * $limitPerpage;
        // @Page Generation
        $total_product = DB::table('product')
                        ->count();      
        
        // @declare filter type for get page generation of filter product
        $fileterType = '';
        // @Declare Query Product 
        $query = DB::table('product')
                 ->offset($offset)
                 ->limit($limitPerpage);
        
        if(!empty($request->cat)) {
            $catSlug = $request->cat;
            
            $objCat  = DB::table('category')
                       ->where('slug', $catSlug)
                       ->get();
            $fileterType = 'cat='.$catSlug;
            $catId = $objCat[0]->id;
            
            // @Get total of Product post by this category
            $total_product = DB::table('product')
                            ->where('category_id', $catId)
                            ->count();                

            $query->where('category_id', $catId);
            $query->orderbyDesc('id');
        }
        
        //@Sort Prodcut By Price 
        if(!empty($request->price)) {
            // @Get total promotion product for find page generation
            $priceRank  = $request->price;
            if($priceRank=='max') {
                $sortMode = 'DESC';
            }else {
                $sortMode = 'ASC';
            }
            $query->orderBy('regular_price', $sortMode);
        }
        
        // @Filter by Promotion
        if(!empty($request->promotion)){
            $query->where('sale_price', '<>', 0);
            $total_product = DB::table('product')
                            ->where('sale_price', '<>', '0')
                            ->count();
            $fileterType = 'promotion=true';
        }

        // @Category 
        $category = DB::table('category')
                    ->orderByDesc('id')
                    ->get();
                    
        // @Page for Page generation
        $page = ceil($total_product / $limitPerpage);
                    
        // @Execut Query
        $product = $query->get();

        return view('frontend.shop',[
            'page'       => $page,
            'product'    => $product,
            'category'   => $category,
            'filterType' => $fileterType
        ]);
    }
  
    public function Product($slug) {

        // @Get Product Detail
        $product = DB::table('product')
            ->where('slug', $slug)
            ->get();
        
        // @Get CurrentViewer
        $currentViewer = $product[0]->viewer;
        DB::table('product')
            ->where('slug', $slug)
            ->update([
                'viewer' => $currentViewer + 1
            ]);
        
        // @Get Relate Product
        $relatePro = DB::table('product')
            ->where('category_id', $product[0]->category_id)
            ->where('id', '<>', $product[0]->id)
            ->orderByDesc('id')
            ->limit(4)
            ->get();
        
        return view('frontend.product',[
            'product'   => $product,
            'relatePro' => $relatePro
        ]);
    }

    public function News() {
        return view('frontend.news');
    }

    public function Article() {
        return view('frontend.news-detail');
    }

    public function Search(Request $request) {
        return view('frontend.search',[
            'product' => DB::table('product')
                        ->where('name', 'LIKE', '%'.$request->s.'%')
                        ->get(),
            'news'    => DB::table('news')
                        ->where('title', 'LIKE', '%'.$request->s.'%')
                        ->get()
            ]);
    }


}
