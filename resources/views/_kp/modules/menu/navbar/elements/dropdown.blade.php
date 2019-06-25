<!-- Categories Menu -->
<div class="cat_menu_container">
    <div class="cat_menu_title d-flex flex-row align-items-center justify-content-start">
        <div class="cat_burger"><span></span><span></span><span></span></div>
        <div class="cat_menu_text">{{$menu_model->header}}</div>
    </div>

    <ul class="cat_menu">

        @if(isset($menu_model[$menu_model->name]) && $menu_model[$menu_model->name] !== null)
            @foreach($menu_model[$menu_model->name] as $item)
                <li><a href="{{Route($menu_model->name . '.show', $item['id'])}}">{{$item['name']}} <i class="fas fa-chevron-right ml-auto"></i></a></li>
            @endforeach
        @endif
    </ul>
</div>