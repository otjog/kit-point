{{-- Top Bar --}}
<div class="top_bar d-none d-md-block">
    <div class="container">
        <div class="row">
            <div class="col d-flex flex-row">
                <div class="top_bar_contact_item">
                    <div class="top_bar_icon">
                        <img src="{{asset('storage/_kp/images/phone.png')}}" alt="">
                    </div>{{$global_data['info']['phone']}}
                </div>
                <div class="top_bar_contact_item">
                    <div class="top_bar_icon">
                        <img src="{{asset('storage/_kp/images/mail.png')}}" alt="">
                    </div>
                    <a href="mailto:{{$global_data['info']['email']}}">{{$global_data['info']['email']}}</a>
                </div>
                <div class="top_bar_contact_item">
                    <div class="top_bar_icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    @include($global_data['template']['name'] .'.modules.change-geo.header')
                </div>
                <div class="top_bar_content ml-auto">
                    <div class="top_bar_user">
                        <div class="user_icon"><img src="{{asset('storage/_kp/images/user.svg')}}" alt=""></div>
                        @guest
                            <div>
                                <a href="{{ route('register') }}">Регистрация</a>
                            </div>
                            <div>
                                <a href="{{ route('login') }}">Войти</a>
                            </div>
                        @else
                            <div>
                                {{ Auth::user()->full_name }} <span class="caret"></span>
                            </div>
                            <div>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    Выйти
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="top_bar top_bar_responsive d-md-none">
    <div class="container">
        <div class="row text-center">
            <div class="col">
                <div class="py-2">
                    <a href="/" class="text-muted"><i class="fas fa-home"></i></a>
                </div>
            </div>
            <div class="col">
                <div class="py-2">
                    <i class="fas fa-map-marker-alt"></i>
                    @include($global_data['template']['name'] .'.modules.change-geo.header')
                </div>
            </div>
            <div class="col">
                <div class="py-2">
                    @guest
                        <a href="{{ route('login') }}" class="text-muted"><i class="far fa-user"></i> Войти</a>
                    @else
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <i class="far fa-user"></i> Выйти
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>