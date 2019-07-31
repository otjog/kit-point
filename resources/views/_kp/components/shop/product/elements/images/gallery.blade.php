@if( isset( $product->images ) && count( $product->images ) > 1)
    <!-- List -->
    <div class="col-lg-3 order-lg-1 order-2 d-none d-lg-block">
        <ul class="image_list">

            @foreach( $product->images as $image)
                <li>
                    <a
                            href="{{route('getImage', ['product', 'l', $image->src, $product->id])}}"
                            class="fancybox"
                            data-fancybox="product_images"
                            rel="product_images"
                            title=""
                    >
                        <img
                                src="{{route('getImage', ['product', 'xs', $image->src, $product->id])}}"
                                alt="{{$image->alt or $product->name}}"
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
        @php
            if (count($product->images) > 0)
                $imageSrc = $product->images[0]->src;
            else
                $imageSrc = 'noimage';
        @endphp
        <a
                rel="product_images"
                href="{{route('getImage', ['product', 'l', $imageSrc, $product->id])}}"
                title=""
        >
            <img
                    src="{{route('getImage', ['product', 'm', $imageSrc, $product->id])}}"
                    alt="{{$product->images[0]->alt or $product->name}}"
            />
        </a>
    </div>
</div>