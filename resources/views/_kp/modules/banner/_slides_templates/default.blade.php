@if($slide['url'] !== null)
    <a href="{{asset($slide['url'])}}">
@endif
        @php
            if (count($slide->images) > 0)
                $imageSrc = $slide->images[0]->src;
            else
                $imageSrc = 'noimage';
        @endphp
    <img
        src="{{route('getImage', ['banner', 'main', $imageSrc, $slide->id])}}"
        alt="{{$slide->images[0]->alt or ''}}"
    >
@if($slide['url'] !== null)
    </a>
@endif