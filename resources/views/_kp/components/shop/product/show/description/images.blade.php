@if( isset( $product->images ))
    <h3>Изображения</h3>
    <div class="row">
        @foreach( $product->images as $image)
            <div class="col-12 col-md-6">
                <img
                        class="img-fluid"
                        src="{{route('getImage', ['product', 'l', $image->src, $product->id])}}"
                        alt="{{$image->alt or $product->name}}"
                />
            </div>
        @endforeach
    </div>
@endif
