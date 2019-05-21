<div class="owl-banner owl-theme bg-success">
    @foreach($banners as $banner)
        @if($banner->img !== null)
            <div class="item">
                <a href="{{$banner->source}}">
                    <img src="{{route('models.sizes.images.show', ['banner', 'main', $banner->img])}}">
                </a>
            </div>
        @endif
    @endforeach

</div>

