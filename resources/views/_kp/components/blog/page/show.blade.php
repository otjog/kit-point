@extends('_kp.index')

@php
    $page =& $global_data['blog']['page']
@endphp

@section('component')

    <div class="col-lg-8 offset-lg-2">
        <h1>{{$page->name}}</h1>
        <div class="single_post_text">{!! $page->description !!}</div>
    </div>

@endsection