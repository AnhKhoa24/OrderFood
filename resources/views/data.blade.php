@foreach ($posts as $sanpham)

    <!-- product -->
    <div class="col-md-4 col-xs-6">
        <div class="product">
            <div class="product-img">
                <img src="images/{{ $sanpham->photo_link }}" alt="" height="200px">
                <div class="product-label">
                    <span class="new">NEW</span>
                </div>
            </div>
            <form>   
                @csrf
                <input type="hidden" class="cart_product_id_{{$sanpham->product_id}}" value="{{ $sanpham->product_id }}">
                <input type="hidden" class="cart_product_name_{{$sanpham->product_id}}" value="{{ $sanpham->product_name }}">
                <input type="hidden" class="cart_product_photo_{{$sanpham->product_id}}" value="{{ $sanpham->photo_link }}">
                <input type="hidden" class="cart_product_price_{{$sanpham->product_id}}" value="{{ $sanpham->price }}">
                <input type="hidden" class="cart_product_qty_{{$sanpham->product_id}}" value="1">

                <div class="product-body">
                    <p class="product-category">{{ $sanpham->tendanhmuc }}</p>
                    <h3 class="product-name"><a href="#">{{ $sanpham->product_name }}</a></h3>
                    <h4 class="product-price">{{ number_format($sanpham->price, 0) }} vnđ</h4>
                    <div class="product-rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-o"></i>
                    </div>
                    <div class="product-btns">
                        <button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">add to
                                wishlist</span></button>
                        <button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to
                                compare</span></button>
                        <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick
                                view</span></button>
                    </div>
                </div>
                <div class="add-to-cart">
                    <button type="button" onclick="chon({{ $sanpham->product_id }})" class="add-to-cart-btn" data-id_product="{{ $sanpham->product_id }}"><i class="fa fa-shopping-cart"></i> Thêm vào giỏ hàng</button>
                </div>
            </form>

        </div>
    </div>

    <div class="clearfix visible-sm visible-xs"></div>
    <!-- /product -->
@endforeach
