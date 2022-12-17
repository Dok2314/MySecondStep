@extends('layouts.main')

@section('title', 'Мои посты')

@section('header')
    <header class="p-3 bg-dark text-white">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="{{ route('homePage') }}" class="nav-link px-2 text-secondary">Главная</a></li>
                </ul>
                <div class="text-end">
                    @auth
                        <div class="container">
                            <div class="row">
                                <div class="col-md-8">
                                    <h4 style="margin-right: 17px">{{ Auth::user()->name }}</h4>
                                    <a href="{{ route('auth.logout') }}">
                                        <button type="button" class="btn btn-outline-light me-2">Выйти</button>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <h4 style="margin-right: 17px">{{ __('main.current_lang') }}</h4>
                                    <li style="list-style-type: none;"><a href="{{ route('locale', __('main.set_lang')) }}">{{ __('main.set_lang') }}</a></li>
                                </div>
                            </div>
                        </div>
                    @endauth

                    @guest
                        <a href="{{ route('auth.login') }}"><button type="button" class="btn btn-outline-light me-2">Войти</button></a>
                    @endguest
                    @guest
                        <a href="{{ route('auth.registration') }}"><button type="button" class="btn btn-warning">Регистрация</button></a>
                    @endguest
                </div>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <a href="{{ route('posts.create') }}" style="font-size: 30px;"><i class="fa-solid fa-plus"></i></a>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2>Мои Посты</h2>
                <h5>Удалённых: {{ $countWithDeleted }}</h5>
                <h5>Не удалённых: {{ $countWithoutDeleted }}</h5>
                @foreach($userPosts as $post)
                    <br>
                    <div class="card" style="{{ $post->deleted_at ? 'background: rgba(255, 0, 0, 0.2)' : '' }};">
                        <div class="card-header">
                            {{ $post->title }}
                            <div class="float-right">
                                @if($post->deleted_at && !$post->is_admin_deleted)
                                    <form method="post" action="{{ route('posts.restore', $post->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" style="background: none; color: red; border: none;">
                                            <i class="fa-solid fa-trash-can-arrow-up" style="color: orange;"></i>
                                        </button>
                                    </form>
                                @elseif($post->is_admin_deleted)
                                    @can('post restore')
                                        <form method="post" action="{{ route('posts.restore', $post->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" style="background: none; color: red; border: none;">
                                                <i class="fa-solid fa-trash-can-arrow-up" style="color: orange;"></i>
                                            </button>
                                        </form>
                                    @endcan
                                @else
                                    <form method="post" action="{{ route('posts.destroy', $post->id) }}">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" style="background: none; color: red; border: none;">
                                            <i class="fa-sharp fa-solid fa-delete-left"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('posts.edit', $post->id) }}">
                                        <i class="fa-solid fa-pen-to-square" style="color: blue; margin-left: 10px;"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            @if($post->deleted_at)
                                <h6 class="card-title float-right">Удалён: {{ $post->deleted_at->toDateString() }}</h6>
                            @else
                                <h6 class="card-title float-right">Создан: {{ $post->created_at->toDateString() }}</h6>
                            @endif
                            @if($post->deleted_at && !$post->is_admin_deleted)
                               <h4>{{ $post->deleted_at ? 'УДАЛЁН' : '' }}</h4>
                            @elseif($post->is_admin_deleted)
                                    <h4>{{ $post->is_admin_deleted ? 'УДАЛЁН АДМИНИСТРАЦИЕЙ' : '' }}</h4>
                            @endif
                            <p class="card-text">{!! $post->post !!}</p>
                            <span style="margin-right: 5px;"><i class="fa-solid fa-heart" style="color: red;"></i>({{ $post->liked_users_count }})</span>
                            <span>
                                <i class="fa-solid fa-comment"></i>({{ $post->comments_count }})
                            </span>
                        </div>
                    </div>
                @endforeach
                <br>
                <div class="mb-5">
                    {{ $userPosts->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
            <div class="col-md-4">
                <h2>Популярные посты</h2>
            </div>
        </div>
    </div>
@endsection
