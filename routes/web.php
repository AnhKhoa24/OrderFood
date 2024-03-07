<?php

use App\Http\Controllers\DanhmucController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\ScrollController;
use App\Http\Controllers\TestController;
use App\Models\Danhmuc;
use Illuminate\Support\Facades\Route;


///client

Route::get('canhan',[HomeController::class,'thongtinuser'])->middleware('auth');

Route::get('/',[ScrollController::class,'index'])->name('posts.index');

Route::get('/product-list',[ProductController::class,'productList']);

Route::post('/add-to-cart',[SanPhamController::class,'addToCart'])->name('add.cart')->middleware('auth');
Route::post('/del-to-cart',[SanPhamController::class,'deleteCart'])->name('delete.cart')->middleware('auth');

Route::get('/check',[HomeController::class,'check']);

Route::get('/checkout',function(){
    return view('checkout');
})->middleware('auth');
Route::post('/dathang',[SanPhamController::class, 'checkout'])->middleware('auth');

Route::get('/myorder', [SanPhamController::class, 'myorder'])->middleware('auth');
//



// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin',[TestController::class,'index'])->middleware(['auth','admin']);
Route::resource('/admin/sanpham', ProductController::class)->middleware(['auth','admin']);

Route::resource('/admin/danhmuc', DanhmucController::class)->middleware(['auth','admin']);



Route::middleware(['auth','admin'])->group(function(){
    Route::get('admin/donhang',[ProductController::class,'donhang']);
    Route::post('admin/donhang/change',[ProductController::class,'changeStatus'])->name('changeStatus');
    Route::post('admin/donhang/xoadon',[ProductController::class,'xoadon'])->name('xoadon');
    Route::post('admin/donhang/back1step',[ProductController::class,'back1step'])->name('back1step');
    Route::get('admin/donhang/chitietdonhang/{id}',[ProductController::class,'chitietdonhang']);

});

Route::resource('/sanpham', SanPhamController::class);

Route::middleware(['auth','admin'])->group(function(){
    Route::get('admin/sanpham/{id}/delete',[ProductController::class,'delete']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('redirects','App\Http\Controllers\HomeController@index');


Route::get("/layout",function(){
    return view('test');
});

require __DIR__.'/auth.php';
