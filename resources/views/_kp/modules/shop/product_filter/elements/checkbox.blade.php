<div class="row">
    @foreach($filter['values'] as $id =>$value)
        <div class="col-6">
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
    @endforeach
</div>