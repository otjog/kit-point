<?php
    $data =& $global_data;
    $order =& $global_data['order'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
    <body>
        <p>
            {{$order->comment}}
        </p>
        <table
                border="3"
                cellpadding="0"
                cellspacing="0"
                width="100%"
                bordercolor="#cccccc"
                style="
                    margin:0;
                    padding:0"
        >
            <tr>
                <td
                        colspan="2"
                        height="100%"
                        width="50%"
                        bgcolor="#cccccc"
                        style="padding-left: 10px;"
                >
                    <span style="color: #333333; font: 12px Arial, sans-serif; line-height: 30px; -webkit-text-size-adjust:none; display: block;">
                        <b>Данные покупателя</b>
                    </span>
                </td>
                <td
                        colspan="2"
                        height="100%"
                        width="50%"
                        bgcolor="#cccccc"
                        style="padding-left: 10px;"
                >
                    <span style="color: #333333; font: 12px Arial, sans-serif; line-height: 30px; -webkit-text-size-adjust:none; display: block;">
                        <b>Данные заказа</b>
                    </span>
                </td>
            </tr>
            <tr>
                <td
                        height="100%"
                        width="10%"
                        style="padding-left: 10px;"
                >
                    <span style="color: #333333; font: 10px Arial, sans-serif; line-height: 30px; -webkit-text-size-adjust:none; display: block;">
                        <b>Имя</b>
                    </span>
                </td>
                <td
                        height="100%"
                        width="40%"
                        style="padding-left: 10px;"
                >
                    <span style="color: #333333; font: 10px Arial, sans-serif; line-height: 30px; -webkit-text-size-adjust:none; display: block;">{{$order->customer->full_name}}</span>
                </td>
                <td
                        height="100%"
                        width="10%"
                        style="padding-left: 10px;"
                >
                    <span style="color: #333333; font: 10px Arial, sans-serif; line-height: 30px; -webkit-text-size-adjust:none; display: block;">
                        <b>Способ оплаты</b>
                    </span>
                </td>
                <td
                        height="100%"
                        width="40%"
                        style="padding-left: 10px;"
                >
                    <span style="color: #333333; font: 10px Arial, sans-serif; line-height: 30px; -webkit-text-size-adjust:none; display: block;">{{$order->payment->name}}</span>
                </td>
            </tr>
            <tr>
                <td
                        height="100%"
                        width="10%"
                        style="padding-left: 10px;">
                    <span style="color: #333333; font: 10px Arial, sans-serif; line-height: 30px; -webkit-text-size-adjust:none; display: block;">
                        <b>Телефон</b>
                    </span>
                </td>
                <td
                        height="100%"
                        width="40%"
                        style="padding-left: 10px;"
                >
                    <span style="color: #333333; font: 10px Arial, sans-serif; line-height: 30px; -webkit-text-size-adjust:none; display: block;">{{$order->customer->phone}}</span>
                </td>
                <td
                        height="100%"
                        width="10%"
                        style="padding-left: 10px;"
                >
                    <span style="color: #333333; font: 10px Arial, sans-serif; line-height: 30px; -webkit-text-size-adjust:none; display: block;">
                        <b>Статус оплаты</b>
                    </span>
                </td>
                <td
                        height="100%"
                        width="40%"
                        style="padding-left: 10px;"
                >
                    <span style="color: #333333; font: 10px Arial, sans-serif; line-height: 30px; -webkit-text-size-adjust:none; display: block;">
                        @if($order->paid) Оплачен @else Не оплачен @endif
                    </span>
                </td>
            </tr>
            <tr>
                <td
                        height="100%"
                        width="10%"
                        style="padding-left: 10px;"
                >
                    <span style="color: #333333; font: 10px Arial, sans-serif; line-height: 30px; -webkit-text-size-adjust:none; display: block;">
                        <b>E-mail</b>
                    </span>
                </td>
                <td
                        height="100%"
                        width="40%"
                        style="padding-left: 10px;"
                >
                    <span style="color: #333333; font: 10px Arial, sans-serif; line-height: 30px; -webkit-text-size-adjust:none; display: block;">{{$order->customer->email}}</span>
                </td>
                <td
                        height="100%"
                        width="10%"
                        style="padding-left: 10px;"
                >
                    <span style="color: #333333; font: 10px Arial, sans-serif; line-height: 30px; -webkit-text-size-adjust:none; display: block;">
                        <b>Способ доставки</b>
                    </span>
                </td>
                <td
                        height="100%"
                        width="40%"
                        style="padding-left: 10px;"
                >
                    <span style="color: #333333; font: 10px Arial, sans-serif; line-height: 30px; -webkit-text-size-adjust:none; display: block;">{{$order->shipment->name}}</span>
                </td>
            </tr>
            <tr>
                <td
                        height="100%"
                        width="10%"
                        style="padding-left: 10px;"
                >
                    <span style="color: #333333; font: 10px Arial, sans-serif; line-height: 30px; -webkit-text-size-adjust:none; display: block;">
                        <b>Адрес</b>
                    </span>
                </td>
                <td
                        height="100%"
                        width="40%"
                        style="padding-left: 10px;"
                >
                    <span style="color: #333333; font: 10px Arial, sans-serif; line-height: 30px; -webkit-text-size-adjust:none; display: block;">{{$order->customer->address}}</span>
                </td>
                <td
                        height="100%"
                        width="10%"
                        style="padding-left: 10px;"
                >
                    <span style="color: #333333; font: 10px Arial, sans-serif; line-height: 30px; -webkit-text-size-adjust:none; display: block;">
                        <b>Адрес доставки</b>
                    </span>
                </td>
                <td
                        height="100%"
                        width="40%"
                        style="padding-left: 10px;"
                >
                    <span style="color: #333333; font: 10px Arial, sans-serif; line-height: 30px; -webkit-text-size-adjust:none; display: block;">{{$order->delivery_address}}</span>
                </td>
            </tr>
        </table>

        <table
                border="3"
                cellpadding="0"
                cellspacing="0"
                width="100%"
                bordercolor="#cccccc"
                style="
                    margin:0;
                    padding:0"
        >
            <tr>
                <td
                        colspan="5"
                        height="100%"
                        bgcolor="#cccccc"
                        style="padding-left: 10px;"
                >
                <span style="color: #333333; font: 12px Arial, sans-serif; line-height: 30px; -webkit-text-size-adjust:none; display: block;">
                <b>Товары</b>
                </span></td>
            </tr>
            <tr>
                <td
                        height="100%"
                        bgcolor="#eeeeee"
                        align="center"
                        style="
                            padding: 5px;"
                >
                    <span
                            style="
                                color: #333333;
                                font: 10px Arial, sans-serif;
                                line-height: 30px;
                                -webkit-text-size-adjust:none;
                                display: block;">
                        <b>Изображение</b>
                    </span>
                </td>
                <td
                        height="100%"
                        bgcolor="#eeeeee"
                        align="center"
                        style="
                            padding: 5px;"
                >
                    <span
                            style="
                                color: #333333;
                                font: 10px Arial, sans-serif;
                                line-height: 30px;
                                -webkit-text-size-adjust:none;
                                display: block;">
                        <b>Название</b>
                    </span>
                </td>
                <td
                        height="100%"
                        bgcolor="#eeeeee"
                        align="center"
                        style="
                            padding: 5px;"
                >
                    <span
                            style="
                                color: #333333;
                                font: 10px Arial, sans-serif;
                                line-height: 30px;
                                -webkit-text-size-adjust:none;
                                display: block;">
                        <b></b>
                    </span>
                </td>
                <td
                        height="100%"
                        bgcolor="#eeeeee"
                        align="center"
                        style="
                            padding: 5px;"
                >
                    <span
                            style="
                                color: #333333;
                                font: 10px Arial, sans-serif;
                                line-height: 30px;
                                -webkit-text-size-adjust:none;
                                display: block;">
                        <b>Количество</b>
                    </span>
                </td>
                <td
                        height="100%"
                        bgcolor="#eeeeee"
                        align="center"
                        style="
                            padding: 5px;"
                >
                    <span
                            style="
                                color: #333333;
                                font: 10px Arial, sans-serif;
                                line-height: 30px;
                                -webkit-text-size-adjust:none;
                                display: block;">
                        <b>Стоимость</b>
                    </span>
                </td>
            </tr>

            @foreach($order->products as $product)
                <tr>
                    <td
                            height="100%"
                            align="center"
                    >
                        @if( isset($product->images[0]->name) && $product->images[0]->name !== null )
                            <img
                                    src="{{ $message->embed(public_path('storage/img/shop/product/xs/' . $product->images[0]->name)) }}"
                                    alt=""
                                    border="0"
                                    width="130" {{-- менять самостоятельно, при смене в ссылке --}}
                                    height="130" {{-- менять самостоятельно, при смене в ссылке --}}
                                    style="display:block;"
                            />
                        @endif
                    </td>
                    <td
                            height="100%"
                            align="center"
                    >
                        <a
                                href="{{ route('products.show', $product->id) }}"
                                style="color: #333333; font: 10px Arial, sans-serif; line-height: 30px; -webkit-text-size-adjust:none; display: block;" target="_blank"
                        >
                            {{ $product->name }}
                            @if( isset($product->pivot['order_attributes_collection']) && count( $product->pivot['order_attributes_collection'] ) > 0)

                                @foreach($product->pivot['order_attributes_collection'] as $attribute)
                                    {{' ' .$attribute->name}} : {{$attribute->pivot->value}}
                                @endforeach

                            @endif
                        </a>

                    </td>
                    <td
                            height="100%"
                            align="center"
                    >
                        <span style="color: #333333; font: 10px Arial, sans-serif; line-height: 30px; -webkit-text-size-adjust:none; display: block;">
                        {{ $product->price['value'] . ' ' . $data['components']['shop']['currency']['symbol']}}
                    </span>
                    </td>
                    <td
                            height="100%"
                            align="center"
                    >
                        <span style="color: #333333; font: 10px Arial, sans-serif; line-height: 30px; -webkit-text-size-adjust:none; display: block;">
                        {{ $product->pivot['quantity'] }} шт.
                    </span>
                    </td>
                    <td
                            height="100%"
                            align="center"
                    >
                        <span
                                style="
                                    color: #333333;
                                    font: 10px Arial, sans-serif;
                                    line-height: 30px;
                                    -webkit-text-size-adjust:none;
                                    display: block;"
                        >
                        {{ $product->price['value'] * $product->pivot['quantity'] . ' ' . $data['components']['shop']['currency']['symbol']}}
                    </span>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td
                        colspan="4"
                        height="100%"
                        align="right"
                        style="padding-right: 10px"
                >
                    <span
                            style="
                                color: #333333;
                                font: 12px Arial, sans-serif;
                                line-height: 30px;
                                -webkit-text-size-adjust:none;
                                display: block;">
                        <b>Сумма заказа</b>
                    </span>
                </td>
                <td
                        height="100%"
                        style="padding-left: 10px"
                >
                <span
                        style="
                            color: #333333;
                            font: 12px Arial, sans-serif;
                            line-height: 30px;
                            -webkit-text-size-adjust:none;
                            display: block;"
                >
                    <b>{{ $order->total . " " . $data['components']['shop']['currency']['symbol']}}</b>
                </span></td>
            </tr>

        </table>

    </body>
</html>
