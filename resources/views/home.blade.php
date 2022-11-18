@extends('layouts.main')

@section('title', 'Главная')

@section('header')
    @include('includes.defaultHeader')
@endsection

@section('content')
    <div class="container mb-5 mt-3">
        <div class="row">
            <div class="col-md-8">
                <h4>Сортировать по автору(ам)</h4>
                <form action="{{ route('homePage') }}">
                    <select name="users[]"  id="select-state" placeholder="Выберите автора(ов)" multiple>
                        @foreach($users as $user)
                            <option value="">Select a state...</option>
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-success mt-2 btn-sm">Фильтровать</button>
                </form>
            </div>
            <div class="col-md-4">
                <form action="">

                </form>
            </div>
        </div>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Название</th>
            <th scope="col">Пост</th>
            <th scope="col">Автор</th>
            <th scope="col">Дата создания</th>
            <th scope="col">Нравится</th>
            <th scope="col">Коментарии</th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
            <tr>
                <td>{{ $post->title }}</td>
                <td>{!! $post->post !!}</td>
                <td>{{ $post->user->name }}</td>
                <td>{{ $post->created_at }}</td>
                <td>
                    <span style="margin-right: 5px;"><i class="fa-solid fa-heart" style="color: red;"></i>(53)</span>
                </td>
                <td>
                    <a href="{{ route('commentToPost.create', $post->id) }}" style="text-decoration: none;"><span><i class="fa-solid fa-comment"></i>({{ $post->comments->count() }})</span></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="mb-5">
        {{ $posts->withQueryString()->links('vendor.pagination.bootstrap-4') }}
    </div>
@endsection

@push('scripts')
    <script>
        new TomSelect("#select-state",{
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });
    </script>
@endpush
