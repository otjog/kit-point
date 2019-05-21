<li class="nav-item dropdown">
    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
        {{$menu_model->header}}
    </a>

    @if(isset($menu_model[$menu_model->name]) && $menu_model[$menu_model->name] !== null)
        <div class="dropdown-menu rounded-0">
            @foreach($menu_model[$menu_model->name] as $item)
                <a href="{{Route($menu_model->name . '.show', $item['id'])}}" class="dropdown-item">{{$item['name']}}</a>
            @endforeach
        </div>
    @endif
</li>