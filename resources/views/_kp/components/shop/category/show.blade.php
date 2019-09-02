@extends($global_data['template']['name'] . '.index')

@php
    $currentCategory =& $global_data['shop']['category'][0];
    $products =& $global_data['shop']['products'];
    $parameters =& $global_data['shop']['parameters'];
@endphp

@section('component')
    <div class="shop_content">

        <div class="container">

            <h1>{{$global_data['header_page']}}</h1>

            @if(isset($currentCategory->children) && count($currentCategory->children) > 0)
                <div class="category-list py-2">
                    @foreach($currentCategory->children->chunk($global_data['components']['shop']['chunk_products']) as $categories_row)
                        <div class="row">
                            @foreach( $categories_row as $key => $category )
                                <div class="col-12 col-lg-3">
                                    <div class="category-wrap text-center p-3 border rounded">
                                        <div class="category-image">
                                            <a href="{{ route( 'categories.show', $category->id ) }}">
                                                @php
                                                    if (count($category->images) > 0)
                                                        $imageSrc = $category->images[0]->src;
                                                    else
                                                        $imageSrc = 'noimage';
                                                @endphp
                                                <img
                                                        class="img-fluid"
                                                        src="{{route('getImage', ['category', 'xs', $imageSrc, $category->id])}}"
                                                        alt="{{$category->images[0]->alt or $category->name}}"
                                                />

                                            </a>
                                        </div>
                                        <div class="category-name pt-3">
                                            <strong>
                                                <a class="text-dark" href="{{ route( 'categories.show', $category->id ) }}">
                                                    {{ $category->name }}
                                                </a>
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endif

            {{--div class="shop_bar clearfix mb-3">
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
            </div--}}

            @include( $global_data['template']['name'] . '.components.shop.product.list')

            @if(isset($currentCategory->description ))
                <div>
                    <p>{!! $currentCategory->description  !!}</p>
                </div>
            @endif

        </div>

    </div>
@endsection