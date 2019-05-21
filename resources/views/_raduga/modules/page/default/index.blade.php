@php
    $page = $modules[$module['resource']];
@endphp

    <hr>
    <h2 class="text-uppercase text-center">
        {{$page->name}}
    </h2>
    <hr>
    <div class="p-3 shadow rounded">
        {!! $page->description !!}
    </div>