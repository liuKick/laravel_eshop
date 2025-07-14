<?php
// Mycode
namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use PharIo\Manifest\Author;
use SebastianBergmann\CodeUnit\FunctionUnit;

class AdminController extends Controller
{
    public function index() {
        return view('backend.master');
    }

    public function AddPost() {
        return view('backend.add-post');
    }
    
    public function ListPost() {
        return view('backend.list-post');
    }

    // @Log Activity
    public function ListLogActivity() {
        $log = DB::table('log_activity')
            ->join('users', 'users.id', '=', 'log_activity.author')
            ->select('users.name', 'log_activity.*')
            ->orderBy('log_activity.id', 'DESC')
            ->get();
        
            return view('backend.list-log', [
                'log' => $log
            ]);
    }

    //@Web logo 
    public function AddLogo() {
        return view('backend.add-logo');
    }
    public function AddLogoSubmit(Request $request) {
        $file      = $request->file('thumbnail');
        $thumbnail = $this->uploadFile($file);
        $date      = date('Y:m:d H:i:s');
        
        $Logo = DB::table('logo')->insert([
                'thumbnail'  => $thumbnail,
                'created_at' => $date, 
                'updated_at' => $date
        ]);

        if($Logo) {
            $this->logActivity('Logo', 'logo', 'Insert', $date);
            return redirect('/admin/add-logo')->with('message', 'Post create success');
        } else {
            return redirect('/admin/add-logo')->with('message', 'Post Create Fail');
        }
    }

    // List logo
    public function ListLogo() {
         $logo = DB::table('logo')
                ->orderByDesc('id')
                ->get();
        return view('backend.list-logo', [  
                'logo' => $logo        
            ]);
    }

    // Update Logo
    public function UpdateLogo($id) {
        $logo = DB::table('logo')->find($id);
        return view('backend.update-logo',[
            'logo' => $logo
        ]);
    }

    public function UpdateLogoSubmit(Request $request) {
       
       if(!empty($thumbnail = $request->thumbnail)) {
            $file      = $request->file('thumbnail');
            $thumbnail = $this->uploadFile($file); 
       } else {
            $thumbnail = $request->old_thumbnail;
       }
        $date = date('Y:m:d h:i:s');
       $logo = DB::table('logo')
                ->where('id', $request->id)
                ->update([
                    'thumbnail'  => $thumbnail,
                    'updated_at' => $date
                ]);
        if($logo) { 
            $this->logActivity('Logo', 'Logo', 'UPDATE', $date);
            return redirect('admin/list-logo');
        }
    }

    //delete logo
    public function DeleteLogoSubmit(Request $request) {
            $logo = DB::table('logo')
                    ->where('id', $request->remove_id)
                    ->delete();
            
            if($logo) { 
                $this->logActivity('Logo', 'logo', 'DELETE', date('Y:m:d h:i:s'));
                return redirect('admin/list-logo');   
            }
    }
    // @End Web logo
    
    // @Category Web
    public function AddCategory() {
        return view('backend.add-category');
    }
    public function AddCategorySubmit(Request $request) {
        $name = $request->category;
        $date = date('Y:m:d h:i:s');
        $slug = $this->GenerateSlug($name);
        $category = DB::table('category')->insert([
                    'name'       => $name,
                    'slug'       => $slug,
                    'author'     => Auth::user()->id,
                    'created_at' => $date,
                    'updated_at' => $date
        ]);

        if($category) {
            $this->logActivity('Category', 'Category', 'INSERT', $date);
            return redirect('admin/add-category')->with('message', 'Post Created');
        }
    }

    public function ListCategory() { 
        $category = DB::table('category')
                    ->orderByDesc('id')
                    ->get();
        return view('backend.list-category', [
            'category' => $category
        ]);
    }

    public function UpdateCategory($id) {
        return view('backend.update-category',[
            'id' => $id
        ]);
    }
    public function UpdateCategorySubmit(Request $request) {
        if(!empty($request->category)) {
            $category = $request->category;
        }else{
            $category = $request->old_category;
        }
        $slug =$this->GenerateSlug($category);
        $cat = DB::table('category')
                    ->where('id', $request->id)
                    ->update([
                        'name' => $category,
                        'slug' => $slug,
                        'updated_at' => date('Y:m:d h:i:s') 
                    ]);
        if($cat) {
            $this->logActivity('Category', 'Category', 'UPDATE', date('Y:m:d h:i:s'));
            return redirect('admin/list-category');
        }
    }

    public function RemoveCategorySubmit(Request $request) {
      
        $cat = DB::table('category')
                ->where('id', $request->remove_id)
                ->delete();
        if($cat) {
            $this->logActivity('Category', 'Category', 'DELETE', date('Y:m:d h:i:s'));
            return redirect('admin/list-category');
        }
    }
    // @End Category

    // // @Attribute
    // public function AddAttribute() {
    //     return view('backend.add-attribute');
    // }
    // public function AddAttributeSubmit(Request $request) {
    //     $date = date('Y:m:d h:i:s');
    //     $attr = DB::table('attribute')->insert([
    //         'type'       => $request->type,
    //         'value'      => $request->value,
    //         'created_at' => $date,
    //         'updated_at' => $date
    //     ]);
    //     if($attr) {
    //         $this->logActivity('Attribute', 'Attribute', 'INSERT', $date);
    //         return redirect('/admin/add-attribute')->with('message', 'Attribute Created');
    //     }
    // }
    
    // public function ListAttribute() {
    //     $attr = DB::table('attribute')
    //             ->orderByDesc('id')
    //             ->get();
    //     return view('backend.list-attribute',[
    //         'attr' => $attr
    //     ]);
    // }
    
