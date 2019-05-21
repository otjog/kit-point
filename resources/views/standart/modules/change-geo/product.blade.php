@if(isset($global_data['project_data']['geo']['city_name']) && $global_data['project_data']['geo']['city_name'] !== null)
    <div>Способы доставки в
        <a href="#" class="geo-location-link border-bottom-dotted " data-toggle="modal" data-target="#change-city-form">
            <span class="city_type">
                @isset($global_data['project_data']['geo']['city_type']){{$global_data['project_data']['geo']['city_type'] . ' '}}@endif
            </span>
            <span class="city_name">{{$global_data['project_data']['geo']['city_name'] . ' '}}</span>
            (
            <span class="region_name">
                @isset($global_data['project_data']['geo']['city_type']){{$global_data['project_data']['geo']['region_name'] . ' '}}@endif
            </span>
            <span class="region_type">
                @isset($global_data['project_data']['geo']['city_type']){{$global_data['project_data']['geo']['region_type'] . ' '}}@endif
            </span>
            )
        </a>
    </div>
@else
    <div>Выберите
        <a href="#" class="geo-location-link border-bottom-dotted " data-toggle="modal" data-target="#change-city-form">
            город доставки
        </a>
    </div>
@endif