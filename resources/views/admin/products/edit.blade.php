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
                        <h1 class="h4 text-gray-900 mb-4">Thêm sản phẩm</h1>
                    </div>
                    <form method="post" action="/admin/sanpham/{{ $product->product_id }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Tên sản phẩm</label>
                            <input type="text" class="form-control" name="product_name"
                                value="{{ $product->product_name }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Giá bán</label>
                            <input type="number" class="form-control" name="price" value="{{ $product->price }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Danh mục sản phẩm</label>
                            <select name="ma_danhmuc" class="form-control">
                                @foreach ($danhmucs as $danhmuc)
                                    <option value="{{ $danhmuc->ma_danhmuc }}"
                                        @if ($danhmuc->ma_danhmuc == $product->ma_danhmuc) selected @endif>{{ $danhmuc->tendanhmuc }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mô tả</label>
                            <textarea class="form-control" aria-label="With textarea" name="description"> {{$product->description}}</textarea>
                        </div>
                        <div class="form-item">
                            <label class="form-label">Tải ảnh lên<sup>*</sup></label>
                            <input type="file" name="image[]" class="form-control @error('image.*') is-invalid @enderror"
                                multiple>
                            @error('image.*')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <br>
                        <div>
                            @foreach ($photos as $photo)
                                <img src="/images/{{ $photo->photo_link }}" height="100px">
                            @endforeach
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
