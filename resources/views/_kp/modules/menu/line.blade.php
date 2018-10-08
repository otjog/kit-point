<div class="main_nav_menu ml-auto">
    <ul class="standard_dropdown main_nav_dropdown">
        @foreach($list as $item)
            <li><a href="{{route( $path.'.show', $item['id'] )}}">{{ $item['name'] }}<i class="fas fa-chevron-down"></i></a></li>
        @endforeach
    </ul>
</div>