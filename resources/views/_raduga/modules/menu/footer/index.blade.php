@if(isset($menus) && $menus !== null)
    @foreach($menus as $menu)
        <div class="col-lg-2 col-md-3 col-sm-3">
            <h5>{{$menu['header']}}</h5>
            <ul class="list-unstyled">
                @if(isset($menu->models) && $menu->models !== null)
                    @foreach($menu->models as $menu_model)
                        @foreach($menu_model[$menu_model->name] as $item)
                            <li>
                                <a href="{{Route($menu_model->name . '.show', $item['id'])}}">{{$item['name']}}</a>
                            </li>
                        @endforeach
                    @endforeach
                @endif
            </ul>
        </div>
    @endforeach
@endif