@extends('_kp.index')

@section('component')
    <?php
        $categories =& $global_data['shop']['category']['children'];
    ?>
    <h1>{{$global_data['shop']['category']['name']}}</h1>
    <div class="card-columns">
        @foreach($categories->chunk($global_data['components']['shop']['chunk_categories']) as $categories_row)
            @foreach($categories_row as $key => $category)
                <div class="card rounded-0">
                    <a href="{{ route( 'categories.show', $category->id ) }}">
                        @php
                            if (count($category->images) > 0)
                                $imageSrc = $category->images[0]->src;
                            else
                                $imageSrc = 'noimage';
                        @endphp
                        <img
                                class="card-img-top"
                                src="{{route('getImage', ['category', 's', $imageSrc, $category->id])}}"
                                alt="{{$category->images[0]->alt or $category->name}}"
                        >
                    </a>
                    <div class="card-body px-2">
                        <a href="{{ route( 'categories.show', $category->id ) }}">
                            <h6 class="card-title text-dark text-center"><u>{{$category->name}}</u></h6>
                        </a>
                        {{--
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
                        --}}
                        @if( isset( $category->children ) && count($category->children) > 0 )
                            <ul class="list-group list-group-flush">
                                @foreach($category->children as $key => $category)

                                    <li class="list-group-item">
                                        <a href="{{ route( 'categories.show', $category->id ) }}">
                                            <span class="card-title text-muted"><u>{{$category->name}}</u></span>
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
