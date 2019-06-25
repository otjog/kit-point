@if(isset($menus) && $menus !== null)
    @foreach($menus as $menu)
        @if(isset($menu->models) && $menu->models !== null)
            @foreach($menu->models as $menu_model)
                <div class="col-lg-2 offset-lg-1">
                    <div class="footer_column">
                        <div class="footer_title">{{$menu_model['header']}}</div>
                        <ul class="footer_list">
                            @if(isset($menu_model[$menu_model->name]) && $menu_model[$menu_model->name] !== null)
                                @foreach($menu_model[$menu_model->name] as $item)
                                    <li><a href="{{Route($menu_model->name . '.show', $item['id'])}}">{{$item['name']}}</a></li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            @endforeach
        @endif
    @endforeach
@endif

