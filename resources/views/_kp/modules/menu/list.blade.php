<ul class="footer_list">
    @foreach($list as $item)
        <li><a href="{{route( $path.'.show', $item['id'] )}}">{{ $item['name'] }}</a></li>
    @endforeach
</ul>