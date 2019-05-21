
    <!-- Top Bar -->
    <div class="top_bar">
        <div class="container">
            <div class="row">
                <div class="col d-flex flex-row">
                    <div class="top_bar_contact_item">
                        <div class="top_bar_icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>{{$global_data['project_data']['info']['phone']}}
                    </div>
                    <div class="top_bar_contact_item">
                        <div class="top_bar_icon">
                            <i class="far fa-envelope"></i>
                        </div>
                        {{$global_data['project_data']['info']['email']}}
                    </div>
                </div>
                <div class="col d-flex flex-row">
                    <div class="top_bar_contact_item">
                        <div class="top_bar_icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        @include($global_data['project_data']['template_name'] .'.modules.change-geo.header')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Main -->
    <div class="header_main">
        <div class="container">
            <div class="row">

                <!-- Logo -->
                <div class="col-lg-3 col-sm-3 col-6 order-1">
                    @include( $global_data['project_data']['template_name'] .'.modules.logo.default')
                </div>

                <!-- Search -->
                <div class="col-lg-6 col-12 order-lg-2 order-3 text-lg-left text-right">
                    @include( $global_data['project_data']['template_name'] .'.modules.search.default')
                </div>

                <!-- Cart -->
                <div class="col-lg-3 col-6 order-lg-3 order-2 text-lg-left text-right">
                    @include( $global_data['project_data']['template_name'] .'.modules.shop_basket.default')
                </div>

            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="main_nav">
        <div class="container">
            <div class="row">
                <div class="col-12">

                    <div class="main_nav_content d-flex flex-row">

                        <!-- Categories Menu -->
                    @include( $global_data['project_data']['template_name'] .'.modules.menu.shop', ['menu_type' => 'dropdown'])

                    <!-- Main Nav Menu -->
                        @include( $global_data['project_data']['template_name'] .'.modules.menu.page', ['menu_type' => 'line', 'menu_name' => 'top_menu'])

                    </div>
                </div>
            </div>
        </div>
    </nav>

