<div class="product-filter d-block d-md-none pt-2">
    <div>
        <a
                class="border-bottom-dotted"
                data-toggle="collapse"
                href="#product-filter-responsive"
                role="button"
                aria-expanded="false"
                aria-controls="product-filter-responsive">
            <i class="fas fa-funnel-dollar"></i>
            Фильтр товаров
        </a>
    </div>

    @if (isset($filters) && count($filters) > 0 )
        <div class="accordion collapse multi-collapse" id="product-filter-responsive">
            <div class="text-right pb-2">
                <span class="filter-clear border-bottom-dotted">Очистить всё</span>
            </div>
            <form name="product_filter" role="form" method="GET">

                @foreach ($filters as $filter)

                    @php
                        $routeAlias = key($routeData);
                        $routeValue = $routeData[ key($routeData) ];
                        $filterPrefix = $global_data['components']['shop']['filter_prefix'];

                    @endphp

                    @if ($filter['alias'] === $routeAlias)
                        <input
                                type="hidden"
                                name="{{ $routeAlias }}"
                                value="{{ $routeValue }}"
                                data-filter-name="{{ $routeAlias  }}"
                                data-filter-type="hidden"
                                data-filter-value="{{ $routeValue }}">
                    @elseif($filter['alias'] === $filterPrefix . $routeAlias)
                        <input
                                type="hidden"
                                name="{{ $filterPrefix . $routeAlias }}"
                                value="{{ $routeValue }}"
                                data-filter-name="{{ $filterPrefix . $routeAlias }}"
                                data-filter-type="hidden"
                                data-filter-value="{{ $routeValue }}">
                    @else
                        <div class="card rounded-0 filter filter-{{$filter['alias']}} filter-{{$filter['type']}} @if($filter['type'] === 'slider-range')filter-slider @endif">
                            <div class="card-header p-1" id="heading-{{$filter['alias']}}">

                                <button
                                        class="btn btn-link w-75 text-left collapsed"
                                        type="button"
                                        data-toggle="collapse"
                                        data-target="#collapse-{{$filter['alias']}}"
                                        aria-expanded="false"
                                        aria-controls="collapse-{{$filter['alias']}}"
                                >
                                        {{$filter['name']}}
                                    </button>
                                <span class="filter-clear border-bottom-dotted float-right">Очистить</span>

                            </div>

                            <div id="collapse-{{$filter['alias']}}" class="collapse" aria-labelledby="heading-{{$filter['alias']}}" data-parent="#product-filter-responsive">
                                <div class="card-body">
                                    <div class="container">
                                        @include( $global_data['template']['name'] .'.modules.shop.product_filter.elements.'.$filter['type'], [$filter])
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                @endforeach

                {{-- Filter's Button --}}
                @include( $global_data['template']['name'] .'.modules.shop.product_filter.elements.button')

            </form>

            <div class="text-center pb-3">
                <a
                        class="border-bottom-dotted"
                        data-toggle="collapse"
                        href="#product-filter-responsive"
                        role="button"
                        aria-expanded="false"
                        aria-controls="product-filter-responsive">
                    Скрыть фильтр
                </a>
            </div>

        </div>

    @endif
</div>