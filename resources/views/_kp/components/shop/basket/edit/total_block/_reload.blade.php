<div class="mb-3">
    <div class="h4">
        <span>Ваша корзина</span>
        <span class="badge badge-success p-1">{{ $basket->count_scu }}</span>
    </div>

</div>
<div class="row no-gutters">
    <div class="col-8 mb-3">
        Товары:
    </div>
    <div class="col-4 mb-3 text-right h5">
        {{ $basket->total + $basket->total_sale}}
        <small>{{$global_data['components']['shop']['currency']['symbol']}}</small>
    </div>
</div>

@if($basket->total_sale > 0)
    <div class="row no-gutters">
        <div class="col-8 mb-3">
            Скидка:
        </div>
        <div class="col-4 mb-3 text-right text-success font-weight-bold h5">
            {{ '-' . $basket->total_sale }}
            <small>{{$global_data['components']['shop']['currency']['symbol']}}</small>
        </div>
    </div>
@endif

<div class="row no-gutters border-top py-2">
    <div class="col-12">
            <span class="text-muted">
                Доступные способы и время доставки вы сможете выбрать при оформлении заказа
            </span>
    </div>
</div>

<div class="row no-gutters border-top pt-3">
    <div class="col-7 mb-3 h4">
        Итого к оплате:
    </div>
    <div class="col-5 mb-3 text-right h4">
        {{ $basket->total}}
        <small>{{$global_data['components']['shop']['currency']['symbol']}}</small>
    </div>
</div>
@if( $basket->total > 0)
    <a
            href="{{route('orders.create')}}"
            class="btn btn-danger btn-lg btn-block mt-1"
            type="submit">
        Перейти к оформлению
    </a>
@endif