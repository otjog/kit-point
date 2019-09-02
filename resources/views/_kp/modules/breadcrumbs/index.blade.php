<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent">

        @if(count($breadcrumbs) > 0)
            <li class="breadcrumb-item"><a href="{{$global_data['site_url']}}">Главная</a></li>
        @endif

        @foreach($breadcrumbs as $item)
            @if($loop->last)
                <li class="breadcrumb-item active" aria-current="page">{{$item['name']}}</li>
            @else
                <li class="breadcrumb-item"><a href="{{$item['href']}}">{{$item['name']}}</a></li>
            @endif
        @endforeach
    </ol>
</nav>