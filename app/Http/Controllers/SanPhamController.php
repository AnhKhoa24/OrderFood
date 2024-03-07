<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Orderdetail;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Symfony\Component\ErrorHandler\Debug;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SanPhamController extends Controller
{
    public function index(Request $request)
    {



        $sanphams = Product::selectRaw(
            'products.product_name,
            products.price,
            products.description,
            IFNULL(MAX(photos.photo_link), "nophoto.jpg") AS photo_link'
        )
            ->leftJoin('photos', 'products.product_id', '=', 'photos.product_id')
            ->groupBy('products.product_name', 'products.price', 'products.description')
            ->paginate(4);

        // dd($sanphams);
        return view('sanphams.index', [
            'sanphams' => $sanphams
        ]);
    }
    public function addToCart(Request $request)
    {

        // Log::debug($request->all());
        $data = $request->all();

        // Lấy danh sách sản phẩm từ session
        $cartItems = $request->session()->get('cart.items', []);

        $found = false;
        $sl = 1;
        foreach ($cartItems as &$item) {
            if ($item['product_id'] == $data['cart_product_id']) {
                $item['quantity'] += 1;
                $sl = $item['quantity'];
                $found = true;
                break;
            }
        }

        if (!$found) {
            $cartItems[] = [
                'product_id' => $data['cart_product_id'],
                'product_name' => $data['cart_product_name'],
                'quantity' => 1,
                'price' => $data['cart_product_price'],
                'photo' => $data['cart_product_photo'],
            ];
        }

        // Lưu danh sách sản phẩm mới vào session
        $request->session()->put('cart.items', $cartItems);

        $tong = 0;
        foreach($cartItems as &$it)
        {
            $tong = $tong + $it['quantity']*$it['price'];
        }
        

        $data=[
            'count_cart' => count($cartItems),
            'quantity' => $sl,
            'status' => $found,   
            'tongtien' => $tong,
        ];

        return $data;
    }

    public function deleteCart(Request $request)
    {
        $data = $request->product_id;
        // Log::debug($data);

        $giohang = $request->session()->get('cart.items',[]);

        foreach($giohang as $key => $item)
        {
            if($item['product_id']== $data)
            {
                unset($giohang[$key]);
            }
        }

        $request->session()->put('cart.items', $giohang);

        $giohang = $request->session()->get('cart.items',[]);
        $sosp = count($giohang);
        $total = 0;
        foreach($giohang as $item)
        {
            $total+= $item['quantity']*$item['price'];
        }

        $data = [
            'sosp'=>$sosp,
            'tongtien'=>$total
        ];

        return $data;
    }

    public function checkout(Request $request)
    {
        $messages =[
            'name.required' => 'Vui lòng nhập tên',
            'sdt.required' => 'Vui lòng nhập số điện thoại',
            'email.required' => 'Vui lòng nhập email',
            'address.required' => 'Vui lòng nhập địa chỉ',
        ];
        $validator = Validator::make($request->all(), [
            'name'=> 'required',
            'sdt'=> 'required',
            'email'=>'required',
            'address'=>'required',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator) // Truyền lỗi về view để hiển thị
                             ->withInput(); // Truyền dữ liệu đã nhập về view
        }

        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->status = 0;
        $order->recipient_name = $request->name;
        $order->recipient_phone = $request->sdt;
        $order->recipient_address = $request->address;
        $order->save();

        $giohang = $request->session()->get('cart.items',[]);
        foreach($giohang as $item)
        {
            $add = new Orderdetail();
            $add->product_id = $item['product_id'];
            $add->quantity = $item['quantity'];
            $add->price = $item['price'];
            $add->order_id= $order->id;
            $add->save();
        }
        Session::forget('cart.items');
        
        return redirect('/');
    }

    public function myorder()
    {
        $orders = DB::table('orders')
        ->join('users','orders.user_id','=','users.id')
        ->orderBy('order_id','asc')
        ->paginate(6);
    }
}
