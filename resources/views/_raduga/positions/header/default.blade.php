@php
    $template = $global_data['template']['schema']['current']['header'];
    $modules = $global_data['modules'];
@endphp
<header id="header-area">
    <!-- Main Header Starts -->
    <div class="main-header">
        <!-- Nested Container Starts -->
        <div class="container">
            <!-- Nested Row Starts -->
            <div class="row">
                @if(isset($template['middle']) && $template['middle'] !== null)
                    @foreach($template['middle'] as $module)
                        @if(count($module) > 0)
                            @include('_raduga.modules.' . $module['module'] . '.index' , ['module' => $module])
                        @endif
                    @endforeach
                @endif
            </div>
            <!-- Nested Row Ends -->
        </div>
        <!-- Nested Container Ends -->
    </div>
    <!-- Main Header Ends -->

    @if(isset($template['bottom']) && $template['bottom'] !== null)
        @foreach($template['bottom'] as $module)
            @if(count($module) > 0)
                @include('_raduga.modules.' . $module['module'] . '.index' , ['module' => $module])
            @endif
        @endforeach
    @endif
</header>

