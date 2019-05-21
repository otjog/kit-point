<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}"><meta name="yandex-verification" content="5cfc0ee706c042ca" />

    @if(isset($meta) && $meta !== null)
        <title> {{$meta['title']}} </title>
        <meta name="description"    content=" {{$meta['description']}} ">
        <meta name="keywords"       content=" {{$meta['keywords']}} ">
    @endif

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">

    @if(isset($template['component']))
        @switch($template['component'])
            @case('shop')
            @case('info')
            <link rel="stylesheet" href="{{ asset('css/' . $template['component'] . '_' . $template['resource'] . '_styles.css') }}">
            @break
            @case('search')
            <link rel="stylesheet" href="{{ asset('css/shop_category_styles.css') }}">
            @break
        @endswitch
    @endif

    @includeIf('inclusion.yandex-metrika')

</head>
<body style="margin-bottom: 0">

    <!-- Modals -->
    @include($global_data['project_data']['template_name'] .'.positions.modals.default')

    <!-- Header -->
    <header class="header">
        @include( $global_data['project_data']['template_name'] .'.positions.header.default')
    </header>

    <!-- Content -->
    <main role="main">
        @include( $global_data['project_data']['template_name'] .'.positions.content.default')
    </main>

    <!-- Footer -->
    <footer class="footer" style="position: relative">
        @include( $global_data['project_data']['template_name'] .'.positions.footer.default')
    </footer>


    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDzy4Bx5gHQSf4kHFQMo_mFhKlfeL_3lU8"></script>
    <script src="{{URL::asset('js/app.js') }}"></script>
</body>
</html>

