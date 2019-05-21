@if(isset($menus) && $menus !== null)
    @foreach($menus as $menu)
        <h3 class="side-heading">{{$menu['header']}}</h3>
        <div class="list-group categories">
            @if(isset($menu->models) && $menu->models !== null)
                @foreach($menu->models as $menu_model)
                    @if(isset($menu_model[$menu_model->name]) && $menu_model[$menu_model->name] !== null)
                        @foreach($menu_model[$menu_model->name] as $item)
                            <a href="{{Route($menu_model->name . '.show', $item['id'])}}" class="list-group-item">
                                <i class="fa fa-angle-right"></i>
                                {{$item['name']}}
                            </a>
                        @endforeach
                    @endif
                @endforeach
            @endif
        </div>
    @endforeach
@endif