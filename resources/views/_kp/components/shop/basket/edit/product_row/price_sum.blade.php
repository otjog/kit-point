<span class="d-inline d-lg-none">Сумма: </span>
<span class="h6">{{ $product->price['value'] * $product->baskets[0]['pivot']->quantity}}</span>
<small>{{$global_data['components']['shop']['currency']['symbol']}}</small>