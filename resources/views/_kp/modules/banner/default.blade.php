@isset( $banners )
    @foreach($banners as $banner)
        <div class="banner">
            @include( $template_name .'.modules.banner.' . $banner->component . '.' . $banner->resource . '.default')
        </div>
    @endforeach
@endisset