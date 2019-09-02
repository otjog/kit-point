{{-- Logo --}}
<div class="col-lg-3 col-sm-3 col-6 order-1 d-none d-md-block">
    <div class="logo_container">
        <div class="logo">
            <a href="{{asset('/')}}">
                <img
                        class="img-fluid"
                        src="{{route('getImage',['default', 'logo-l', $global_data['info']['logotype'], 1])}}"
                        alt="{{$global_data['info']['logotype']}} Logo"
                />
            </a>
        </div>
    </div>
</div>