<div class="col-12 col-lg-4 pt-3 px-0 shadow rounded border-top border-light">

    <div class="row px-3">
        <div class="col-9 pt-2">
            <h4>{{$offer->header}}</h4>
        </div>
        <div class="col-3" style="font-size:1.4rem">
            <a href="#carouselDealWeek" role="button" data-slide="prev"><i class="fas fa-angle-left"></i></a>
            <a href="#carouselDealWeek" role="button" data-slide="next"><i class="fas fa-angle-right"></i></a>
        </div>
    </div>

    <div id="carouselDealWeek" class="carousel slide" data-ride="carousel">

        <div class="carousel-inner">
            @foreach($offer->products as $product)
                <div class="carousel-item pb-4 @if ($loop->first) active @endif" style="padding: 0 15px">
                    <a class="d-block" href="{{ route( 'products.show', $product->id ) }}">
                        @if( isset($product->images[0]->name) && $product->images[0]->name !== null )
                            <img
                                    class='img-fluid mx-auto d-block'
                                    src="{{ URL::asset('storage/img/shop/product/m-13/' . $product->images[0]->name) }}"
                                    alt=""
                            />
                        @else
                            <img
                                    class='img-fluid mx-auto d-block'
                                    src="{{ URL::asset('storage/img/shop/default/xs/' . $global_data['project_data']['components']['shop']['images']['default_name']) }}"
                                    alt=""
                            />
                        @endif
                    </a>

                    <div class="row">

                        <div class="col-8">
                            <a class="text-dark" href="{{ route( 'products.show', $product->id ) }}">
                                @isset($product->manufacturer['name'])
                                    {{ $product->manufacturer['name'] . ' ' }}
                                @endisset

                                {{ $product->name }}

                                @if( isset($product->brands) && count($product->brands) > 0 && $product->brands !== null)

                                    @foreach($product->brands as $brand)
                                        {{ ' | ' . $brand->name}}
                                    @endforeach

                                @endif
                            </a>
                        </div>

                        @if( isset($product->price['value']) && $product->price['value'] !== null)
                            <div class="col-4 text-right text-danger">
                                @if( isset($product->price['sale']) && $product->price['sale'] > 0)
                                    <span class="text-muted">
                                            <s>
                                                {{$product->price['value'] + $product->price['sale']}}<small>{{$global_data['project_data']['components']['shop']['currency']['symbol']}}</small>
                                            </s>
                                        </span>
                                @endif

                                <span style="font-size: 1.4rem">{{ $product->price['value']}}</span><small>{{$global_data['project_data']['components']['shop']['currency']['symbol']}}</small>

                            </div>
                        @endif


                    </div>

                </div>
            @endforeach
        </div>

    </div>

</div>