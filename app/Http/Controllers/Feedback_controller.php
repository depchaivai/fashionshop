<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Feedback_controller extends Controller
{
   public function feedback(Request $request, $id){
     if (!Auth::check()) {
         return ["success"=>false];
     }
     $newFB = new Feedback;
     $newFB->user_id = Auth::user()->id;
     $newFB->product_id = $id;
     $newFB->feedback = $request->feedback;
     $newFB->save();
     return ["success"=>true];
   }
}
