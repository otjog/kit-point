@extends('_kp.index')

@php
    $basket =& $global_data['shop']['basket'];
    $payments =& $global_data['shop']['payments'];
    $parcelData =& $global_data['shop']['parcelData'];
@endphp

@section('component')

    {{-- ALERT --}}
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{-- CONTENT --}}
    <div class="row">

        {{-- ORDER INFO --}}
        @if( isset( $basket->products ) && count( $basket->products ) > 0)
            <div class="col-md-4 order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Ваш заказ</span>
                    <span class="badge badge-secondary badge-pill">{{count($basket->products)}}</span>
                </h4>
                <ul class="list-group mb-3">

                    @foreach( $basket->products as $product )

                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <span class="my-0">
                                    {{ $product->name }}
                                </span>
                                <small class="text-muted">{{ $product->price['value'] }} x {{$product->quantity}}шт.</small>
                            </div>
                            <span class="ml-2">{{ $product->price['value'] * $product->quantity }}
                                <small>руб</small>
                            </span>
                        </li>

                    @endforeach

                    <li class="list-group-item d-flex justify-content-between bg-light">
                        <span>Сумма:</span>
                        <strong>{{ $basket->total }} <small>руб</small></strong>
                    </li>
                </ul>

            </div>

        @endif

        {{-- FORM --}}
        <div class="col-md-8 order-md-1">
            <h4 class="mb-3">Данные доставки</h4>
            <form role="form" action="{{ route('orders.store') }}" method="POST">

                <input type="hidden" name="_token" value="{{csrf_token()}}">

                {{-- FULL NAME --}}
                <div class="mb-3">
                    <label for="full_name">Фамилия Имя Отчество</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                        </div>
                        <input
                                type="text"
                                class="form-control"
                                id="full_name"
                                name="full_name"
                                placeholder="Иванов Петр Владимирович"
                                value=""
                                required=""
                                data-suggestion="NAME">
                        <!--input type="hidden" id="full_name_json" name="full_name_json"-->
                        <div class="invalid-feedback">
                            Пожалуйста, укажите ваше ФИО полностью
                        </div>
                    </div>
                </div>

                {{-- E-MAIL --}}
                <div class="mb-3">
                    <label for="email">Email</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                placeholder="you@mail.ru"
                                required=""
                                data-suggestion="EMAIL">
                        <div class="invalid-feedback" style="width: 100%;">
                            Пожалуйста, укажите корректный email
                        </div>
                    </div>
                </div>

                {{-- PHONE --}}
                <div class="mb-3">
                    <label for="phone">Телефон</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        </div>
                        <input
                                type="phone"
                                class="form-control"
                                id="phone"
                                name="phone"
                                placeholder="+79087830911"
                                required="">
                        <div class="invalid-feedback" style="width: 100%;">
                            Пожалуйста, укажите корректный телефонный номер
                        </div>
                    </div>
                </div>

                {{-- ADDRESS --}}
                <div class="mb-3">
                    <label for="address">Адрес доставки</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-marker"></i></span>
                        </div>
                        <input
                                type="text"
                                class="form-control"
                                id="address"
                                name="address"
                                placeholder="308011 г.Белгород ул.Садовая д.118"
                                required=""
                                data-suggestion="ADDRESS">
                        <!--input type="hidden" id="address_json" name="address_json"-->
                        <div class="invalid-feedback">
                            Пожалуйста, укажите корректный адрес
                        </div>
                    </div>
                </div>

                <hr class="mb-4">

                {{-- PAY & SHIPMENT --}}
                <div class="row">

                    {{-- PAYMENT --}}
                    @include($global_data['template']['name']. '.modules.shop.payment.index',
                                [
                                    'shipments' => $payments,
                                    'module' => ['template' =>'order']
                                ])

                    {{-- SHIPMENT --}}
                    @include($global_data['template']['name']. '.modules.shop.shipment.index',
                                [
                                    'shipments' => $global_data['modules']['shop.order.shipment.index'],
                                    'module' => ['template' =>'order']
                                ])

                </div>

                {{-- COMMENT --}}
                <div class="mb-3">
                    <label for="comment">Ваши пожелания</label>
                    <div class="input-group">
                        <textarea class="form-control" id="comment" name="comment"></textarea>
                    </div>
                </div>

                <hr class="mb-4">

                {{-- AGREEMENT --}}
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="agreeTerms" required>
                        <label class="form-check-label" for="agreeTerms">
                            Оформляя заказ я <a href="{{route('pages.show', '1')}}" target="_blank">даю согласие на обработку персональных данных</a> и <a href="{{route('pages.show', '2')}}" target="_blank">соглашаюсь с условиями обслуживания</a>
                        </label>
                        <div class="invalid-feedback">
                            Чтобы оформить заказ вы должны дать согласие на обработку персональных данных и согласиться с условиями обслуживания
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary btn-lg btn-block" type="submit">Оформить заказ</button>
            </form>
        </div>

    </div>

@endsection