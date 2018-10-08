<div class="product-list" id="product-list">
    <div class="container">

        <h1>Запчасти для котлов</h1>

        @if(isset($brands) && count($brands) > 0)

            @foreach($brands->chunk($components['shop']['chunk_category']) as $brands_row)

                <div class="card-group">

                    @foreach($brands_row as $key => $brand)

                        <div class="card rounded-0">
                            <div class="card-body px-2">
                                <a href="../brands/{{$brand->id}}">
                                    <img
                                            class="img-fluid mx-auto d-block"
                                            src="{{ URL::asset('storage/img/shop/brands/'.mb_strtolower($brand->name).'-logo.png') }}">

                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        @endif
    </div>
</div>