@if($banner->img !== null)
    <div class="carousel-item @if ($loop->first) active @endif">
        <a href="{{$banner->source}}">
            <img src="{{route('models.sizes.images.show', ['banner', 'main', $banner->img])}}">
        </a>
    </div>
@endif