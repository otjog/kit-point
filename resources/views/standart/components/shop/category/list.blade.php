<div class="col-12">
<h1>{{$header_page}}</h1>
    <div class="card-columns">

        @foreach($categories->chunk($global_data['project_data']['components']['shop']['chunk_categories']) as $categories_row)

            @foreach($categories_row as $key => $category)

                <div class="card rounded-0">
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
</div>