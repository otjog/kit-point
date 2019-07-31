<div class="col-lg-12">

    <h4 class="mb-3">Способ оплаты</h4>

    @if(isset($payments) && count($payments) > 0 && $payments !== null)

        <div class="my-4">

            @foreach($payments as $service)
                <div class="row p-2 border-bottom">

                    <div class="col-2">
                        @php
                            if (isset($service->images) && count($service->images) > 0)
                                $imageSrc = $service->images[0]->src;
                            else
                                $imageSrc = 'noimage';
                        @endphp
                        <img
                                class="img-fluid"
                                src="{{route('getImage', ['default', 'xxs', $imageSrc, $service->id])}}"
                                alt="{{$service->images[0]->alt or $service->name}}"
                        />
                    </div>

                    <div class="col-4">
                        <div class="custom-control custom-radio">
                            <input id="payment_{{ $service->id }}" name="payment_id" value="{{ $service->id }}" type="radio" class="custom-control-input" >
                            <label class="custom-control-label" for="payment_{{ $service->id }}">{{ $service->name }}</label>
                        </div>
                    </div>

                    <div class="col">
                        @if(isset($service->options))
                            @foreach ($service->options as $option)
                                <div class="col text-left">
                                    <span class="payment-message">
                                        @if(is_array($option))
                                            @foreach ($option as $pieceOfData)
                                                @if(mb_strlen($pieceOfData) > 10)
                                                    <small>{{$pieceOfData . ' '}}</small>
                                                @else
                                                    {{$pieceOfData . ' '}}
                                                @endif
                                            @endforeach
                                        @else
                                            <small>{{$option}}</small>
                                        @endif
                                    </span>
                                </div>
                            @endforeach
                        @endif
                    </div>

                </div>
            @endforeach
        </div>

    @endif

</div>