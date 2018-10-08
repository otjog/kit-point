@if( isset( $banner->data ) && $banner->data !== null)
    @if($banner->img !== null)
        <div class="banner_background" style="background-image:url({{ URL::asset('storage/img/banners/' . $banner->img) }})"></div>
    @endif

    <div class="container fill_height">
        <div class="row fill_height">
            <div class="banner_product_image"><img class="float left img-fluid" src="{{ URL::asset('storage/img/banners/shop/products/' . $banner->data->id . '.png') }}" alt=""></div>
            <div class="col-lg-5 offset-lg-4 fill_height">
                <div class="banner_content">

                    @if($banner->title !== null)
                        <h2 class="banner_text">{{$banner->title}}</h2>
                    @endif
                    <div class="banner_price">

                        @if( isset($banner->data->price['sale']) && $banner->data->price['sale'] > 0)
                            <span>
                            {{$banner->data->price['value'] + $banner->data->price['sale']}}<small>{{$components['shop']['currency']['symbol']}}</small>
                        </span>
                        @endif
                        {{$banner->data->price['value']}}<small>{{$components['shop']['currency']['symbol']}}</small>
                    </div>
                    <div class="banner_product_name ">{{$banner->data->name}}</div>
                    <div class="button banner_button"><a href="{{ route('products.show', $banner->data->id) }}">Купить сейчас</a></div>
                </div>
            </div>
        </div>
    </div>
@endif