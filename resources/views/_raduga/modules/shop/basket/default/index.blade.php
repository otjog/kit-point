<div class="col-xl-3 col-md-4 col-sm-12">
    <div id="cart" class="btn-group btn-block">
        <button type="button" data-toggle="dropdown" class="btn btn-block dropdown-toggle text-center">
            <i class="fa fa-shopping-cart"></i>
            <span id="cart-total">

            {{ $basket->declesion or '0 товаров'}} - {{ $basket->total  or 0}}<small>{{$global_data['components']['shop']['currency']['symbol']}}</small></span>
            <i class="fa fa-caret-down"></i>
        </button>
        @if( isset($basket) && $basket !== null)
            <ul class="dropdown-menu dropdown-menu-right">

                <li>
                    <table class="table hcart text-light">

                        @foreach($basket->products as $product)
                            <tr>
                                <td class="text-center">
                                    <a href="{{ route( 'products.show', $product->id ) }}">

                                        @if( isset($product->images[0]->src) && $product->images[0]->src !== null )
                                            <img
                                                    class="img-fluid"
                                                    src="{{ URL::asset('storage/img/shop/product/xxs/' . $product->images[0]->src) }}"
                                                    alt="product"
                                            />
                                        @else
                                            <img
                                                    class="img-fluid"
                                                    src="{{ URL::asset('storage/img/shop/default/xxs/' . $global_data['components']['shop']['images']['default_name']) }}"
                                                    alt="product"
                                            />
                                        @endif

                                    </a>
                                </td>
                                <td class="text-left">
                                    <a href="{{ route( 'products.show', $product->id ) }}">
                                        <small>
                                            @isset($product->manufacturer['name'])
                                                {{ $product->manufacturer['name'] . ' ' }}
                                            @endisset
                                            {{ $product->name }}
                                            @if( isset($product->brands) && count($product->brands) > 0 && $product->brands !== null)
                                                @foreach($product->brands as $brand)
                                                    {{ ' | ' . $brand->name}}
                                                @endforeach
                                            @endif
                                        </small>
                                    </a>
                                </td>
                                <td class="text-right"><small>{{$product->quantity}}шт.</small></td>
                                <td class="text-right">
                                    @if( isset($product->price['value']) && $product->price['value'] !== null)
                                        <small>
                                            {{ $product->price['value']}}{{$global_data['components']['shop']['currency']['symbol']}}
                                        </small>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </li>
                <li>
                    <table class="table table-bordered total text-light">
                        <tbody>
                        <tr>
                            <td class="text-right"><strong>Итого:</strong></td>
                            <td class="text-left">
                                {{$basket->total}}
                                <small>
                                    {{$global_data['components']['shop']['currency']['symbol']}}
                                </small>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <p class="text-right btn-block1">
                        <a href="{{route('baskets.edit', csrf_token())}}">
                            Перейти к оформлению
                        </a>
                    </p>
                </li>
            </ul>
        @endif
    </div>
</div>