@foreach($banners as $banner)
    <div class="owl-banner owl-theme bg-success">
        @if($banner->slides !== null)
            @foreach($banner->slides as $slide)
                <div class="item">
                    @include('_raduga.modules.banner._slides_templates.' . $slide['template'])
                </div>
            @endforeach
        @endif
    </div>
@endforeach