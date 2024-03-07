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
                        <h1 class="h4 text-gray-900 mb-4">Tạo danh mục</h1>
                    </div>
                    <form class="user" method="post" action="/admin/danhmuc">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" name="tendanhmuc"
                                placeholder="Tên danh mục cần thêm">

                            @if ($errors->any())
                                 @foreach ($errors->all() as $error)
                                     <p class="text-danger">
                                        {{ $error }}
                                     </p>
                                 @endforeach
                            @endif
                        </div>

                        <button class="btn btn-primary btn-user btn-block" type="submit">Thêm</button>
                    </form>
                    <hr>

                </div>
            </div>
        </div>
    </div>
@endsection
