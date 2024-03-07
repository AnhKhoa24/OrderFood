@extends('layouts.admin')
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tables</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
            DataTables documentation</a>.</p>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Xác nhận xóa sản phẩm</h1>
                    </div>
                        <div class="mb-3">
                            <label class="form-label">Tên sản phẩm</label>
                            <p class="form-control">
                             {{ $product->product_name }} </p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Giá bán</label>
                            <p class="form-control">
                                {{ $product->price }}
                            </p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Danh mục</label>
                            <p class="form-control">
                                {{ $product->tendanhmuc }}
                            </p>
                        </div>
                        <br>
                        <div>
                            @foreach ($photos as $photo)
                                <img src="/images/{{ $photo->photo_link }}" height="100px">
                            @endforeach
                        </div>

                        <form action="/admin/sanpham/{{ $product->product_id }}" method="post">
                            @method('DELETE')
                            @csrf
                            <input type="hidden" value="{{ $product->product_id }}" name="product_id">
                            <br>
                            <button type="submit" class="btn btn-danger">Xóa</button>
                        </form>

                </div>
            </div>
        </div>
    </div>
@endsection
