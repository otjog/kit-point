<h1 class="product_name">
    @isset($product->manufacturer['name'])
        {{ $product->manufacturer['name'] . ' ' }}
    @endisset

    {{ $product->name }}

    @if( isset($product->brands) && count($product->brands) > 0 && $product->brands !== null)

        @foreach($product->brands as $brand)
            {{ ' | ' . $brand->name}}
        @endforeach

    @endif
</h1>