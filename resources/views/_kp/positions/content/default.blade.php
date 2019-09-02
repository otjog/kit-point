@php
    $template = $global_data['template']['schema']['current']['content'];
    $modules = $global_data['modules'];
    $breadcrumbs = $global_data['breadcrumbs'];
@endphp

    @if(isset($template['top']) && $template['top'] !== null)
        @foreach($template['top'] as $module)
            @if(count($module) > 0)
                @include('_kp.modules.' . $module['module'] . '.index' , ['module' => $module])
            @endif
        @endforeach
    @endif

    <div class="container my-3">

        @include('_kp.modules.breadcrumbs.index')

        <div class="row">
            @if(isset($template['left']) && $template['left'] !== null)
                <div class="col-lg-3 col-12">
                    @foreach($template['left'] as $module)
                        @if(count($module) > 0)
                            @include('_kp.modules.' . $module['module'] . '.index' , ['module' => $module])
                        @endif
                    @endforeach
                </div>
            @endif

                <div class="col-md col-12">
                    @yield('component')
                </div>
        </div>
    </div>

    @if(isset($template['center']) && $template['center'] !== null)
        @foreach($template['center'] as $module)
            @if(count($module) > 0)
                @include('_kp.modules.' . $module['module'] . '.index' , ['module' => $module])
            @endif
        @endforeach
    @endif

    @if(isset($template['bottom']) && $template['bottom'] !== null)
        @foreach($template['bottom'] as $module)
            @if(count($module) > 0)
                @include('_kp.modules.' . $module['module'] . '.index' , ['module' => $module])
            @endif
        @endforeach
    @endif

