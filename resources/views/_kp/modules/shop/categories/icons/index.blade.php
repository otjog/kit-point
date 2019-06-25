@php
    $categories = $modules[$module['resource']];

@endphp
@if(isset($categories) && $categories !== null)
<!-- Popular Categories -->
    <div class="popular_categories">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="popular_categories_content">
                    <div class="popular_categories_title">Популярные категории</div>
                    <div class="popular_categories_slider_nav">
                        <div class="popular_categories_prev popular_categories_nav"><i class="fas fa-angle-left ml-auto"></i></div>
                        <div class="popular_categories_next popular_categories_nav"><i class="fas fa-angle-right ml-auto"></i></div>
                    </div>
                    <div class="popular_categories_link"><a href="{{route('categories.index')}}">Полный каталог</a></div>
                </div>
            </div>

            <!-- Popular Categories Slider -->

            <div class="col-lg-9">
                <div class="popular_categories_slider_container">
                    <div class="owl-carousel owl-theme popular_categories_slider">
                        @foreach($categories as $category)
                            <div class="owl-item">
                                <div class="popular_category d-flex flex-column align-items-center justify-content-center">
                                    <span class="popular_category_image">
                                        <a href="{{route('categories.show', $category['id'])}}">
                                            <img
                                                    src="{{route('models.sizes.images.show', ['category', 's', $category['images'][0]->src])}}"
                                                    alt="{{$category['images'][0]->src}}">
                                        </a>
                                    </span>
                                    <span class="popular_category_text">
                                        <a href="{{route('categories.show', $category['id'])}}">
                                            {{$category['name']}}
                                        </a>
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif