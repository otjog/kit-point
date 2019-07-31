<div style="width: 300px">
    <h6>{{$point['title']}}</h6>
    <div><strong>{{$point['address']}}</strong></div>
    <hr class="my-2">
    <div class="container">
        <div class="row">
            <div class="col-6">
                <ul>
                    @foreach($point['timeTable'] as $dayTimeTable)
                        <li>
                            @if($dayTimeTable['day'] !== 'Сб' && $dayTimeTable['day'] !== 'Вс')
                                <span class="badge badge-warning">{{$dayTimeTable['day']}}</span>
                            @else
                                <span class="badge badge-info">{{$dayTimeTable['day']}}</span>
                            @endif
                            <span> : </span>
                            <span>{{$dayTimeTable['time']}}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-6">
                @if(isset($point['options']))
                    <ul>
                        @foreach($point['options'] as $option)
                            <li>
                                <small>{{$option['desc']}}</small>
                                @isset($option['params'])
                                    <ul>
                                        @foreach($option['params'] as $key=>$param)
                                            <li>
                                                @if(is_string($key))
                                                    <small>{{ ' - ' . $key . ' : ' . $param}}</small>
                                                @else
                                                    <small>{{ ' - ' . $param}}</small>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endisset
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>