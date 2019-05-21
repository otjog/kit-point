@foreach($offers as $offer)
    @if( isset($offer->products) && count($offer->products) > 0)
        <section class="product-carousel">
            <!-- Heading Starts -->
            <h2 class="product-head">{{$offer->header}}</h2>
            <!-- Heading Ends -->
            <!-- Products Row Starts -->
            <div class="row">
                <div class="col-12">
                    <!-- Product Carousel Starts -->
                    <div class="owl-carousel">
                    @foreach($offer->products as $product)
                        <!-- Product Starts -->
                        @include('_raduga.components.shop.product.elements.product_card', ['wrapClass' => 'item'])
                        <!-- Product Ends -->
                        @endforeach
                    </div>
                    <!-- Product Carousel Ends -->
                </div>
            </div>
            <!-- Products Row Ends -->
        </section>
    @endif
@endforeach