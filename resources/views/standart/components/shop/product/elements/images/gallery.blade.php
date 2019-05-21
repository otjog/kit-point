@if( isset( $product->images ) && count( $product->images ) > 1)
    <!-- List -->
    <div class="col-lg-3 order-lg-1 order-2">
        <ul class="image_list">
            @foreach( $product->images as $image)

                <li>
                    <a class="fancybox" rel="product_images" href="{{ URL::asset('storage/img/shop/product/l/' . $image->name) }}" title="">
                        <img
                                src="{{ URL::asset('storage/img/shop/product/xs/' . $image->name) }}"
                                alt=""
                        />
                    </a>
                </li>

            @endforeach
        </ul>
    </div>

@endif

<!-- Main Image -->
<div class="col-lg-9 order-lg-2 order-1">
    <div class="image_selected">
        @if( isset($product->images[0]->name) && $product->images[0]->name !== null)
            <a class="fancybox" rel="product_images" href="{{ URL::asset('storage/img/shop/product/l/' . $product->images[0]->name) }}" title="">
                <img
                        src="{{ URL::asset('storage/img/shop/product/m/' . $product->images[0]->name) }}"
                        alt=""
                />
            </a>
        @else
            <img
                    src="{{ URL::asset('storage/img/shop/default/m/' . $global_data['project_data']['components']['shop']['images']['default_name']) }}"
                    alt=""
            />
        @endif
    </div>
</div>