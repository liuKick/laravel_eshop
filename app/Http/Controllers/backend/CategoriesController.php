<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function AddCategory() {
        return view('backend.add-category');
    }

    public function AddCategorySubmit(Request $request) {
        $Category = DB::table('category')->insert([
            'name'        => $request->name,
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s')
        ]);
        if($Category) {
            $postType    = 'Category';
            $productName = $request->name;
            $status      = 'Add';
            $this->logActivity($postType, $productName, $status, $this->mydate());
            return redirect('admin/add-category');
        }
    }

    public function ListCategory() {
        $Category = DB::table('category')
                        ->orderBy('id', 'DESC')
                        ->get();
        return view('backend.list-category', ['Category' => $Category]);
    }
}
