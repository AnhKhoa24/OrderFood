@extends('layouts.clientapp')

@section('content')
    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

                <div class="col-md-7">
                    <!-- Billing Details -->
                    <div class="billing-details">
                        <form action="/dathang" id="in4user" method="POST">
                            @csrf
                            <div class="section-title">
                                <h3 class="title">Thông tin người nhận</h3>
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" name="name" placeholder="Tên người nhận"
                                    value="{{ Auth::user()->name }}">

                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" name="sdt" placeholder="Số điện thoại">
                            </div>
                            <div class="form-group">
                                <input class="input" type="email" name="email" placeholder="Email"
                                    value="{{ Auth::user()->email }}">
                            </div>
                            <div class="form-group">
                                <div class="input-checkbox">
                                    <div class="order-notes">
                                        <textarea class="input" name="address" placeholder="Địa chỉ người nhận"></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /Billing Details -->
                </div>

                <!-- Order Details -->
                <div class="col-md-5 order-details">
                    <div class="section-title text-center">
                        <h3 class="title">Đơn hàng</h3>
                    </div>
                    <div class="order-summary">
                        <div class="order-col">
                            <div><strong>SẢN PHẨM</strong></div>
                            <div><strong>TỔNG</strong></div>
                        </div>
                        <div class="order-products">

                            @php
                                $tong = 0;
                            @endphp
                            @foreach (session('cart.items', []) as $item)
                                <div class="order-col">
                                    <div>x{{ $item['quantity'] }} {{ $item['product_name'] }}</div>
                                    <div>{{ number_format($item['quantity'] * $item['price']) }} vnđ</div>
                                </div>

                                @php
                                    $tong += $item['quantity'] * $item['price'];
                                @endphp
                            @endforeach

                        </div>
                        <div class="order-col">
                            <div>Shiping</div>
                            <div><strong>FREE</strong></div>
                        </div>
                        <div class="order-col">
                            <div><strong>TỔNG</strong></div>
                            <div><strong class="order-total">{{ number_format($tong, 0) . ' đ' }}</strong></div>
                        </div>
                    </div>
                    <button onclick="dathang()" class="primary-btn order-submit">Đặt hàng</button>
                </div>
                <!-- /Order Details -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->

    <script>
        function dathang() {
            var form = document.getElementById("in4user");
            form.submit();
        }
    </script>


    @include('layouts.footer-clientapp')
@endsection
