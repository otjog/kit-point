<div class="slider d-none d-md-block">
    <div id="main-carousel" class="carousel slide carousel-fade" data-ride="carousel">
        <!-- Wrapper For Slides Starts -->
        <div class="carousel-inner">
            @foreach($banners as $banner)
                @include( '_raduga.modules.banner.' . $module['template'] . '.' . $banner->type . '.default')
            @endforeach
        </div>
        <!-- Wrapper For Slides Ends -->
        <!-- Controls Starts -->
        <a class="carousel-control-prev animation" href="#main-carousel" role="button" data-slide="prev">
            <span class="fa fa-3x fa-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next animation" href="#main-carousel" role="button" data-slide="next">
            <span class="fa fa-3x fa-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
        <!-- Controls Ends -->
    </div>
</div>