<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Photo;
use App\Models\Order;
use App\Models\Orderdetail;
use App\Http\Requests\UpdateProductRequest;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Events\ProductEvent;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\ErrorHandler\Debug;
use Termwind\Components\Raw;

class ProductController extends Controller
{

    public function index(Request $request)
    {

        $tim = '';
        if($request->search) $tim = $request->search;

        $products = DB::table('products')
                    ->join('danhmucs','products.ma_danhmuc','=','danhmucs.ma_danhmuc')
                    ->where('product_name','LIKE','%'.$tim.'%')
                    ->paginate(5);
        return view('admin.products.index', [
            'products' => $products
        ]);
    }


    public function create()
    {
        $danhmucs = DB::select("SELECT * FROM danhmucs");

        return view('admin.products.create', [
            'danhmucs' => $danhmucs
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'price' => 'required',
            'image.*' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:5120',
        ]);

        $product = new Product();
        $product->product_name = $request->product_name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->ma_danhmuc = $request->ma_danhmuc;
        $product->save();

        $search = DB::select("SELECT product_id FROM products WHERE product_name = '$product->product_name'");
        $result = reset($search);
        foreach ($request->image as $value) {
            $imageName = time() . '_' . $value->getClientOriginalName();
            $value->move(public_path('images'), $imageName);
            $imageNams[] = $imageName;
            $photo = new Photo();
            $photo->photo_link = $imageName;
            $photo->product_id = $result->product_id;
            $photo->save();
        }

        $dt = DB::select("SELECT * FROM products JOIN danhmucs ON products.ma_danhmuc = danhmucs.ma_danhmuc WHERE product_id='$result->product_id'");

        $data =
        [
            'handle'=>'created',
            'product_id'=>$dt[0]->product_id,
            'product_name'=>$dt[0]->product_name,
            'price'=>$dt[0]->price,
            'tendanhmuc'=>$dt[0]->tendanhmuc,
        
        ];
        event(new ProductEvent($data));


        return redirect('admin/sanpham')->with('success',"Thêm thành công");
    }


    public function show(Product $product)
    {
        //
    }
    public function edit($id)
    {
        $product = DB::select("SELECT * FROM products WHERE product_id = '$id'");
        $photos = DB::select("SELECT * FROM photos WHERE product_id='$id'");
        $danhmucs = DB::select("SELECT * FROM danhmucs");
        return view('admin.products.edit', [
            'product' => $product[0],
            'photos' => $photos,
            'danhmucs' => $danhmucs
        ]);
    }
    public function update(Request $request, $id)
    {

        $request->validate([
            'product_name'=>'required',
            'price'=>'required',
            'ma_danhmuc'=>'required',
        ]);
        //Xử lý bảng products
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $currentDateTime = date("Y-m-d H:i:s");

        DB::update("UPDATE products SET product_name='$request->product_name', price = '$request->price',
         description = '$request->description', ma_danhmuc='$request->ma_danhmuc', updated_at='$currentDateTime'
         WHERE product_id= '$id'");


        //Xử lý bảng photo
        if (!is_null($request->image)) {
            
            $photos = DB::select("SELECT * FROM photos WHERE product_id= '$id'");
            foreach($photos as $photo)
            {
                $file_path = 'images/'.$photo->photo_link;
                if(File::exists($file_path))
                {
                    File::delete($file_path);
                }
            }
            DB::delete("DELETE FROM photos WHERE product_id='$id'");

            foreach ($request->image as $value) {
                $imageName = time() . '_' . $value->getClientOriginalName();
                $value->move(public_path('images'), $imageName);
                $imageNams[] = $imageName;
                $photo = new Photo();
                $photo->photo_link = $imageName;
                $photo->product_id = $id;
                $photo->save();
            }
        }

        $dt = DB::select("SELECT * FROM products JOIN danhmucs ON products.ma_danhmuc = danhmucs.ma_danhmuc WHERE product_id='$id'");

        $data =
        [
            'handle'=>'updated',
            'product_id'=>$dt[0]->product_id,
            'product_name'=>$dt[0]->product_name,
            'price'=>$dt[0]->price,
            'tendanhmuc'=>$dt[0]->tendanhmuc,
        
        ];
        event(new ProductEvent($data));

        return redirect('admin/sanpham');
    }
    public function delete($id)
    {
        $product = DB::select("SELECT * FROM products JOIN danhmucs ON products.ma_danhmuc = danhmucs.ma_danhmuc WHERE product_id = '$id'");
        $photos = DB::select("SELECT * FROM photos WHERE product_id='$id'");
        return view('admin.products.delete', [
            'product' => $product[0],
            'photos' => $photos
        ]);
    }

    public function destroy(Request $request)
    {
        $photos = DB::select("SELECT * FROM photos WHERE product_id='$request->product_id'");

        //check
        $check = DB::table('orderdetails')->where('product_id',$request->product_id)->get();

        if(count($check) > 0)
        {
            return redirect('admin/sanpham')->with('danger','Xóa thất bại');
        }
        
        foreach($photos as $photo)
        {
            $file_path = 'images/'.$photo->photo_link;
                if(File::exists($file_path))
                {
                    File::delete($file_path);
                }
        }
        DB::delete("DELETE FROM photos WHERE product_id ='$request->product_id'");
        DB::delete("DELETE FROM products WHERE product_id = '$request->product_id'");
        $data=[
            'handle'=>'deleted',
            'product_id'=>$request->product_id,
        ];

        event(new ProductEvent($data));

        return redirect('admin/sanpham')->with('success',"Đã xóa thành công!");
    }

    public function productList()
    {
        $products = Product::select("product_name")->get();
      
        $data= [];
        foreach($products as $item)
        {
            $data[]= $item->product_name;
        }

        return $data;
    }

    public function donhang()
    {
        $orders = DB::table('orders')
                    ->join('users','orders.user_id','=','users.id')
                    ->orderBy('order_id','asc')
                    ->paginate(6);

        // dd($orders);
        return view('admin.donhangs.index',[
            'orders' => $orders
        ]);

    }
    public function changeStatus(Request $request)
    {
        if($request->status == 1){ //chuẩn bị hàng
            Order::where('order_id', $request->order_id)->update(['status' => 1]);
        }else //giao hàng
        {
            Order::where('order_id', $request->order_id)->update(['status' => 2]);
        }
        return 0;
    }
    public function xoadon(Request $request)
    {
        Orderdetail::where('order_id',$request->order_id)->delete();
        Order::where('order_id',$request->order_id)->delete();
        return 0;
    }

    public function back1step(Request $request)
    {
        $order = Order::where('order_id', $request->order_id)->first(); 
        $status = $order->status -1 ;
        Order::where('order_id', $request->order_id)->update(['status' => $status]);
        return $status;
    }

    public function chitietdonhang($id)
    {
        $chitietdonhang = DB::table('orderdetails')
                            ->join('orders','orderdetails.order_id','=','orders.order_id')
                            ->join('products', 'products.product_id','=','orderdetails.product_id')
                            ->first();

        
    }

}
