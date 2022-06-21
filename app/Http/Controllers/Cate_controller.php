<?php

namespace App\Http\Controllers;

use App\Models\Cate;
use App\Models\Product;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;

class Cate_controller extends Controller
{
    public function getView(){
        $allCate = Cate::all();
        return view('dashboard.cate',['all_cate'=>$allCate]);
    }
    public function store(Request $request){
        $newCate = new Cate;
        $newCate->name = $request->name;
        $newCate->parent = $request->parent;
        $newCate->slug=vn_to_str($request->name);
        $newCate->save();
        return ["success"=>true];
    }
    public function delete($id){
        $count_product = Product::where('cate',$id)->orWhere('subcate',$id)->count();
        if ($count_product > 0) {
            return ["success"=>false];
        }
        Cate::destroy($id);
        return ["success"=>true];
    }
    public function update(Request $request,$id){
        $cate = Cate::find($id);
        $cate->name = $request->name;
        $cate->slug = vn_to_str($request->name);
        $cate->parent = $request->parent;
        $cate->save();
        return ["response"=>["success"=>true]];
    }

}
