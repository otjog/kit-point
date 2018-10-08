@extends('templates.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if( isset( $data['page'] ) )
                    @php $page = $data['page'] @endphp
                    <form method="post" action="{{route('pages.update', ['id' => $page->id])}}">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="active" id="active" @if($page->active) checked @endif>
                                <label class="form-check-label" for="active">Опубликован?</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alias">Alias</label>
                            <input type="text" class="form-control" name="alias" id="alias" value="{{$page->alias}}">
                        </div>
                        <div class="form-group">
                            <label for="name">Название страницы</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{$page->name}}">
                        </div>
                        <div class="form-group">
                            <label for="description">Описание</label>
                            <textarea class="form-control" name="description" id="description">
                {{$page->description}}
            </textarea>
                        </div>
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection



