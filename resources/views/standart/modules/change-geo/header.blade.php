<a href="#" class="geo-location-link text-primary border-bottom-dotted" data-toggle="modal" data-target="#change-city-form">
    @if(isset($global_data['project_data']['geo']['city_name']) && $global_data['project_data']['geo']['city_name'] !== null)
        <span class="city_type">
                @isset($global_data['project_data']['geo']['city_type']){{$global_data['project_data']['geo']['city_type'] . ' '}}@endif
        </span>
        <span class="city_name">{{$global_data['project_data']['geo']['city_name'] . ' '}}</span>
    @else
        Выберите город доставки
    @endif
</a>