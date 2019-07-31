<div>
    @if(isset($global_data['geo']['city_name']) && $global_data['geo']['city_name'] !== null)
        Способы доставки в
        <a href="#" class="geo-location-link border-bottom-dotted " data-toggle="modal" data-target="#change-city-form">
            <span class="city_type">
                @isset($global_data['geo']['city_type']){{$global_data['geo']['city_type'] . ' '}}@endif
            </span>
            <span class="city_name">{{$global_data['geo']['city_name'] . ' '}}</span>
            (
            <span class="region_name">
                @isset($global_data['geo']['city_type']){{$global_data['geo']['region_name'] . ' '}}@endif
            </span>
            <span class="region_type">
                @isset($global_data['geo']['city_type']){{$global_data['geo']['region_type'] . ' '}}@endif
            </span>
            )
        </a>

    @else
        Выберите
        <a href="#" class="geo-location-link border-bottom-dotted " data-toggle="modal" data-target="#change-city-form">
            город доставки
        </a>

    @endif
    <br>
    <span class="text-muted small">(Можете указать адрес до улицы или номера дома, чтобы увидеть ближайшие пункты выдачи)</span>
</div>