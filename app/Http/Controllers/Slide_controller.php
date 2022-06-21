<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use Illuminate\Http\Request;

class Slide_controller extends Controller
{
    public function index(){
        $allslide = Slide::all();
        return view('dashboard.spotlight',["slides"=>$allslide]);
    }
    public function addToSlide(Request $request){
        if(!$request->file('slideIMG')){
            return redirect()->route('slide.index')->with('imgerr','chưa thêm ảnh');
        }
        $file = $request->file('slideIMG');
        $filename= date('YmdHi').$file->getClientOriginalName();
        $file-> move(public_path('public/images'), $filename);
        $newSlide = new Slide;
        $newSlide->image = 'public/images/'.$filename;
        $newSlide->save();
        return redirect()->route('slide.index');
    }
    public function delete($id){
        Slide::destroy($id);
        return ['success' =>true];
    }
}
