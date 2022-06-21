<?php

namespace App\Http\Controllers;

use App\Models\Cate;
use App\Models\Product;
use App\Models\Thuonghieu;
use Illuminate\Http\Request;

class Thuonghieu_controller extends Controller
{
    public function index(){
        $all_cate = Cate::where('parent',0)->get();
        $all_th = Thuonghieu::whereHas('thiscate')->with('thiscate')->get();
        return view('dashboard.trademark',["all_cate"=>$all_cate],["all_th"=>$all_th]);
    }
    public function store(Request $request){
        $newTH = new Thuonghieu;
        $newTH->name = $request->name;
        $newTH->cate = $request->cate;
        $newTH->save();
        return ["response"=>["success"=>true]];
    }
    public function update(Request $request,$id){
        $th = Thuonghieu::find($id);
        $th->name = $request->name;
        $th->cate = $request->cate;
        $th->save();
        return ["response"=>["success"=>true]];
    }
    public function delete($id){
        $th_count = Product::where('th',$id)->count();
        if ($th_count > 0) {
            return ["success"=>false];
        }
        Thuonghieu::destroy($id);
        return ["success"=>true];
    }
    public function getbycate($cate){
        $th = Thuonghieu::where('cate',$cate)->get();
        return $th;
    }
}
