@if( isset($offers) & $offers !== null & count($offers) > 0)
    <div class="popular-products my-5">
        <div class="container">
            <h2>Товарные предложения</h2>
            <div class="row no-gutters">
                @if(isset($offers['mainOffer']) & $offers['mainOffer'] !== null)
                    @include( $global_data['project_data']['template_name'] .'.modules.offers.main-offer', ['offer' => $offers['mainOffer']])
                @endif

                @if(isset($offers['offers']) & $offers['offers'] !== null & count($offers['offers']) > 0)
                    @include( $global_data['project_data']['template_name'] .'.modules.offers.secondary-offer', ['offers' => $offers['offers']])
                @endif
            </div>
        </div>
    </div>
@endif
