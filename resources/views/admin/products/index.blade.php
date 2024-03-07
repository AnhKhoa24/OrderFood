@extends('layouts.admin')
@section('content')
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('ea6012be0da9b8704099', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('channel-1');
        channel.bind('event-1', function(data) {
            //  alert(JSON.stringify(data.thongbao.product_name));
            const change = document.getElementById(data.thongbao.product_id);
            if (data.thongbao.handle == 'updated') {
                change.innerHTML = "<td>" + data.thongbao.product_name + "</td>" +
                    "<td>" + data.thongbao.price + "</td>" +
                    "<td> " + data.thongbao.tendanhmuc + " </td>" +
                    "<td><a href='/admin/sanpham/" + data.thongbao.product_id + "/edit'>Sửa</a>|" +
                    "<a href='/admin/sanpham/" + data.thongbao.product_id + "/delete'>Xóa</a></td>";
            } else if (data.thongbao.handle == 'deleted') {
                change.remove();
            } else if (data.thongbao.handle == 'created') {

                var newHTML = "<tr id ='" + data.thongbao.product_id + "'><td>" + data.thongbao.product_name +
                    "</td>" +
                    "<td>" + data.thongbao.price + "</td>" +
                    "<td> " + data.thongbao.tendanhmuc + " </td>" +
                    "<td><a href='/admin/sanpham/" + data.thongbao.product_id + "/edit'>Sửa</a>|" +
                    "<a href='/admin/sanpham/" + data.thongbao.product_id + "/delete'>Xóa</a></td></tr>";

                const them = document.getElementById('ds')
                them.insertAdjacentHTML('beforeend', newHTML);
            }
        });
    </script>

     

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tables</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
            DataTables documentation</a>.</p>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách sản phẩm</h6>     
        </div>
        <div class="card-header py-1">
            <form class="form-inline my-2 my-md-0 mw-100" action="/admin/sanpham">
            <div class="input-group">
                <input id="tags" type=" search" class="form-control bg-light border-1 small" placeholder="Search for..."
                    aria-label="Search" aria-describedby="basic-addon2" name="search">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </div>
        </form>
        </div>
        @if (session('success'))
            <div id="flash-message" class="alert alert-success">
                {{ session('success') }}
            </div>
            <script>
                $(document).ready(function() {
                    // Tự động ẩn thông báo sau 3 giây
                    setTimeout(function() {
                        $("#flash-message").fadeOut("slow");
                    }, 3000);
                });
            </script>
        @endif
        @if (session('danger'))
            <div id="flash-message" class="alert alert-danger">
                {{ session('danger') }}
            </div>
            <script>
                $(document).ready(function() {
                    // Tự động ẩn thông báo sau 3 giây
                    setTimeout(function() {
                        $("#flash-message").fadeOut("slow");
                    }, 3000);
                });
            </script>
        @endif


        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Danh mục</th>
                            <th><a href="/admin/sanpham/create">Thêm mới</a></th>
                        </tr>
                    </thead>
                    <tbody id="ds">
                        @foreach ($products as $item)
                            <tr id="{{ $item->product_id }}">
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->tendanhmuc }}</td>
                                <td>
                                    <a href="/admin/sanpham/{{ $item->product_id }}/edit">Sửa</a>|
                                    <a href="/admin/sanpham/{{ $item->product_id }}/delete">Xóa</a>
                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $products->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
