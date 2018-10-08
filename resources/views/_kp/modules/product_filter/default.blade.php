<div class="col-lg-3">

    @if( isset( $filters ) && count( $filters ) > 0 )
        <div class="product-filter my-4 px-4 pt-2">
            <form name="product_filter" role="form" method="GET">

                <input

                        type="hidden"
                        name="{{key( $route_value )}}"
                        value="{{ $route_value[ key( $route_value ) ] }}"
                        data-filter-name="{{key( $route_value )}}"
                        data-filter-type="hidden"
                        data-filter-value="{{ $route_value[ key( $route_value ) ] }}">

                <strong>Фильтр</strong>
                @foreach($filters as $filter)
                    <div class="mb-3 pb-3  mt-1 pt-1 border-bottom filter filter-{{$filter['alias']}} filter-{{$filter['type']}} @if($filter['type'] === 'slider-range')filter-slider @endif">

                        <div class="filter-header my-2">
                            <span>{{$filter['name']}}</span>
                            <small class="filter-clear float-right">Очистить</small>
                        </div>

                        @include( $template_name .'.modules.product_filter.elements.'.$filter['type'], [$filter])

                    </div>
                @endforeach

            <!-- Filter's Button -->
                @include( $template_name .'.modules.product_filter.elements.button')

            </form>
        </div>
    @endif

</div>