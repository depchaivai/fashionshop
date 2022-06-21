<?php

namespace App\Http\Controllers;

use App\Models\Noti;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Userpage_controller extends Controller
{
    public function allOrders(){
        if (!Auth::check()) {
            return view("login");
        }
        $user = Auth::user();
        if (!$user->enduser) {
            return redirect('/dashboard/don-hang');
        }
        $allorders = Order::where('user_id', Auth::user()->id)->with(['address','saleproduct:id,size,color,price,product_id','saleproduct.thisproduct:id,name,image'])->get();
        $ordering = $allorders->filter(function ($item) {
            return $item['stt'] == "order";
        });
        $waiting = $allorders->filter(function ($item) {
            return $item['stt'] ==  "waiting";
        });
        $sending = $allorders->filter(function ($item) {
            return $item['stt'] ==  "sending";
        });
        $cancel = $allorders->filter(function ($item) {
            return $item['stt'] ==  "cancel";
        });
        $demiss = $allorders->filter(function ($item) {
            return $item['stt'] ==  "demiss";
        });
        // return $allorders;
        return view('user.bills',["ordering"=>$ordering,"waiting"=>$waiting,"sending"=>$sending,"cancel"=>$cancel,"demiss"=>$demiss]);
    }
    public function alldemiss(){
        if (!Auth::check()) {
            return view('login');
        }
        $all_demiss = Order::where('user_id',Auth::user()->id)->where('stt','demiss')->get();
        return view('noti',["all_demiss"=>$all_demiss]);
    }
    public function allNoti(){
        if (!Auth::check()) {
            return view('login');
        }
        $notis = Noti::where('user_id',Auth::user()->id)->get();
        return view('user.noti',["notis"=>$notis]);
    }
}
