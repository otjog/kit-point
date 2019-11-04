<div class="product-name">
    <a class="text-dark" href="{{ route( 'products.show', $product->id ) }}">
        @isset($product->manufacturer['name'])
            {{ $product->manufacturer['name'] . ' ' }}
        @endisset
        {{ $product->name }}
        @if( isset($product->brands) && count($product->brands) > 0 && $product->brands !== null)
            @foreach($product->brands as $brand)
                {{ ' | ' . $brand->name}}
            @endforeach
        @endif
    </a>
</div>