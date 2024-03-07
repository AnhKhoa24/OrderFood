<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;

class ScrollController extends Controller
{
    public function index(Request $request)
    {
        $posts = Product::selectRaw(
            'products.product_name,
            products.product_id,
            products.price,
            products.description,
            danhmucs.tendanhmuc,
            IFNULL(MAX(photos.photo_link), "nophoto.jpg") AS photo_link'
        )
        ->leftJoin('photos', 'products.product_id', '=', 'photos.product_id')
        ->join('danhmucs','products.ma_danhmuc','=','danhmucs.ma_danhmuc')
        ->groupBy('products.product_id','products.product_name', 'products.price', 'products.description','danhmucs.tendanhmuc')
        ->paginate(6);
   
        if ($request->ajax()) {
            $view = view('data', compact('posts'))->render();
   
            return response()->json(['html' => $view]);
        }
   
        return view('index', compact('posts'));
    }
}
