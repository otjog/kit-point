@if(isset($menu_model[$menu_model->name]) && $menu_model[$menu_model->name] !== null)
    @foreach($menu_model[$menu_model->name] as $item)
        <li class="nav-item"><a href="{{Route($menu_model->name . '.show', $item['id'])}}" class="nav-link">{{$item['name']}}</a></li>
    @endforeach
@endif