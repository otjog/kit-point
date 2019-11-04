<div class="row">
    @if( isset( $product->images ) && count( $product->images ) > 1)
    {{-- List --}}
    <div class="col-lg-3 order-lg-1 order-2 d-none d-lg-block">
        {{-- Для вертикального слайдера используется плагин TinySlider на базе OwlCarousel.
         Если будем переделывать на горизонтальный слайдер, то используем Owl Carousel, а этот удалить --}}
        <div class="tiny_slider_arrow" data-direction="prev"></div>

        <div class="image_list thumbnail-carousel owl-theme">

            @foreach( $product->images as $image)
                <div class="item">
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
                </div>

            @endforeach

        </div>

        <div class="tiny_slider_arrow" data-direction="next"></div>

    </div>

@endif

    {{-- Main Image --}}
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
</div>