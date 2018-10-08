@extends('templates.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <table class="table table-striped table-hover table-sm">
                    <thead>
                        <tr>
                            <th scope="col">id</th>
                            <th scope="col">На странице</th>
                            <th scope="col">Опубликован</th>
                            <th scope="col">Алиас</th>
                            <th scope="col">Название</th>
                            <th scope="col">Описание</th>
                            <th scope="col">Порядок</th>
                            <th scope="col">Создан</th>
                            <th scope="col">Изменен</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['pages'] as $page)
                            <tr>
                                <th scope="row">{{$page->id}}</th>
                                <td><a href="{{route('pages.show', ['id' => $page->id])}}">--></a></td>
                                <td>{{$page->active}}</td>
                                <td>{{$page->alias}}</td>
                                <td><a href="{{route('pages.edit', ['id' => $page->id])}}">{{$page->name}}</a></td>
                                <td></td>
                                <td>{{$page->sort}}</td>
                                <td>{{$page->created_at}}</td>
                                <td>{{$page->updated_at}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
