
    @if(isset( $data['header_page'] ))
        @include( $template_name .'.modules.home.default', $data)
    @endif

    @if(isset( $template['banner'] ))
        @include( $template_name .'.modules.banner.default')
    @endif

    @if(isset( $template['component'] ))
        <div class="{{$template['resource']}}">
            <div class="container">
                <div class="row">

                    @if(isset($template['sidebar']))
                        @include( $template_name .'.modules.'.$template['sidebar'].'.default', $data)
                    @endif

                    @include( $template_name .'.components.'.$template['component'].'.'.$template['resource'].'.'.$template['view'], $data)

                </div>
            </div>
        </div>
    @endif

    @if(isset( $template['custom'] ) && count( $template['custom'] ) > 0)
        @foreach($template['custom'] as $module)

            @include( $template_name .'.modules.custom.'.$module)

        @endforeach
    @endif


