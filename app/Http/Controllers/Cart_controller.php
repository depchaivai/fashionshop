<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Cart_controller extends Controller
{
    public function add(Request $request){
        $newCart = new Cart;
        $newCart->status = 'cart';
        $newCart->count = $request->count;
        $newCart->product_sale = $request->product_sale;
        $newCart->user_id = $request->user_id;
        $newCart->save();
        return ["success"=>true];
    }
    public function mycart(){
        if(!Auth::check()){
            return view('login');
        }
        $uid = Auth::user()->id;
        $allCart = Cart::where('user_id',$uid)->with('thiscartproduct.thisproduct')->get();
     
        return view('cart',["allcart"=>$allCart]);
        // return $deals;
    }
    public function buythis(Request $request){
        if (!$request->spend) {
            return redirect('/gio-hang');
        }
        if(Auth::check()){
            $arr = [];
            $total = 0;
            $adr = Address::find(Auth::user()->mainadr);
            $allAdr = Address::where('user_id',Auth::user()->id)->get();
            foreach ($request->spend as $value) {
                $val = json_decode($value);
                array_push($arr,$val);
                $total+=$val->count*$val->thiscartproduct->price*(100-$val->thiscartproduct->thisproduct->discounts)/100;
            };
          
            return view('deal',["willbuy"=>$arr,"adr"=>$adr,"alladr"=>$allAdr,"total"=>$total]);
        }
        return view('login');
        
    }
    public function delete($id){
        Cart::destroy($id);
        return ['success' =>true];
    }
}
