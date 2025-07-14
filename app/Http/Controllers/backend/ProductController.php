<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function AddProduct() {
        $Category = DB::table('category')
                        ->orderBy('id', 'DESC')
                        ->get();
        return view('backend.add-product', ['Category'=>$Category]);
    }

    public function AddProductSubmit(Request $request) {

        $name           = $request->name;
        $qty            = $request->qty;
        $regular_price  = $request->regular_price;
        $sale_price     = $request->sale_price;
        $category       = $request->category;
        $size           = implode(', ', $request->size);
        $color          = implode(', ', $request->color);
        $author         = Auth::user()->id;
        $description    = $request->description;
        $file           = $request->file('thumbnail');
        $thumbnail      = $this->uploadFile($file);

        $Product = DB::table('product')->insert([
            'name'          => $name,
            'qty'           => $qty,
            'regular_price' => $regular_price,
            'sale_price'    => $sale_price,
            'category'      => $category,
            'color'         => $color,
            'size'          => $size,
            'author'        => $author,
            'viewer'        => 0,
            'thumbnail'     => $thumbnail,
            'description'   => $description,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s')
        ]);

        if($Product) {
            $this->logActivity('Product', $request->name, 'Add', date('Y:m:d h:i:s'));
            return redirect('admin/add-product');
        }

    }
}
