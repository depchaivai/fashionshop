<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Cate;
use App\Models\Order;
use App\Models\Saleproduct;
use App\Models\Thuonghieu;
use Illuminate\Http\Request;

class Saleproduct_controller extends Controller
{
    public function index(Request $request){
        $spquery = Saleproduct::query();
        if ($request->query('cate')) {
            $spquery->whereHas('thisproduct',function($q) use ($request){
                $q->where('cate',$request->query('cate'));
            });
            $all_th = Thuonghieu::where('cate',$request->query('cate'))->get();
        }else{
            $all_th = Thuonghieu::all();
        }
        if ($request->query('th')) {
            $spquery->whereHas('thisproduct',function($q) use ($request){
                $q->where('th',$request->query('th'));
            });
        }
        if ($request->query('from') && $request->query('to')) {
            if ($request->query('from') < $request->query('to')) {
                $spquery->where('price','>=',$request->query('from'))->where('price','<=',$request->query('to'));
            }else{
                $spquery->where('price','>=',$request->query('to'));
            }
        }
        if ($request->query('find')) {
            $spquery->whereHas('thisproduct',function($q) use ($request){
                $q->where('name','LIKE','%'.$request->query('find').'%');
            });
        }
        $all_cate = Cate::where('parent',0)->get();
        $allsale = $spquery->where('disable',false)->with('thisproduct.thiscate','thisproduct.thisth')->paginate(10);
        return view('dashboard.saleproduct',["allsalep"=>$allsale,"allcate"=>$all_cate,"allth"=>$all_th]);
    }
    public function addview(){
        return view('dashboard.addsaleproduct');
    }
    public function store(Request $request){
        $newsalep = new Saleproduct;
        $newsalep->product_id = $request->product_id;
        $newsalep->size = $request->size;
        $newsalep->color = $request->color;
        $newsalep->price = $request->price;
        $newsalep->count = $request->count;
        $newsalep->save();
        return redirect()->route('saleproduct.index');
    }
    public function editview($id){
        $salep = Saleproduct::with('thisproduct.thiscate','thisproduct.thisth')->find($id);
        return view('dashboard.editsaleproduct',["thisp"=>$salep]);
    }
    public function update(Request $request,$id){
        $newsalep = Saleproduct::find($id);
        $newsalep->size = $request->size;
        $newsalep->color = $request->color;
        $newsalep->price = $request->price;
        $newsalep->count = $request->count;
        $newsalep->save();
        return redirect()->route('saleproduct.index');
    }
    public function disable($id){
        $sproduct = Saleproduct::find($id);
        $sproduct->disable=!$sproduct->disable;
        $sproduct->save();
        return ["success"=>true];
    }
    public function disabledproduct(){
        $allsalep = Saleproduct::where('disable',true)->with(['thisproduct.thiscate','thisproduct.thisth'])->paginate(10);
        return view('dashboard.salepdisabled',["allsalep"=>$allsalep]);
    }
    public function getProductByText($text){
        $mysearch = Saleproduct::where('disable',false)->with(['thiscate','thisth','thisp'=>function($q) use ($text) {
            $q->where('name','LIKE',"%{$text}%");
        }])->take(10)->get();
        return $mysearch;
    }
    public function truedel($id){
        $orderCount = Order::where('saleproduct_id',$id)->count();
        $cart = Cart::where('product_sale',$id)->get();
        if ($orderCount > 0) {
            return ["success"=>false];
        }
        if (count($cart) > 0) {
            Cart::whereIn('id',$cart->pluck('id'))->delete();
        }
        Saleproduct::destroy($id);
        return ["success"=>true];
    }
}
