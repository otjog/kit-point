@foreach($filter['values'] as $id =>$value)
    @if($loop->index%2 == 0 || $loop->index == 0)
        <div class="row">
            @endif
            <div class="col-md-6">
                <label class="small">
                    <input
                            type="checkbox"
                            name="{{$filter['alias']}}[{{$id}}]"
                            data-filter-type="{{$filter['type']}}"
                            data-filter-value="{{$id}}"
                            data-filter-name="{{$filter['alias']}}"
                            @php
                                if(isset($filter['old_values']) && in_array($id, $filter['old_values']))
                                    echo 'checked';
                            @endphp
                    />
                    {{$value}}
                </label>
            </div>
            @if(($loop->index+1)%2 == 0 || ($loop->index+1) == count($filter['values']))
        </div>
    @endif
@endforeach