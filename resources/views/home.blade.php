@extends('layouts.main')

@section('title', 'Главная')

@section('header')
    @include('includes.defaultHeader')
@endsection

@section('content')

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Данный пост также нравится:</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Пользователь</th>
                            <th scope="col">E-mail</th>
                        </tr>
                        </thead>
                        <tbody class="usersWhoAlsoLikePost">

                        </tbody>
                    </table>
                </div>
{{--                <div class="modal-footer">--}}
{{--                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>--}}
{{--                    <button type="button" class="btn btn-primary">Save changes</button>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>

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
                <div class="search">
                    <input style="margin-top: 35px;" type="search" name="search" id="search" placeholder="Найдите нужный пост..." class="form-control">
                </div>
            </div>
        </div>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Номер</th>
            <th scope="col">Название</th>
            <th scope="col">Пост</th>
            <th scope="col">Автор</th>
            <th scope="col">Создан</th>
            <th scope="col">Нравится</th>
            <th scope="col">Коментарии</th>
        </tr>
        </thead>
        <tbody id="Content">
        @foreach($posts as $post)
            <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->title }}</td>
                <td>{!! $post->post !!}</td>
                <td>{{ $post->user->name }}</td>
                <td>{{ $post->created_at }}</td>
                <td>
                    <button
                        id="show-users"
                        data-url="{{ route('user.likes', $post->id) }}"
                        type="button" class="border-0 bg-transparent" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        {{ $post->liked_users_count }}
                    </button>
                    <form action="{{ route('post.like', $post->id) }}" method="post" class="offset-3" style="margin-top: -24px; margin-left: 23px;">
                        @csrf
                        @method('POST')
                        <button class="border-0 bg-transparent">
                            @auth
                                    <i
                                        class="fa-solid fa-heart"
                                       style="color: {{ auth()->user()->likedPosts->contains($post->id) ? 'red' : 'silver' }}">
                                    </i>
                            @endauth
                            @guest
                                    <i class="fa-solid fa-heart" style="color: black "></i>
                            @endguest
                        </button>
                    </form>
                </td>
                <td>
                    <a href="{{ route('commentToPost.create', $post->id) }}" style="text-decoration: none;"><span><i class="fa-solid fa-comment offset-3"></i>({{ $post->comments->count() }})</span></a>
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

        $(document).ready(function () {
            $('body').on('click', '#show-users', function () {

                var userURL = $(this).data('url');

                $.ajax({
                    url: userURL,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var data = ""

                        $.each(response, function(key,value){
                            data = data + "<tr>"
                            data = data + "<td>"+value.name+"</td>"
                            data = data + "<td>"+value.email+"</td>"
                            data = data + "<td>"
                            data = data + "</td>"
                            data = data + "</tr>"
                        });
                        $('.usersWhoAlsoLikePost').html(data);
                    }
                });
            });
        });

        $('#search').on('keyup', function (e) {
            e.preventDefault();

            $value = $(this).val();

            $.ajax({
               type: "GET",
               data: {'search':$value},
               url: "{{ URL::to('search') }}",
               success: function (data) {
                   $('#Content').html(data);
               }
            });
        })
    </script>
@endpush
