{{-- Main Nav Menu --}}
<div class="main_nav_menu ml-auto">
    <ul class="standard_dropdown main_nav_dropdown">
        @if(isset($menu_model[$menu_model->name]) && $menu_model[$menu_model->name] !== null)
            @foreach($menu_model[$menu_model->name] as $item)
                <li><a href="{{Route($menu_model->name . '.show', $item['id'])}}">{{$item['name']}}<i class="fas fa-chevron-down"></i></a></li>
            @endforeach
        @endif
    </ul>
</div>