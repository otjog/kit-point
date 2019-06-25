<!-- Top Bar -->
<div class="top_bar">
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
            </div>
        </div>
    </div>
</div>