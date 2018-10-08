<select multiple class="form-control"
        name="{{$filter['alias']}}[{{$filter['id']}}]"
        data-filter-type="{{$filter['type']}}"
        data-filter-name="{{$filter['alias']}}"
>
    @foreach($filter['values'] as $id =>$value)

        <option
                value="{{$value}}"
                data-filter-value="{{$value}}"
            @php
                if(isset($filter['old_values']) && in_array($id, $filter['old_values']))
                    echo 'selected';
            @endphp
            >
            {{$value}}
            </option>
    @endforeach

</select>