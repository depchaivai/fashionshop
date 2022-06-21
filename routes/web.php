<?php

use App\Http\Controllers\Address_controller;
use App\Http\Controllers\Cart_controller;
use App\Http\Controllers\Cate_controller;
use App\Http\Controllers\Feedback_controller;
use App\Http\Controllers\Flashsale_controller;
use App\Http\Controllers\Login_controller;
use App\Http\Controllers\Order_controller;
use App\Http\Controllers\Product_controller;
use App\Http\Controllers\Saleproduct_controller;
use App\Http\Controllers\Slide_controller;
use App\Http\Controllers\Thuonghieu_controller;
use App\Http\Controllers\Userpage_controller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/dashboard', function () {
//     return view('dashboard.dashboard');
// });
Route::prefix('/callajax')->group(function () {
    Route::post('/addtocart',[Cart_controller::class,'add']);
    Route::post('/product/feedback/{id}',[Feedback_controller::class,'feedback']);
    Route::put('/delcart/{id}',[Cart_controller::class,'delete']);
    Route::post('/addadd',[Address_controller::class,'store']);
    Route::get('/pickadr/{id}',[Address_controller::class,'pickadr']);
    Route::post('/ordernow',[Order_controller::class,'ordernow']);
    Route::get('/cancelorder/{id}',[Order_controller::class,'cancelOrder']);
    Route::get('/reorder/{id}',[Order_controller::class,'reOrder']);
    Route::get('/productbytext/{text}',[Product_controller::class,'searchByText']);
    Route::post('/getproductnotin/{text}',[Product_controller::class,'getproductnotin']);
});
Route::middleware('checkAdmin')->prefix('dashboard')->group(function () {
    Route::prefix('/callajax')->group(function () {
        
        Route::post('/fs/add',[Flashsale_controller::class,'store']);
        Route::post('/fs/update/{id}',[Flashsale_controller::class,'update']);
        Route::put('/fs/swactive/{id}',[Flashsale_controller::class,'swactive']);
        Route::put('/fs/delete/{id}',[Flashsale_controller::class,'delete']);
        
        Route::get('/spotlight',[Slide_controller::class,'index']);
        Route::post('/addcate',[Cate_controller::class,'store']);
        Route::put('/delcate/{id}',[Cate_controller::class,'delete']);
        Route::put('/updatecate/{id}',[Cate_controller::class,'update']);

        Route::post('/addth',[Thuonghieu_controller::class,'store']);
        Route::put('/delth/{id}',[Thuonghieu_controller::class,'delete']);
        Route::put('/updateth/{id}',[Thuonghieu_controller::class,'update']);

        Route::get('/getthbycate/{cate}',[Thuonghieu_controller::class,'getbycate']);

        
        Route::put('/disableproduct/{id}',[Product_controller::class,'disable']);
        Route::put('/disablesalep/{id}',[Saleproduct_controller::class,'disable']);
        Route::put('/salep/truedel/{id}',[Saleproduct_controller::class,'truedel']);
        Route::put('/product/truedel/{id}',[Product_controller::class,'truedel']);
        Route::put('/product/discounts/{id}',[Product_controller::class,'discounts']);
        Route::get('/productbytext/{text}',[Product_controller::class,'getProductByText']);
        Route::post('/addtocart',[Cart_controller::class,'add']);

        Route::post('/demiss/{id}',[Order_controller::class,'demiss']);
        Route::put('/updatestt/{id}',[Order_controller::class,'updateStt']);

        Route::put('/slide/del/{id}',[Slide_controller::class,'delete']);
        Route::put('/delimg/{id}',[Product_controller::class,'deleteDetailImg']);

    });
    Route::get('/flash-sales',[Flashsale_controller::class,'index'])->name('fs_index');
    Route::get('/flash-sales/add',function(){
        return view('dashboard.addflashsale');
    });
    Route::get('/flash-sales/edit/{id}',[Flashsale_controller::class,'edit'])->name('fs_edit');

    Route::get('/spotlight',[Slide_controller::class,'index'])->name('slide.index');
    Route::post('/spotlight/addslide',[Slide_controller::class,'addToSlide'])->name('slide.add');
    Route::get('/don-hang',[Order_controller::class,'allOrder']);
    Route::post('/product/addproductinterface',[Product_controller::class,'store_product_interface'])->name('product.interface');
    Route::put('/product/editproductinterface/{id}',[Product_controller::class,'edit_product_interface'])->name('product.edit');
    Route::get('/product/addnew', [Product_controller::class,'addnewindex'])->name('product.add');
    Route::get('/danh-muc', [Cate_controller::class,'getView']);
    // Route::post('/danh-muc',[Cate_controller::class,'store']);
    Route::get('/thuong-hieu',[Thuonghieu_controller::class,'index']);
    Route::get('/san-pham',[Product_controller::class,'index'])->name('product.index');
    Route::get('/mau-ngung-ban',[Product_controller::class,'disabledproduct']);
    Route::get('/hang-ngung-ban',[Saleproduct_controller::class,'disabledproduct']);
    Route::get('/san-pham/edit/{id}',[Product_controller::class,'editview']);
    Route::get('/dang-ban',[Saleproduct_controller::class,'index'])->name('saleproduct.index');
    Route::get('/dang-ban/them',[Saleproduct_controller::class,'addview']);
    Route::post('/dang-ban/addnew',[Saleproduct_controller::class,'store'])->name('saleproduct.store');
    Route::get('/dang-ban/edit/{id}',[Saleproduct_controller::class,'editview']);
    Route::put('/dang-ban/update/{id}',[Saleproduct_controller::class,'update'])->name('saleproduct.update');
    Route::get('/', function () {
        return view('dashboard.dashboard');
    });
});
Route::get('/gio-hang', [Cart_controller::class,'mycart']);
Route::get('/xac-nhan', function(){
    return view('buysuccess');
});
Route::get('/tai-khoan',[Userpage_controller::class,'allOrders']);
Route::get('/tai-khoan/thong-bao',[Userpage_controller::class,'allNoti']);
Route::get('/tai-khoan/dia-chi',[Address_controller::class,'getAllAddress']);
Route::post('/mua-ngay', [Cart_controller::class,'buythis'])->name('buynow');
Route::get('/mua-ngay', function(){
    return redirect('/gio-hang');
});
Route::get('/san-pham/{slug}',[Product_controller::class,'catePage']);
Route::get('/dang-nhap', [Login_controller::class,'index']);
Route::get('/logout',[Login_controller::class,'logout']);
Route::get('/dang-ky', function () {
    return view('register');
});
Route::get('/chi-tiet/{id}',[Product_controller::class,'detail']);
Route::post('/login', [Login_controller::class,'authenticate'])->name('login');
Route::post('/register', [Login_controller::class,'register'])->name('register');
Route::get('/', [Product_controller::class,'getHomepage']);

