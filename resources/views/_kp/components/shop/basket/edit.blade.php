@extends('_kp.index')

@section('component')

    <?php
        $basket =& $global_data['shop']['basket'];
    ?>

    @if( isset($basket->products) )
        <div class="row">
            <div class="col-12 col-lg-8">
                {{-- HEADER --}}
                @include( $global_data['template']['name']. '.components.shop.basket.edit.header')
                {{-- PRODUCT ROWS --}}
                @foreach($basket->products as $key => $product)
                    @include( $global_data['template']['name']. '.components.shop.basket.edit.product_row')
                @endforeach
            </div>
            {{-- TOTAL --}}
            <div class="col-12 col-lg-4 border-left rounded ">
                @include( $global_data['template']['name']. '.components.shop.basket.edit.total_block')
            </div>
        </div>
    @endif

@endsection