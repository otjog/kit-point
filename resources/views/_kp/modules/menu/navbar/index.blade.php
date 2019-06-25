 <!-- Main Navigation -->
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

                        <!-- Menu Trigger -->
                            <div class="menu_trigger_container ml-auto">
                                <div class="menu_trigger d-flex flex-row align-items-center justify-content-end">
                                    <div class="menu_burger">
                                        <div class="menu_trigger_text">menu</div>
                                        <div class="cat_burger menu_burger_inner"><span></span><span></span><span></span></div>
                                    </div>
                                </div>
                            </div>
                    @endif

                    </div>
                </div>
            </div>
        </div>
    </nav>