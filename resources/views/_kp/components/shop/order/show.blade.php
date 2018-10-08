<div class="container">

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <h2>Номер заказа: {{$order->id}}-{{$order->shop_basket_id}}-{{strtotime($order->created_at)}} </h2>
    <div class="row">
        <div class="col-lg-6">
            Данные о покупателе:
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Имя: {{$order->customer->full_name}}</li>
                <li class="list-group-item">Телефон: {{$order->customer->phone}}</li>
                <li class="list-group-item">E-Mail: {{$order->customer->email}}</li>
                <li class="list-group-item">Адрес: {{$order->customer->address}}</li>
            </ul>
        </div>

        <div class="col-lg-6">
            Данные об оплате
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Способ оплаты: {{$order->payment->name}}</li>
                <li class="list-group-item">Статус оплаты: @if($order->paid) Оплачен @else Не оплачен @endif</li>
            </ul>
            Данные о доставке
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Способ доставки: {{$order->shipment->name}}</li>
                <li class="list-group-item">Адрес: {{$order->delivery_address}}</li>
                <li class="list-group-item">Статус доставки: </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            Данные о товарах в заказе:
            <div class="row no-gutters align-items-center my-2 border-bottom py-2 ">

                <div class="col-lg-2 py-1 px-2">
                    Изображение
                </div>

                <div class="col-lg-4">
                    Название
                </div>

                <div class="col-lg-2 text-center">
                    Цена
                </div>

                <div class="col-lg-2 text-center">
                    Количество
                </div>

                <div class="col-lg-2 text-center">
                    Стоимость
                </div>

            </div>

            @foreach($order->products as $product)

                <div class="row no-gutters align-items-center my-2 border-bottom py-2 ">

                    <div class="col-lg-1 py-1 px-2">
                        <img class="img-fluid mx-auto my-auto d-block" src="{{ URL::asset('storage/img/shop/product/thumbnail/'.$product->thumbnail) }}">
                    </div>

                    <div class="col-lg-5">
                        <a href="{{ route('products.show', $product->id) }}">
                            {{ $product->name }}
                        </a>
                        @if( isset($product->pivot['order_attributes_collection']) && count( $product->pivot['order_attributes_collection'] ) > 0)
                            <br>
                            @foreach($product->pivot['order_attributes_collection'] as $attribute)

                                <span class="text-muted small">

                                        {{$attribute->name}} : {{$attribute->pivot->value}}

                                </span>

                            @endforeach

                        @endif
                    </div>

                    <div class="col-lg-2 text-center">
                        <span class="text-muted">{{ $product->price['value'] }}</span>
                        <span class="text-muted small"><small>{{$components['shop']['currency']['symbol']}}</small></span>
                    </div>

                    <div class="col-lg-2 text-center">
                        <span class="text-muted">{{ $product->pivot['quantity'] }} шт.</span>
                    </div>

                    <div class="col-lg-2 text-center">
                        <span>{{ $product->price['value'] * $product->pivot['quantity'] }}</span>
                        <span class="small"><i class="fas fa-ruble-sign"></i></span>
                    </div>

                </div>

            @endforeach

            <div class="row no-gutters align-items-center my-2 border-bottom py-2 ">

                <div class="col-lg-10 text-right">
                    Сумма заказа
                </div>

                <div class="col-lg-2 text-center">
                    <span>{{ $order->total }}</span>
                    <span class="small"><i class="fas fa-ruble-sign"></i></span>
                </div>

            </div>

        </div>

    </div>
</div>