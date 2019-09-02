 {{-- Main Navigation --}}
    <nav class="main_nav">
        <div class="container">
            <div class="row">
                <div class="col">

                    <div class="main_nav_content d-flex flex-row">

                    @if(isset($menus) && $menus !== null)
                        @foreach($menus as $menu)
                            @if(isset($menu->models) && $menu->models !== null)
                                @foreach($menu->models as $menu_model)
                                    @include('_kp.modules.menu.navbar.elements.' . $menu_model->view)
                                @endforeach
                            @endif
                        @endforeach
                    @endif

                    </div>
                </div>
            </div>
        </div>
    </nav>