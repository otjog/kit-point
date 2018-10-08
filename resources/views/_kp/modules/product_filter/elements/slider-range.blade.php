@php
    $values = array(
        'static'    => $filter['values'],
        'dynamic'   => []
    );

    if( isset( $filter['old_values'] ) && count($filter['old_values'] ) > 0 ){
        $values['dynamic'] = $filter['old_values'];
    }else{
        $values['dynamic'] = $values['static'];
    }
@endphp

<div class="row">
    @for($i = 0; $i < 2; $i++)
        <div class="col-6">
            @if(!$i)
                <span>От:</span>
            @else
                <span>до:</span>
            @endif
            <input
                    class="py-2 pl-3 border rounded"
                    type="text"
                    min="{{$values['static'][0]}}"
                    max="{{$values['static'][1]}}"
                    value="{{$values['dynamic'][$i]}}"
                    name="{{$filter['alias']}}[ {{$i}} ]"
                    size="6"
                    data-filter-type="slider"
                    data-filter-slider-input-index="0"
                    data-filter-default-value="{{$values['static'][$i]}}"
                    data-filter-name="{{$filter['alias']}}"
            />
        </div>
    @endfor
</div>
<div class="slider-show my-2"></div>