    // public function UpdateAttribute($id) {
    //         $attr = DB::table('attribute')
    //             ->where('id', $id)
    //             ->get();
    //         return view('backend.update-attribute',[
    //         'id'   => $id,
    //         'attr' => $attr
    //     ]);
    // }

    // public function UpdateAttributeSubmit(Request $request) {
    //     $date = date('Y:m:d h:i:s');
    //     $attr = DB::table('attribute')
    //         ->where('id', $request->id)
    //         ->update([
    //             'type'       => $request->type,
    //             'value'      => $request->value,
    //             'updated_at' => $date
    //         ]);

    //     if($attr) {
    //         $this->logActivity('Attribute', 'Attribute', 'UPDATE', $date);
    //         return redirect('/admin/list-attribute');
    //     }
    // }

    // public function DeleteAttributeSubmit(Request $request) {
    //     $attr = DB::table('attribute')
    //         ->where('id', $request->remove_id)
    //         ->delete();
    //         if($attr) {
    //             $this->logActivity('Attribute', 'Attribute', 'DELETE', date('Y:m:d h:i:s'));
    //             return redirect('admin/list-attribute');
    //         }
    // }
    // // @End Attribuite

    // @Prodcut
    public function AddProduct() {
        $category = DB::table('category')
                ->orderByDesc('id')
                ->get();
        
        $attrSize = DB::table('attribute')
                ->where('type', 'size')
                ->orderByDesc('id')
                ->get();

        $attrColor = DB::table('attribute')
                ->where('type', 'color')
                ->get();
        return view('backend.add-product',[
            'category'  => $category,
            'attrSize'  => $attrSize,
            'attrColor' => $attrColor
        ]);
    }
    
    public function AddProductSubmit(Request $request) {
        $name           = $request->name;
        $slug           = $this->GenerateSlug($request->name);
        $qty            = $request->qty;
        $regular_price  = $request->regular_price;
        $sale_price     = $request->sale_price != '' ? $request->sale_price : 0;
        $attrSize       = implode(',', $request->size);
        $attrColor      = implode(',', $request->color);
        $category_id    = $request->category;
        $thumbnail      = $this->uploadFile($request->file('thumbnail'));
        $description    = $request->description;
        $viewer         = 0;
        $authorId       = Auth::user()->id;
        $date           = date('Y:m:d h:i:s');

        $product = DB::table('product')->insert([
            'name'             => $name,
            'slug'             => $slug, 
            'quantity'         => $qty,
            'regular_price'    => $regular_price,
            'sale_price'       => $sale_price,
            'thumbnail'        => $thumbnail,
            'category_id'      => $category_id,
            'attribute_color'  => $attrColor,
            'attribute_size'   => $attrSize,
            'author_id'        => $authorId,
            'viewer'           => $viewer,
            'description'      => $description,
            'created_at'       => $date,
            'updated_at'       => $date
        ]);
       
        if($product) {
            $this->logActivity($name, 'Product', 'INSERT', $date);
            return redirect('/admin/add-product')->with('message', 'Product Created');
        }
    }
    public function ListProduct() {
        $product = DB::table('product')
            ->join('category', 'category.id', '=', 'product.category_id')
            ->join('users', 'users.id', '=', 'product.author_id')
            ->select('users.name AS username', 'category.name AS catname', 'product.*')
            ->orderBy('product.id', 'DESC')
            ->get();
            
        return view('backend.list-product', [
            'product' => $product
        ]);
    }
    // @Update Product
    public function UpdateProduct($id) {
        $product = DB::table('product')
                    ->where('id', $id)
                    ->get();
        
        $attrSize = DB::table('attribute') 
                ->where('type', 'size')
                ->orderByDesc('id') 
                ->get();
        
        $attrColor = DB::table('attribute')
                ->where('type', 'color')
                ->orderByDesc('id') 
                ->get();
        
        $category = DB::table('category')
               ->orderByDesc('id') 
               ->get(); 
        
        return view('backend.update-product',[
            'product'   => $product,
            'attrSize'  => $attrSize,
            'attrColor' => $attrColor,
            'category'  => $category 
        ]);
    }
    // @Update Product Submit
    public function UpdateProductSubmit(Request $request) {
        $id            = $request->id;
        $name          = $request->name;
        $slug          = $this->GenerateSlug($request->name);
        $qty           = $request->qty;
        $regular_price = $request->regular_price;
        $sale_price    = $request->sale_price!='' ? $request->sale_price : 0;
        $attrSize      = implode(',', $request->size);
        $attrColor     = implode(',', $request->color);
        $category_id   = $request->category;
        $thumbnail     = $request->thumbnail==''? $request->old_thumbnail: $this->uploadFile($request->file('thumbnail'));
        $description   = $request->description;
        $author        = Auth::user()->id;
        $date          = date('Y:m:d h:i:s');
 
        
        $product = DB::table('product')
            ->where('id', $id) 
            ->update(
            [
                'name'            => $name,
                'slug'            => $slug,
                'quantity'        => $qty,
                'regular_price'   => $regular_price,
                'sale_price'      => $sale_price,
                'attribute_size'  => $attrSize,
                'attribute_color' => $attrColor,
                'thumbnail'       => $thumbnail,
                'category_id'     => $category_id,
                'description'     => $description,
                'author_id'       => $author,
                'updated_at'      => $date
            ]
        );
        
        if($product) {
            $this->logActivity($name, 'Product', 'UPDATE', $date);
            return redirect('admin/list-product');
        }
    }

    // @Remove Product 
    public function RemoveProductSubmit(Request $request) {
        if(DB::table('product')
            ->where('id', $request->remove_id)
            ->delete()) {
                return redirect('admin/list-product');   
        }
    }
}
