
    @if(isset( $template['banner'] ))
        @include( $global_data['project_data']['template_name'] .'.modules.banner.default')
    @endif

    @if(isset( $template['component'] ))
        <div class="{{$template['resource']}} py-3">
            <div class="container">
                <div class="row">

                    @if(isset($template['sidebar']))
                        @include( $global_data['project_data']['template_name'] .'.modules.'.$template['sidebar'].'.default', $data)
                    @endif

                    @include( $global_data['project_data']['template_name'] .'.components.'.$template['component'].'.'.$template['resource'].'.'.$template['view'], $data)

                </div>
            </div>
        </div>
    @endif

    @if(isset( $template['modules'] ) && count( $template['modules'] ) > 0)
        @foreach($template['modules'] as $folder => $file)

            @include( $global_data['project_data']['template_name'] .'.modules.' . $folder . '.' . $file)

        @endforeach
    @endif


