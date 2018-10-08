@if(isset($categories) && count($categories) > 0)
    @switch($menu_type)
        @case('dropdown')   @include( $template_name .'.modules.menu.dropdown',   ['list' => $categories, 'path' => 'categories'])     @break
        @case('list')       @include( $template_name .'.modules.menu.list',       ['list' => $categories, 'path' => 'categories'])     @break
    @endswitch
@endif