@if( isset( $menus[$menu_name] ) && count( $menus[$menu_name] ) > 0 )
    @switch($menu_type)

        @case('line')   @include( $template_name .'.modules.menu.line', ['list' => $menus[$menu_name], 'path' => 'pages']) @break

        @case('list')   @include( $template_name .'.modules.menu.list', ['list' => $menus[$menu_name], 'path' => 'pages']) @break

    @endswitch
@endif