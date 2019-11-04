<a href="{{ route('products.show', $product->id) }}">
    {{ $product->name }}
</a>

{{-- Атрибуты --}}
@if( isset($product['pivot']['order_attributes_collection']) && count( $product['pivot']['order_attributes_collection'] ) > 0)
    <br>
    @foreach($product['pivot']['order_attributes_collection'] as $attribute)
        <span class="text-muted small">
            {{$attribute->name}} : {{$attribute->pivot->value}}
        </span>
    @endforeach
@endif
