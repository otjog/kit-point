@if($banner->img !== null)
    <div class="carousel-item @if ($loop->first) active @endif">
        <a href="{{$banner->source}}">
            <img class="d-block w-100" src="{{ URL::asset('storage/img/banners/' . $banner->img) }}" height="50%" width="50%">
        </a>
    </div>

@endif