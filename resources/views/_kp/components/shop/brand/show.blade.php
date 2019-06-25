@extends($global_data['template']['name'] . '.index')

@php
    $brand =& $global_data['shop']['brand'];
    $products =& $global_data['shop']['products'];
    $parameters =& $global_data['shop']['parameters'];
@endphp

@section('component')
    <div class="shop_content">

        <h1>{{$global_data['header_page']}}</h1>

    <!--div class="shop_bar clearfix mb-3">
            <div class="shop_product_count"><span>186</span> products found</div>
            <div class="shop_sorting">
                <span>Sort by:</span>
                <ul>
                    <li>
                        <span class="sorting_text">highest rated<i class="fas fa-chevron-down"></i></span>
                        <ul>
                            <li class="shop_sorting_button" data-isotope-option='{ "sortBy": "original-order" }'>highest rated</li>
                            <li class="shop_sorting_button" data-isotope-option='{ "sortBy": "name" }'>name</li>
                            <li class="shop_sorting_button"data-isotope-option='{ "sortBy": "price" }'>price</li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div-->

        @include( $global_data['template']['name'] . '.components.shop.product.list')

    </div>
@endsection