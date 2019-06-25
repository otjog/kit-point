@php
    $categories = $modules[$module['resource']];
@endphp
@if(isset($categories) && $categories !== null)
    <hr>
    <h2 class="text-uppercase text-center">Категории</h2>
    <hr>
    <div class="container">
        <div class="card-deck">
            @foreach($categories->chunk($global_data['components']['shop']['chunk_categories']) as $item_row)
                <div class="row">
                    @foreach($item_row as $item)
                        <div class="card mb-4 rounded-0">
                            <a href="{{Route('categories.show', $item['id'])}}">
                                <img
                                        src="{{route('models.sizes.images.show', ['category', 's', $item['images'][0]->src])}}"
                                        class="card-img-top"
                                        alt="{{$item['name']}}"
                                >
                            </a>
                            <div class="card-body px-2">
                                <a href="{{Route('categories.show', $item['id'])}}">
                                    <h6 class="card-title text-dark text-center"><u>{{$item['name']}}</u></h6>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endif