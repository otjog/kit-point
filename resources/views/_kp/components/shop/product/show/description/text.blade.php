@if(isset( $product->description ))
    <h3>Описание</h3>
    <div class="py-1 my-1">
        <p>{!! $product->description  !!}</p>
    </div>
@endif