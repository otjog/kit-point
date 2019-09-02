@php
    $categories = $modules[$module['resource']];
@endphp
@if(isset($categories) && $categories !== null)
{{-- Popular Categories --}}
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

            {{-- Popular Categories Slider --}}

            <div class="col-lg-9">
                <div class="popular_categories_slider_container">
                    <div class="owl-carousel owl-theme popular_categories_slider">
                        @foreach($categories as $category)
                            <div class="owl-item">
                                <div class="popular_category d-flex flex-column align-items-center justify-content-center">
                                    @if(isset($category['images']) && $category['images'] !== null && count($category['images']) > 0)
                                        <span class="popular_category_image">
                                            @php
                                                if (count($category['images']) > 0)
                                                    $imageSrc = $category['images'][0]->src;
                                                else
                                                    $imageSrc = 'noimage';
                                            @endphp
                                            <a href="{{route('categories.show', $category['id'])}}">
                                                <img
                                                        src="{{route('getImage', ['category', 's', $imageSrc, $category['id']])}}"
                                                        alt="{{$category['images'][0]->alt or $category['name']}}">
                                            </a>
                                        </span>
                                    @endif
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