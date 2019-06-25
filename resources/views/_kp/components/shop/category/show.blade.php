@extends($global_data['template']['name'] . '.index')

@php
    $category =& $global_data['shop']['category'];
    $categories =& $global_data['shop']['childrenCategories'];
    $products =& $global_data['shop']['products'];
    $parameters =& $global_data['shop']['parameters'];
@endphp

@section('component')
    <div class="shop_content">

        <h1>{{$global_data['header_page']}}</h1>

        @if(isset($categories) && count($categories) > 0)
            <div class="category-list py-2">
                @foreach($categories->chunk($global_data['components']['shop']['chunk_products']) as $categories_row)
                    <div class="card-deck">
                        @foreach( $categories_row as $key => $category )
                            <div class="card">
                                <a href="{{ route( 'categories.show', $category->id ) }}">

                                    @if( isset($category->images[0]->src) && $category->images[0]->src !== null )
                                        <img
                                                class="img-fluid"
                                                src="{{route('models.sizes.images.show', ['categories', 's', $category->images[0]->src])}}"
                                                alt=""
                                        />
                                    @else
                                        <img
                                                class="img-fluid"
                                                src="{{route('models.sizes.images.show', ['categories', 's', 'no_image.jpg'])}}"
                                                alt=""
                                        />
                                    @endif

                                </a>
                                <div class="card-body">
                                    <a class="text-dark" href="{{ route( 'categories.show', $category->id ) }}">
                                        {{ $category->name }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        @endif

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