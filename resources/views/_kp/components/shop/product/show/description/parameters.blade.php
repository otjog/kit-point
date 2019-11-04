@if( isset($product->parameters) && count($product->parameters) > 0)
    @php $product->parameters = $product->parameters->groupBy('alias'); @endphp
    <h3>Характеристики</h3>
    <div class="container py-1 my-1">
        @foreach($product->parameters as $currentParameters)

            @if(count($currentParameters) > 0)
                <div class="row">
                    @foreach($currentParameters as $key => $parameter)
                        @if($loop->first)
                            <div class="col col-lg-3 pl-0 ml-2 product_parameter_name">
                                <span>{{$parameter->name}}:</span>
                            </div>
                            <div class="col col-lg-3 text-muted pl-1">
                                @endif
                                <span>{{$parameter->pivot->value}}</span>
                                @if($loop->last)
                            </div>
                        @else
                            <span> | </span>
                        @endif
                    @endforeach
                </div>
            @endif


        @endforeach
    </div>
@endif