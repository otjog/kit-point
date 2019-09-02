@php
    $template = $global_data['template']['schema']['current']['footer'];
    $modules = $global_data['modules'];
@endphp

{{-- Footer --}}
<footer class="footer">
    <div class="container">
        <div class="row">

            @if(isset($template['top']) && $template['top'] !== null)
                @foreach($template['top'] as $module)
                    @if(count($module) > 0)
                        @include('_kp.modules.' . $module['module'] . '.index' , ['module' => $module])
                    @endif
                @endforeach
            @endif

        </div>
    </div>
</footer>

@if(isset($template['bottom']) && $template['bottom'] !== null)
    @foreach($template['bottom'] as $module)
        @if(count($module) > 0)
            @include('_kp.modules.' . $module['module'] . '.index' , ['module' => $module])
        @endif
    @endforeach
@endif