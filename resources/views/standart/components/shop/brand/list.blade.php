<div class="col-12">
    <h1>{{$header_page}}</h1>
    <div class="card-columns">

        @foreach($brands->chunk($global_data['project_data']['components']['shop']['chunk_categories']) as $brands_row)

            @foreach($brands_row as $key => $brand)

                <div class="card rounded-0">
                    <div class="card-body px-2">
                        <a href="{{ route( 'brands.show', $brand['name'] ) }}">
                            <h6 class="card-title text-dark text-center"><u>{{$brand['name']}}</u></h6>
                        </a>

                    </div>
                </div>
            @endforeach

        @endforeach
    </div>
</div>