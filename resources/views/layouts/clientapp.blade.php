<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Đặt đồ ăn nhanh</title>

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

    <!-- Bootstrap -->
    <link type="text/css" rel="stylesheet" href="{{ asset('2-assets/css/bootstrap.min.css') }}" />

    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}

    <!-- Slick -->
    <link type="text/css" rel="stylesheet" href="{{ asset('2-assets/css/slick.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('2-assets/css/slick-theme.css') }}" />

    <!-- nouislider -->
    <link type="text/css" rel="stylesheet" href="{{ asset('2-assets/css/nouislider.min.css') }}" />

    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="{{ asset('2-assets/css/font-awesome.min.css') }}">

    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="{{ asset('2-assets/css/style.css') }}" />

    <link rel="stylesheet" href="{{ asset('2-assets/css/sweetalert.css') }}">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>

    <script>
        $.ajax({
            method: "GET",
            url: "/product-list",
            success: function(response) {
                // console.log(response);
                test(response);

            }
        });

        function test(availableTags) {
            $("#tags").autocomplete({
                source: availableTags
            });
        };
    </script>

    <style>
        .sticky {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            /* Các thuộc tính khác cần thiết */
        }
    </style>

</head>

<body>
    <!-- HEADER -->
    <header id="myHeader" class="">
        <!-- TOP HEADER -->
        <div id="top-header">
            <div class="container">
                <ul class="header-links pull-left">
                    <li><a href="#"><i class="fa fa-phone"></i> +84 986-404-150</a></li>
                    <li><a href="#"><i class="fa fa-envelope-o"></i> anhkhoa.24052003@gmail.com</a></li>
                    <li><a href="#"><i class="fa fa-map-marker"></i> 58/30 Trần Văn Dư, Quận Tân Bình</a></li>
                </ul>
                <ul class="header-links pull-right">

                    @if (Auth::user())
                        <li class="dropdown">
                            <a href="" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                <i class="fa fa-user-o"></i>{{ Auth::user()->name }}
                            </a>

                            <ul class="dropdown-menu">
                                <li><a href="/canhan" style="color: black;">Thông tin cá nhân</a></li>
                                <li><a href="#" id="submitLink" style="color: rgb(252, 0, 0);">Đăng xuất</a></li>
                            </ul>
                        </li>
                    @else
                        <li><a href="{{ route('login') }}"><i class="fa fa-user-o"></i>Đăng nhập</a></li>
                    @endif


                    {{-- <li><a href="#"><i class="fa fa-dollar"></i> USD</a></li> --}}
                    {{-- @if (Auth::user())
					<li><a href="/canhan"><i class="fa fa-user-o"></i>{{Auth::user()->name  }}</a></li>
					@else
					
					@endif --}}
                </ul>
            </div>
        </div>
        <!-- /TOP HEADER -->

        <!-- MAIN HEADER -->
        <div id="header">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <!-- LOGO -->
                    <div class="col-md-3">
                        <div class="header-logo">
                            <a href="/" class="logo">
                                <img src="2-assets/img/logolo.png" alt="" height="70px"
                                    style="border-top-left-radius: 50px; border-bottom-right-radius: 50px; ">
                            </a>
                        </div>
                    </div>
                    <!-- /LOGO -->

                    <!-- SEARCH BAR -->
                    <div class="col-md-6">
                        <div class="header-search">
                            <form action="">
                                <input id="tags" type="search" class="input input-select"
                                    placeholder="Tìm kiếm sản phẩm...">
                                <button class="search-btn">Tìm kiếm</button>
                            </form>
                        </div>
                    </div>
                    <!-- /SEARCH BAR -->

                    <!-- ACCOUNT -->
                    <div class="col-md-3 clearfix">
                        <div class="header-ctn">
                            <!-- Wishlist -->
                            <div>
                                <a href="#">
                                    <i class="fa fa-heart-o"></i>
                                    <span>Your Wishlist</span>
                                    <div class="qty">2</div>
                                </a>
                            </div>
                            <!-- /Wishlist -->

                            <!-- Cart -->
                            <div class="dropdown">
                                <a href="" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span>Giỏ hàng</span>
                                    <div class="qty" id="count_cart">
                                        @if (session('cart.items'))
                                            {{ count(session('cart.items')) }}
                                        @else
                                            0
                                        @endif
                                    </div>
                                </a>
                                <div class="cart-dropdown">
                                    <div class="cart-list" id="cartlist">
                                        @php
                                            $tong = 0;
                                        @endphp
                                        @foreach (session('cart.items', []) as $item)
                                            <div class="product-widget" id="{{ $item['product_id'] }}">
                                                <div class="product-img">
                                                    <img src="images/{{ $item['photo'] }}" alt="">
                                                </div>
                                                <div class="product-body">
                                                    <h3 class="product-name"><a
                                                            href="#">{{ $item['product_name'] }}</a>
                                                    </h3>
                                                    <h4 class="product-price"><span
                                                            class="qty">x{{ $item['quantity'] }}</span>{{ number_format($item['price'] * $item['quantity'], 0) }}vnđ
                                                    </h4>
                                                </div>
                                                <button onclick="Xoasp({{ $item['product_id'] }})" class="delete"><i
                                                        class="fa fa-close"></i></button>
                                            </div>
                                            @php
                                                $tong += $item['quantity'] * $item['price'];
                                            @endphp
                                        @endforeach
                                    </div>
                                    <div class="cart-summary" id="tinhtong">
                                        @if (session('cart.items'))
                                            <small> {{ count(session('cart.items')) }} sản phẩm đã chọn</small>
                                            <h5>Tổng tiền: {{ number_format($tong, 0) }} vnđ</h5>
                                        @else
                                            <small>Chưa có sản phẩm</small>
                                        @endif
                                    </div>
                                    <div class="cart-btns">
                                        <a href="#">View Cart</a>
                                        <a href="/checkout">Checkout <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <!-- /Cart -->

                            <!-- Menu Toogle -->
                            <div class="menu-toggle">
                                <a href="#">
                                    <i class="fa fa-bars"></i>
                                    <span>Menu</span>
                                </a>
                            </div>
                            <!-- /Menu Toogle -->
                        </div>
                    </div>
                    <!-- /ACCOUNT -->
                </div>
                <!-- row -->
            </div>
            <!-- container -->
        </div>
        <nav id="navigation">
            <!-- container -->
            <div class="container">
                <!-- responsive-nav -->
                <div id="responsive-nav">
                    <!-- NAV -->
                    <ul class="main-nav nav navbar-nav">
                        <li><a href="/">Home</a></li>
                        <li><a href="">Top sản phẩm</a></li>
                        <li><a href="#">Đơn hàng của tôi</a></li>
                        <li><a href="/canhan">Cá nhân</a></li>
                    </ul>
                    <!-- /NAV -->
                </div>
                <!-- /responsive-nav -->
            </div>
            <!-- /container -->
        </nav>
        <!-- /MAIN HEADER -->
    </header>
    <!-- /HEADER -->

    <!-- NAVIGATION -->

    <!-- /NAVIGATION -->


    <main>
        @yield('content')
    </main>

    {{-- @include('layouts.footer-clientapp') --}}

    <!-- jQuery Plugins -->
    <script src="{{ asset('2-assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('2-assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('2-assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('2-assets/js/nouislider.min.js') }}"></script>
    <script src="{{ asset('2-assets/js/jquery.zoom.min.js') }}"></script>
    <script src="{{ asset('2-assets/js/main.js') }}"></script>
    {{-- <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script> --}}
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script src="{{ asset('2-assets/js/sweetalert.min.js') }}"></script>


    @if (Auth::user())
        <form id="myForm" method="POST" action="{{ route('logout') }}">
            @csrf
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
        </form>
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                var myForm = document.getElementById('myForm');
                var submitLink = document.getElementById('submitLink');

                submitLink.addEventListener('click', function(event) {

                    event.preventDefault();
                    myForm.submit();
                });
            });
        </script>
    @endif

    <script>
        //Xóa sản phẩm ra giỏ hàng thao tác ajax

        function Xoasp(id) {
            var spxoa = document.getElementById(id);
            if (spxoa) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('delete.cart') }}",
                    type: 'POST',
                    dataType: "json",
                    data: {
                        product_id: id,
                    },
                    success: function(response) {
                        spxoa.remove();
                        document.getElementById('count_cart').innerHTML = response.sosp;
                        var tien = parseFloat(response.tongtien);
                        if (response.sosp > 0) {
                            var doi = document.getElementById('tinhtong');
                            doi.innerHTML = "<small>" + response.sosp + " sản phẩm đã chọn</small>" +
                                "<h5>Tổng tiền: " + tien.toLocaleString('en-US') + " vnđ</h5>";
                        } else {
                            var doi = document.getElementById('tinhtong');
                            doi.innerHTML = "<small>Chưa có sản phẩm</small>";
                        }
                    }
                })

            }
        }
    </script>

    <script>
        $(document).ready(function() {
            var url = window.location.pathname;
            $('.main-nav a').each(function() {
                if ($(this).attr('href') === url) {
                    $(this).closest('li').addClass('active');
                }
            });
        });
    </script>

    <script>
        function chon(id) {
            $.ajax({
                url: "/check",
                method: "GET",
                success: function(response) {
                    if (response == 1) {
                        var cart_product_id = id;
                        var cart_product_name = $('.cart_product_name_' + id).val();
                        var cart_product_photo = $('.cart_product_photo_' + id).val();
                        var cart_product_price = $('.cart_product_price_' + id).val();
                        cart_product_price = parseFloat(cart_product_price);

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: "{{ route('add.cart') }}",
                            type: 'POST',
                            dataType: "json",
                            data: {
                                cart_product_id: cart_product_id,
                                cart_product_name: cart_product_name,
                                cart_product_photo: cart_product_photo,
                                cart_product_price: cart_product_price,

                            },
                            success: function(response) {
                                swal("Thành công!", "Thêm thành công!", "success");

                                var tien = parseFloat(response.tongtien);
                                var doi = document.getElementById('tinhtong');
                                doi.innerHTML = "<small>" + response.count_cart +
                                    " sản phẩm đã chọn</small>" +
                                    "<h5>Tổng tiền: " + tien.toLocaleString('en-US') +
                                    " vnđ</h5>";

                                if (response.status == false) {
                                    document.getElementById('count_cart').innerHTML = response
                                        .count_cart;
                                    //dom
                                    var newHTML = " <div class='product-widget' id='" +
                                        cart_product_id + "'>" +
                                        "<div class='product-img'>" +
                                        "<img src='images/" + cart_product_photo + "'>" +
                                        "</div>" +
                                        "<div class='product-body'>" +
                                        "<h3 class='product-name'><a href='#'>" +
                                        cart_product_name +
                                        "</a>" +
                                        "</h3>" +
                                        "<h4 class='product-price'><span class='qty'>x" + 1 +
                                        "</span>" + cart_product_price.toLocaleString('en-US') +
                                        " vnđ</h4>" +
                                        "</div>" +
                                        "<button onclick='Xoasp(" + cart_product_id +
                                        ")' class='delete'><i class='fa fa-close'></i></button>" +
                                        "</div>";
                                    var updateCart = document.getElementById('cartlist');
                                    updateCart.insertAdjacentHTML('beforeend', newHTML);
                                } else {
                                    var take = document.getElementById(cart_product_id);
                                    var tong = response.quantity * cart_product_price;
                                    var doi = take.getElementsByClassName("product-price")[0];
                                    doi.innerHTML = "<span class='qty'>x" + response.quantity +
                                        "</span> " + tong.toLocaleString('en-US') + "vnđ";
                                }

                            }

                        });

                    } else {
                        window.location.href = "/login";
                    }
                }
            });
        }
    </script>
    <script>
        window.onscroll = function() {
            fixHeader()
        };

        var header = document.getElementById("myHeader");
        var sticky = header.offsetTop;

        function fixHeader() {
            if (window.pageYOffset > sticky) {
                header.classList.add("sticky");
            } else {
                header.classList.remove("sticky");
            }
        }
    </script>
</body>

</html>
