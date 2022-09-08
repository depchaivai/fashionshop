<?php

namespace App\Http\Controllers;

use App\Models\Cate;
use App\Models\DesImg;
use App\Models\DetailImg;
use App\Models\Feedback;
use App\Models\Flashsale;
use App\Models\Product;
use App\Models\Slide;
use App\Models\Thuonghieu;
use Illuminate\Http\Request;

class Product_controller extends Controller
{
    public function index(Request $request){

        $pquery = Product::query();
        if ($request->query('cate')) {
            $pquery->where('cate',$request->query('cate'));
            $all_th = Thuonghieu::where('cate',$request->query('cate'))->get();
        }else{
            $all_th = Thuonghieu::all();
        }
        if ($dc = $request->query('isdiscount')) {
            if($dc==1){
                $pquery =  $pquery->where('discounts','>',0);
            }
            
        }
        if ($request->query('th')) {
            $pquery->where('th',$request->query('th'));
        }
        if ($request->query('find')) {
            $pquery->where('name','LIKE','%'.$request->query('find').'%');
        }
        $all_cate = Cate::where('parent',0)->get();
        $allp = $pquery->where('disable',false)->with(['thiscate','thisth'])->paginate(10);
        
        return view('dashboard.product',["allp"=>$allp,"allcate"=>$all_cate,"allth"=>$all_th]);
    }
    public function disabledproduct(){
        $allp = Product::where('disable',true)->with(['thiscate','thisth'])->paginate(10);
        return view('dashboard.disabled',["allp"=>$allp]);
    }
    public function editview($id){
        $myp = Product::find($id);
        $allth = Thuonghieu::where('cate',$myp->cate)->get();
        $all_cate = Cate::all();
        return view('dashboard.editnewproduct',["all_cate"=>$all_cate,"allth"=>$allth,"thisp"=>$myp]);
    }
    public function addnewindex(){
        $all_cate = Cate::all();
        return view('dashboard.addnewproduct',["all_cate"=>$all_cate]);
    }
    public function store_product_interface(Request $request){
        if(!$request->file('productIMG')){
            return redirect()->route('product.add')->with('imgerr','chưa thêm ảnh');
        }
        $extensions=array( 'jpg', 'png', 'gif' );
        if(!in_array($request->file('productIMG')->extension(),$extensions)){
            return redirect()->route('product.add')->with('imgerr','chưa thêm ảnh');
        }
        $file = $request->file('productIMG');
        $filename= date('YmdHi').$file->getClientOriginalName();
        $file-> move(public_path('images'), $filename);
        $newPI = new Product;
        $newPI->cate = $request->cate;
        $newPI->name = $request->name;
        $newPI->des = $request->des;
        $newPI->th = $request->th;
        $newPI->image = $filename;
        if ($request->subcate) {
            $newPI->subcate = $request->subcate;
        }
        $newPI->save();
        
        if ($detailimg = $request->file('detailimg')) {
            
            foreach ($detailimg as $img){
                if (in_array($img->extension(),$extensions)) {
                    $filename= date('YmdHi').$img->getClientOriginalName();
                    $img-> move(public_path('images'), $filename);
                    $newimg = new DetailImg;
                    $newimg->image = '/images'.'/'.$filename;
                    $newimg->des = false;
                    $newimg->product_id = $newPI->id;
                    $newimg->save();
                }
               

            }
        }
        if ($desimg=$request->file('desimg')) {
            foreach ($desimg as $img){
                if (in_array($img->extension(),$extensions)) {
                    $filename= date('YmdHi').$img->getClientOriginalName();
                    $img-> move(public_path('images'), $filename);
                    $newimg = new DetailImg;
                    $newimg->image = '/images'.'/'.$filename;
                    $newimg->des = true;
                    $newimg->product_id = $newPI->id;
                    $newimg->save();
                }
               

            }
        }
        return redirect()->route('product.index');
    }
    public function edit_product_interface(Request $request,$id){

        
        $editp = Product::find($id);
        $extensions=array( 'jpg', 'png', 'gif' );
        
        if($request->file('productIMG')){
            if(in_array($request->file('productIMG')->extension(),$extensions)){
                $file = $request->file('productIMG');
                $filename= date('YmdHi').$file->getClientOriginalName();
                $file-> move(public_path('images'), $filename);
                $editp->image = $filename;
            }
            
        }
        
        $editp->cate = $request->cate;
        $editp->name = $request->name;
        $editp->des = $request->des;
        $editp->th = $request->th;
        if ($request->subcate) {
            $editp->subcate = $request->subcate;

        }
        $editp->save();
        if ($detailimg = $request->file('detailimg')) {
            
            foreach ($detailimg as $img){
                if (in_array($img->extension(),$extensions)) {
                    $filename= date('YmdHi').$img->getClientOriginalName();
                    $img-> move(public_path('images'), $filename);
                    $newimg = new DetailImg;
                    $newimg->image = '/images'.'/'.$filename;
                    $newimg->des = false;
                    $newimg->product_id = $id;
                    $newimg->save();
                }
               

            }
        }
        if ($desimg=$request->file('desimg')) {
            foreach ($desimg as $img){
                if (in_array($img->extension(),$extensions)) {
                    $filename= date('YmdHi').$img->getClientOriginalName();
                    $img-> move(public_path('images'), $filename);
                    $newimg = new DetailImg;
                    $newimg->image = '/images'.'/'.$filename;
                    $newimg->des = true;
                    $newimg->product_id = $id;
                    $newimg->save();
                }
               

            }
        }
        return redirect()->route('product.index');
    }
    public function getProductByText($text){
        $mysearch = Product::where('name','LIKE',"%{$text}%")->where('disable',false)->with('thiscate','thisth')->take(10)->get();
        return $mysearch;
    }
    public function searchByText($text){
        $mysearch = Product::where('name','LIKE',"%{$text}%")->where('disable',false)->whereHas('allsalling',function($q){
            $q->where('disable',false);
        })->with('thiscate','thisth')->take(10)->get();
        return $mysearch;
    }
    public function getproductnotin(Request $request,$text){
        $pids = json_decode($request->pids);
        $mysearch = Product::where('name','LIKE',"%{$text}%")->where('disable',false)->whereNotIn('id',$pids)->whereHas('allsalling',function($q){
            $q->where('disable',false);
        })->with('thiscate','thisth')->take(10)->get();
        return $mysearch;
    }
    public function getHomepage(){
        $allslide = Slide::all();
        $allmenu=Cate::all();
        $newps = Product::whereHas('allsalling',function($q){
            $q->where('disable',false);
        })->with('allsalling','flashsale')->orderBy('created_at','DESC')->take(10)->get()->map(function($newps){
            $newps->setRelation('allsalling', $newps->allsalling->take(1));
            return $newps;
        });
        $discountsp = Product::whereHas('allsalling',function($q){
            $q->where('disable',false);
        })->where('discounts','>',0)->with('allsalling')->orderBy('updated_at','DESC')->take(5)->get()->map(function($newps){
            $newps->setRelation('allsalling', $newps->allsalling->take(1));
            return $newps;
        });
        $allFS = Flashsale::where('active',true)->whereHas('allsale')->with(['allsale.product'=>function($q){
            $q->whereHas('allsalling')->with('thiscate','thisth','allsalling');
        }])->get();
    // return $allFS;
        return view('welcome',[ "newps" => $newps,"allmenu"=>$allmenu,"slides"=>$allslide,"discountsp"=>$discountsp,"flashsales"=>$allFS]);
        // return $menu;
    }
    public function detail($id){
        // $user = Auth::user();
        $thisp = Product::with('allsalling','thiscate','thisth','detailimg')->find($id);
        $listSize = $thisp->allsalling->unique('size')->toArray();
        $onlySize = array_map(function($item){
            return $item['size'];
        },$listSize);
        $all_feedback = Feedback::where('product_id',$id)->with('thisuser')->get();
        return view('detail',["thisp"=>$thisp,"listSize"=>$onlySize,"feedbacks"=>$all_feedback]);
        // return $all_feedback;
    }
    public function disable($id){
        $product = Product::find($id);
        $product->disable = !$product->disable;
        $product->save();
        return ["success"=>true];
    }
    public function catePage(Request $request, $slug){
        $cate = Cate::where('slug',$slug)->get();
        if (count($cate)<=0) {
           return abort(404);
        }
        $all_subcate = Cate::where('parent',$cate[0]->id)->get();
        $all_th = Thuonghieu::where('cate',$cate[0]->id)->get();
        $pquery = Product::query();
        
        if ($request->query('subcate')) {
            $pquery = $pquery->whereIn('subcate',$request->query('subcate'));
        }else {
            $pquery = $pquery->where('cate',$cate[0]->id);
        }
        if ($request->query('th')) {
            $pquery = $pquery->whereIn('th',$request->query('th'));
        }
        if ($request->query('priceRange')) {
            $value = $request->query('priceRange');
            $pquery = $pquery->whereHas('allsalling', function($q) use($value) {
                // Query the name field in status table
                $q->where('disable',false)->where('price', '<=', $value); // '=' is optional
         });
        }
        $all_product = $pquery->has('allsalling')->with('allsalling')->paginate(25);
        $all_product->getCollection()->map(function($newps){
            $newps->setRelation('allsalling', $newps->allsalling->take(1));
            return $newps;
        });
        // return $all_product; 
        // return $all_product; 
        return view('cate',["allp"=>$all_product,"subcates"=>$all_subcate,"allth"=>$all_th,"cate"=>$cate]);
    }
    public function deleteDetailImg($id){
        DetailImg::destroy($id);
        return ["success"=>true];
    }
    public function truedel($id){
        $product = Product::has('allsalling')->find($id);
        if ($product) {
            return ["success"=>false];
        }
        Product::destroy($id);
        return ["success"=>true];
    }
    public function discounts(Request $request, $id){
        $dc = $request->discounts;
        if ($dc > 100 || $dc < 0) {
            return ["success"=>false];
        }
        $product = Product::find($id);
        $product->discounts = $request->discounts;
        $product->save();
        return ["success"=>true];
    }
}
