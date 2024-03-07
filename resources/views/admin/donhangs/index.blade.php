@extends('layouts.admin')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tables</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
            DataTables documentation</a>.</p>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Thông tin người đặt</th>
                        <th>Thông tin người nhận</th>
                        <th>Chi tiết</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody id="ds">
                    @foreach ($orders as $order)
                        <tr id="tr_{{ $order->order_id }}">
                            <td>{{ $order->order_id }}</td>
                            <td>
                                {{ $order->name }}
                                <br>
                                {{ $order->email }}
                            </td>
                            <td>
                                {{ $order->recipient_name }}
                                <br>
                                {{ $order->recipient_phone }}
                                <br>
                                {{ $order->recipient_address }}
                            </td>
                            <td>
                                <a href="/admin/donhang/chitietdonhang/{{ $order->order_id }}">Chi tiết</a>
                            </td>
                            <td id="status_{{ $order->order_id }}">
                                @switch($order->status)
                                    @case(0)
                                        Đang đặt
                                    @break

                                    @case(1)
                                        <span style="color: dodgerblue"> Đang chuẩn bị</span>
                                    @break

                                    @default
                                        <span style="color: green">Đang giao hàng</span>
                                @endswitch
                            </td>
                            <td id="handle_{{ $order->order_id }}">
                                @switch($order->status)
                                    @case(0)
                                        <div class="btn-group">
                                            <button onclick="handle({{ $order->order_id }}, 1)" class="btn btn-success">Chuẩn
                                                bị</button>
                                            <button onclick="xoadon({{ $order->order_id }})" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                        </div>
                                    @break

                                    @case(1)
                                        <div class="btn-group">   
                                            <button onclick="back1step({{ $order->order_id }})" class="btn btn-primary"><i class="fas fa-chevron-left"></i></button>
                                            <button onclick="handle({{ $order->order_id }}, 2)" class="btn btn-success">Giao
                                                hàng</button>
                                            <button onclick="xoadon({{ $order->order_id }})" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                        </div>
                                    @break

                                    @default
                                    <div class="btn-group">
                                        <button onclick="back1step({{ $order->order_id }})" class="btn btn-primary"><i class="fas fa-chevron-left"></i></button>
                                        <button onclick="xoadon({{ $order->order_id }})" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                    </div>
                                      
                                @endswitch
                            </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $orders->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>


    <script>
        function handle(id, status) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('changeStatus') }}",
                type: 'POST',
                dataType: "json",
                data: {
                    order_id: id,
                    status: status,
                },
                success: function() {
                    // console.log("sucess!!!");
                    var change = document.getElementById('handle_' + id);
                    var change_status = document.getElementById('status_' + id);
                    if (status == 1) {
                        change.innerHTML = ` <div class="btn-group">   
                                            <button onclick="back1step(${id})" class="btn btn-primary"><i class="fas fa-chevron-left"></i></button>
                                            <button onclick="handle(${id}, 2)" class="btn btn-success">Giao
                                                hàng</button>
                                            <button onclick="xoadon(${id})" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                        </div>`;
                        change_status.innerHTML = "<span style='color: dodgerblue'> Đang chuẩn bị</span>";
                    } else if (status == 2) {
                        change.innerHTML = `<div class="btn-group">
                                        <button onclick="back1step(${id})" class="btn btn-primary"><i class="fas fa-chevron-left"></i></button>
                                        <button onclick="xoadon(${id})" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                    </div>`;
                        change_status.innerHTML = `<span style="color: green">Đang giao hàng</span>`;
                    }

                }
            });
        }

        function xoadon(id) {
            swal({
                    title: "Bạn có chắc muốn xóa nó?",
                    text: "Xóa bỏ đơn hàng này, đơn hàng sẽ bị từ chối từ phía người bán",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: "{{ route('xoadon') }}",
                            type: 'POST',
                            dataType: "json",
                            data: {
                                order_id: id,
                            },
                            success: function() {
                                swal("Đã xóa thành công!", {
                                    icon: "success",
                                });

                                var get = document.getElementById('tr_' + id);
                                get.remove();
                            }
                        });
                    }
                });
        }

        function back1step(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('back1step') }}",
                type: 'POST',
                dataType: "json",
                data: {
                    order_id: id,
                },
                success: function(response) {
                    var change = document.getElementById('handle_' + id);
                    var change_status = document.getElementById('status_' + id);
                    if (response == 0) {
                        change.innerHTML = `<div class="btn-group">
                                            <button onclick="handle(${id}, 1)" class="btn btn-success">Chuẩn
                                                bị</button>
                                            <button onclick="xoadon(${id})" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                        </div>`;
                        change_status.innerHTML ="Đang đặt";
                    }
                    else if(response == 1)
                    {
                        change.innerHTML = ` <div class="btn-group">
                                            <button onclick="back1step(${id})" class="btn btn-primary"><i class="fas fa-chevron-left"></i></button>
                                        <button onclick="handle(${id}, 2)" class="btn btn-success">Giao
                                                hàng</button>
                                            <button onclick="xoadon(${id})" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                        </div>`;
                        change_status.innerHTML=` <span style="color: dodgerblue"> Đang chuẩn bị</span>`;
                    }
                }
            });

        }
    </script>
@endsection
