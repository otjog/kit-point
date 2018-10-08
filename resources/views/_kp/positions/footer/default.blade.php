<div class="container">
    <div class="row">

        <div class="col-lg-3 footer_col">
            <div class="footer_column footer_contact">
                <div class="footer_title">Остались вопросы? Звоните нам!</div>
                <div class="footer_phone">{{$info['phone']}}</div>
                <div class="footer_contact_text pr-5">
                    <small class="text-muted">{{$info['address']}}</small>
                </div>
                <!--div class="footer_social">
                    <ul>
                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                        <li><a href="#"><i class="fab fa-google"></i></a></li>
                        <li><a href="#"><i class="fab fa-vimeo-v"></i></a></li>
                    </ul>
                </div-->
            </div>
        </div>

        <div class="col-lg-2 offset-lg-4">
            <div class="footer_column">
                <div class="footer_title">Найди, то что нужно</div>

                @include( $template_name .'.modules.menu.shop', ['menu_type' => 'list'])

            </div>
        </div>

        <div class="col-lg-2 offset-lg-1">
            <div class="footer_column">
                <div class="footer_title">Информация</div>

                @include( $template_name .'.modules.menu.page', ['menu_type' => 'list', 'menu_name' => 'info'])

                {{-- @include( $template_name .'modules.menu.page', ['menu_type' => 'list', 'menu_name' => 'about_us']) --}}

            </div>
        </div>

    </div>
</div>