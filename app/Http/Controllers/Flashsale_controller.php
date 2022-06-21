<?php

namespace App\Http\Controllers;

use App\Models\Flashsale;
use App\Models\Product;
use App\Models\Saleitem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Flashsale_controller extends Controller
{
    public function index(){
        $allFS = Flashsale::all();
        return view('dashboard.flashsale',["all_fs"=>$allFS]);
    }
    public function store(Request $request){
        $now = Carbon::now();
        $start = new Carbon($request->start);
        $end = new Carbon($request->end);
        // return $request;
        if ($now > $start->startOfDay()) {
            return ["success"=>false];
        }
        $newFS = new Flashsale;
        $newFS->title = $request->title;
        $newFS->from = $start;
        $newFS->expire_day = $end->endOfDay();
        if ($request->file('banner')) {
            $file = $request->file('banner');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('images'), $filename);
            $newFS->banner ='images/'.$filename;
        }
        
        $newFS->save();
        $pdata = json_decode($request->pdata);
        if (count($pdata) > 0) {
            foreach ($pdata as $p){
                    $newsi = new Saleitem;
                    $newsi->product_id = $p->product_id;
                    $newsi->discount = $p->discount;
                    $newsi->sale_id = $newFS->id;
                    $newsi->save();
            }
        }
        return ["success"=>true];
    }
    public function swactive($id){
        $curr = Flashsale::find($id);
        $now = Carbon::now();
        $expire_time = new Carbon($curr->expire_day);
        $start_day = new Carbon($curr->from);
        $items = Saleitem::where('sale_id',$id)->get();
        if (!$curr->active) {
            $orderFScount = Flashsale::where('from','>=',$start_day)->where('from','<=',$expire_time)->orWhere(function($q) use($start_day,$expire_time){
                $q->where('expire_day','>=',$start_day)->where('expire_day','<=',$expire_time);
            })->count();
            if ($orderFScount > 0) {
                return ["success"=>false,"message"=>"bị trùng ngày"];
            }
            if ($now > $expire_time) {
                return ["success"=>false,"message"=>"đã hết thời gian sale, không thể kích hoạt"];
            }
            
            if (count($items) <= 0) {
                return ["success"=>false,"message"=>"chưa có sản phẩm giảm giá nào, vui lòng thêm sản phẩm giảm giá mới có thể kích hoạt"];
            }
            if ($now >= $start_day) {
                foreach ($items as $item) {
                    Product::where('id',$item->product_id)->update(['discounts'=>$item->discount]);
                }
            }
            $curr->active = true;
            $curr->save();
            return ["success"=>true];
        }
        if (count($items) > 0) {
            foreach ($items as $item) {
                Product::where('id',$item->product_id)->update(['discounts'=>0]);
            }
        }
        $curr->active = false;
        $curr->save();
        return ["success"=>true];
    }
    public function edit($id){
        $fs = Flashsale::find($id);
        $saleitem = Saleitem::where('sale_id',$id)->with('product')->get();
        // $all_product = Product::whereIn('id',$saleitem)->whereHas('allsalling')->get();
        // return $all_product;
        return view("dashboard.editflashsale",["fs"=>$fs,"saleitems"=>$saleitem]);
    }
    public function delete($id){
        Flashsale::destroy($id);
        Saleitem::where('sale_id',$id)->delete();
        return ["success"=>true];
    }
    public function update(Request $request,$id){
        $now = Carbon::now();
        $start = new Carbon($request->start);
        $end = new Carbon($request->end);
        // return $request;
        if ($now > $start) {
            return ["success"=>false];
        }
        $newFS = Flashsale::find($id);
        $newFS->title = $request->title;
        $newFS->from = $start;
        $newFS->expire_day = $end;
        if ($request->file('banner')) {
            $file = $request->file('banner');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('images'), $filename);
            $newFS->banner ='images/'.$filename;
        }
        
        $newFS->save();
        $pdata = json_decode($request->pdata);
        Saleitem::where('sale_id',$id)->delete();
        if (count($pdata) > 0) {
            foreach ($pdata as $p){
                    $newsi = new Saleitem;
                    $newsi->product_id = $p->product_id;
                    $newsi->discount = $p->discount;
                    $newsi->sale_id = $newFS->id;
                    $newsi->save();
            }
        }
        return ["success"=>true];
    }
}
