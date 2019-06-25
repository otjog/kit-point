@if( isset( $product->images ) && count( $product->images ) > 1)
    <!-- List -->
    <div class="col-lg-3 order-lg-1 order-2 d-none d-lg-block">
        <ul class="image_list">

            @foreach( $product->images as $image)

                <li>
                    <a
                            href="{{route('models.sizes.images.show', ['product', 'l', $image->src])}}"
                            class="fancybox"
                            data-fancybox="product_images"
                            rel="product_images"
                            title=""
                    >
                        <img
                                src="{{route('models.sizes.images.show', ['product', 'm', $image->src])}}"
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
        @if( isset($product->images[0]->src) && $product->images[0]->src !== null)
            <a
                    rel="product_images"
                    href="{{route('models.sizes.images.show', ['product', 'l', $product->images[0]->src])}}"
                    title=""
            >
                <img
                        src="{{route('models.sizes.images.show', ['product', 'm', $product->images[0]->src])}}"
                        alt=""
                />
            </a>
        @else
            <img
                    src="{{route('models.sizes.images.show', ['product', 'm', 'no_image.jpg'])}}"
                    alt=""
            />
        @endif
    </div>
</div>