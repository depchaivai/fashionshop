<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Address_controller extends Controller
{
    public function store(Request $request){

        if(Auth::check()){
            $newAdr = new Address;
            $newAdr->address = $request->address;
            $newAdr->receiver = $request->receiver;
            $newAdr->phone_number = $request->phone_number;
            $newAdr->user_id = Auth::user()->id;
            $newAdr->save();
            return ["success"=>true];
        }
        return ["error"=>true];
    }
    public function getAllAddress(){
        if (!Auth::check()) {
            return view("login");
        }
        $user = Auth::user();
        $useradr = $user->main_adr;
        $alladr = Address::where("user_id", $user->id)->get();
        
        return view('user.address',["all_address"=>$alladr,"main_adr"=>$useradr]);
    }
    public function pickadr($id){
        if(Auth::check()){
            $us = User::find(Auth::user()->id);
            $us->main_adr = $id;
            $us->save();
            return ["success"=>true];
        }
        return ["error"=>true];
    }
}
