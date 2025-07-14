<?php

// namespace App\Http\Controllers;
namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AttributeController extends Controller
{
    //
     // @Attribute
     public function AddAttribute() {
        return view('backend.add-attribute');
    }
    public function AddAttributeSubmit(Request $request) {
        $date = date('Y:m:d h:i:s');
        $attr = DB::table('attribute')->insert([
            'type'       => $request->type,
            'value'      => $request->value,
            'created_at' => $date,
            'updated_at' => $date
        ]);
        if($attr) {
            $this->logActivity('Attribute', 'Attribute', 'INSERT', $date);
            return redirect('/admin/add-attribute')->with('message', 'Attribute Created');
        }
    }
    
    public function ListAttribute() {
        $attr = DB::table('attribute')
                ->orderByDesc('id')
                ->get();
        return view('backend.list-attribute',[
            'attr' => $attr
        ]);
    }
    
    public function UpdateAttribute($id) {
            $attr = DB::table('attribute')
                ->where('id', $id)
                ->get();
            return view('backend.update-attribute',[
            'id'   => $id,
            'attr' => $attr
        ]);
    }

    public function UpdateAttributeSubmit(Request $request) {
        $date = date('Y:m:d h:i:s');
        $attr = DB::table('attribute')
            ->where('id', $request->id)
            ->update([
                'type'       => $request->type,
                'value'      => $request->value,
                'updated_at' => $date
            ]);

        if($attr) {
            $this->logActivity('Attribute', 'Attribute', 'UPDATE', $date);
            return redirect('/admin/list-attribute');
        }
    }

    public function DeleteAttributeSubmit(Request $request) {
        $attr = DB::table('attribute')
            ->where('id', $request->remove_id)
            ->delete();
            if($attr) {
                $this->logActivity('Attribute', 'Attribute', 'DELETE', date('Y:m:d h:i:s'));
                return redirect('admin/list-attribute');
            }
    }
    // @End Attribuite

}
