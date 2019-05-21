@php
    $template = $global_data['template']['schema']['current']['content'];
    $modules = $global_data['modules'];
@endphp

<div id="main-container-home" class="container">
    @if(isset($template['top']) && $template['top'] !== null)
        @foreach($template['top'] as $module)
            @if(count($module) > 0)
                @include('_raduga.modules.' . $module['module'] . '.index' , ['module' => $module])
            @endif
        @endforeach
    @endif

        <div class="row">
            @php $colMdComponent = '12'; @endphp
            @if(isset($template['side']) && $template['side'] !== null)
                <div class="col-md-3 col-sm-12">
                    @foreach($template['side'] as $module)
                        @if(count($module) > 0)
                            @include('_raduga.modules.' . $module['module'] . '.index' , ['module' => $module])
                            @php $colMdComponent = '9'; @endphp
                        @endif
                    @endforeach
                </div>
            @endif

            <div class="col-md-{{$colMdComponent}} col-sm-12">
                @yield('component')

                @if(isset($template['content_bottom']) && $template['content_bottom'] !== null)
                    @foreach($template['content_bottom'] as $module)
                        @if(count($module) > 0)
                            @include('_raduga.modules.' . $module['module'] . '.index' , ['module' => $module])
                        @endif
                    @endforeach
                @endif
            </div>

        </div>

        @if(isset($template['bottom']) && $template['bottom'] !== null)
            @foreach($template['bottom'] as $module)
                @if(count($module) > 0)
                    @include('_raduga.modules.' . $module['module'] . '.index' , ['module' => $module])
                @endif
            @endforeach
        @endif
</div>

