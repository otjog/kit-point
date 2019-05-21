@if( isset($banners) && count($banners) > 0 && $banners !== null )
    <div id="carouselIndicators" class="carousel slide banner d-none d-md-block" data-ride="carousel">

        <div class="carousel-inner">
            @foreach($banners as $banner)
                @include( $global_data['project_data']['template_name'] .'.modules.banner.' . $banner->type . '.' . $banner->template)
            @endforeach
        </div>
        @if( count($banners) > 1)
            <ol class="carousel-indicators">
                @for($i = 0; $i < count($banners); $i++)
                    <li data-target="#carouselIndicators" data-slide-to="{{$i}}" @if($i === 0) class="active" @endif></li>
                @endfor
            </ol>
            <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        @endif
    </div>
@endif