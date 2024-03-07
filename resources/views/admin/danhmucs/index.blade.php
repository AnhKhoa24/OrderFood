@extends('layouts.admin')
@section('content')
    
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
         <div class="card-body">
             <div class="table-responsive">
                 <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                     <thead>
                         <tr>
                             <th>Mã danh mục</th>
                             <th>Tên danh mục</th>   
                             <th>Ngày thêm</th>                                         
                             <th>Lần cập nhật cuối</th>                                         
                             <th><a href="/admin/danhmuc/create">Thêm mới</a></th>
                         </tr>
                     </thead>               
                     <tbody>
                        @foreach ($danhmucs as $item)
                            <tr>
                             <td>{{ $item->ma_danhmuc }}</td>
                             <td>{{ $item->tendanhmuc }}</td>
                             <td>{{ $item->created_at }}</td>
                             <td>{{ $item->updated_at }}</td>
                             <td>
                                 <a href="">Sửa</a>|
                                 <a href="">Xóa</a>
                             </td>
                            </tr>
                        @endforeach
                     </tbody>
                 </table>
             </div>
         </div>
     </div>

@endsection