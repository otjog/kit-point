@php
    if (count($product->images) > 0)
        $imageSrc = $product->images[0]->src;
    else
        $imageSrc = 'noimage';
@endphp
<div class="product-image text-center">
    <a href="{{ route( 'products.show', $product->id ) }}">
        <img
                class="img-fluid"
                src="{{route('getImage',['product', 's', $imageSrc, $product->id])}}"
                alt="{{$product->images[0]->alt or $product->name}}"
        />
    </a>
</div>