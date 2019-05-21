<div class="col-lg-3">

    @if (isset($filters) && count($filters) > 0 )
        <div class="product-filter px-4">
            <form name="product_filter" role="form" method="GET">

                @foreach ($filters as $filter)

                    @php

                        $routeAlias = key($routeData);
                        $routeValue = $routeData[ key($routeData) ];
                        $filterPrefix = $global_data['project_data']['components']['shop']['filter_prefix'];

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
                        <div class="mx-1 pt-1 border-bottom filter filter-{{$filter['alias']}} filter-{{$filter['type']}} @if($filter['type'] === 'slider-range')filter-slider @endif">

                        <div class="filter-header my-2">
                            <span>
                                <a
                                        class="collapsed"
                                        data-toggle="collapse"
                                        data-target="#collapse-{{$filter['alias']}}"
                                        aria-expanded="{{$filter['expanded']}}"
                                        aria-controls="collapse-{{$filter['alias']}}">

                                    {{$filter['name']}}

                                    <span class="pl-1">
                                        <i class="fas fa-angle-down collapse-arrow-down"></i>
                                        <i class="fas fa-angle-up collapse-arrow-up"></i>
                                    </span>
                            </a>
                            </span>
                            <small class="filter-clear float-right">Очистить</small>
                        </div>
                        <div class="collapse pb-3 @if($filter['expanded'] === 'true') show @endif"  id="collapse-{{$filter['alias']}}">
                            @include( $global_data['project_data']['template_name'] .'.modules.product_filter.elements.'.$filter['type'], [$filter])
                        </div>

                    </div>
                    @endif

                @endforeach

            <!-- Filter's Button -->
                @include( $global_data['project_data']['template_name'] .'.modules.product_filter.elements.button')

            </form>
        </div>
    @endif

</div>