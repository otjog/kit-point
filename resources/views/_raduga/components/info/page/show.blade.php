@extends('_raduga.index')

@section('component')

    <?php
        $page =& $global_data['page']
    ?>

    <div class="col-lg-8 offset-lg-2">
        <h1>{{$page->name}}</h1>
        <div class="single_post_text">{!! $page->description !!}</div>
    </div>
@endsection