<div class="header_main">
    <div class="container">
        <div class="row">

            <!-- Logo -->
            <div class="col-lg-3 col-sm-3 col-6 order-1">
                @include( $template_name .'.modules.logo.default')
            </div>

            <!-- Search -->
            <div class="col-lg-6 col-12 order-lg-2 order-3 text-lg-left text-right">
                @include( $template_name .'.modules.search.default')
            </div>

            <!-- Cart -->
            <div class="col-lg-3 col-6 order-lg-3 order-2 text-lg-left text-right">
                @include( $template_name .'.modules.shop_basket.default')
            </div>

        </div>
    </div>
</div>