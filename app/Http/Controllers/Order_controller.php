<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Noti;
use App\Models\Order;
use App\Models\Saleproduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Order_controller extends Controller
{
    public function ordernow(Request $request){
        $arr = [];
        $del = [];
        foreach($request->orders as $order){
            $jsonval = json_decode($order);
            array_push($del, $jsonval->id);
            $neworder = array(
                "address_id"=>$request->adr,
                "user_id"=>Auth::user()->id,
                "count"=>$jsonval->count,
                "discounts"=>$jsonval->thiscartproduct->thisproduct->discounts,
                "saleproduct_id"=>$jsonval->thiscartproduct->id
            );
            Order::create($neworder);
        }
        Cart::destroy($del);
        return ["success"=>true];
    }
    public function cancelOrder($id){
        $myOrder = Order::find($id);
        $myOrder->stt = 'cancel';
        $myOrder->save();
        $salep = Saleproduct::find($myOrder->saleproduct_id);
        $salep->count = $salep->count + $myOrder->count;
        $salep->save();
        return ["success"=>true];
    }
    public function reOrder($id){
        $myOrder = Order::find($id);
        $salep = Saleproduct::find($myOrder->saleproduct_id);
        if ($salep->count > $myOrder->count) {
            $myOrder->stt = 'order';
            $myOrder->save();
            $salep->count = $salep->count - $myOrder->count;
            $salep->save();
            return ["success"=>true];
        }
       
        return ["success"=>false];
    }
    public function allOrder(Request $request){
        $OrdQuery = Order::query();
        if ($request->query('type')) {
            $OrdQuery->where('stt', $request->query('type'));
        }else{
            $OrdQuery->where('stt','<>','demiss');
        }
        $ord = $OrdQuery->with(['address','saleproduct:id,size,color,price,product_id','saleproduct.thisproduct:id,name,image'])->paginate(15);
        return view('dashboard.order',["all_order"=>$ord]);
    }
    public function demiss(Request $request,$id){
        $order = Order::find($id);
        $order->stt = 'demiss';
        $order->save();
        $salep = Saleproduct::find($order->saleproduct_id);
        $salep->count = $salep->count + $order->count;
        $salep->save();
        $mess = new Noti;
        $mess->user_id = $order->user_id;
        $mess->type="demiss";
        $mess->message = $request->message;
        $mess->product_name = $order->saleproduct->thisproduct->name;
        $mess->save();
        return ["success"=>true];
    }
    public function updateStt(Request $request,$id){
        $order = Order::find($id);
        $order->stt = $request->stt;
        $order->save();
        return ["success"=>true];
    }
}
