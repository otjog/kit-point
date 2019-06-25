@extends('_raduga.index')

@section('component')
    <?php
        $categories =& $global_data['shop']['category'];
    ?>
    <h1>{{$global_data['header_page']}}</h1>
    <div class="card-deck">

        @foreach($categories->chunk($global_data['components']['shop']['chunk_categories']) as $categories_row)

            @foreach($categories_row as $key => $category)

                <div class="card rounded-0">
                    <a href="{{ route( 'categories.show', $category['id'] ) }}">
                        <img
                                src="{{route('models.sizes.images.show', ['category', 's', $category['images'][0]->src])}}"
                                class="card-img-top"
                                alt="{{$category['name']}}"
                        >
                    </a>
                    <div class="card-body px-2">
                        <a href="{{ route( 'categories.show', $category['id'] ) }}">
                            <h6 class="card-title text-dark text-center"><u>{{$category['name']}}</u></h6>
                        </a>
                        @if( isset( $category['children'] ) && count($category['children']) > 0 )
                            <ul class="list-group list-group-flush">
                                @foreach($category['children'] as $key => $category)

                                    <li class="list-group-item">
                                        <a href="{{ route( 'categories.show', $category['id'] ) }}">
                                            <span class="card-title text-muted"><u>{{$category['name']}}</u></span>
                                        </a>
                                    </li>

                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            @endforeach

        @endforeach
    </div>
@endsection
