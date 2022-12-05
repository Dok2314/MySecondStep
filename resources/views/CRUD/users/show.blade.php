@extends('layouts.main')

@section('title', 'Добавление поста')

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
                                <div class="col-md-12">
                                    <h4 style="margin-right: 17px">{{ Auth::user()->name }}</h4>
                                    <a href="{{ route('auth.logout') }}">
                                        <button type="button" class="btn btn-outline-light me-2">Выйти</button>
                                    </a>
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
    @php
        $userAvatarPath = Storage::disk('images')->url('/user/');
    @endphp

    <div class="card offset-1">
        <img class="card-img-top" style="width: 150px; height: 100px; margin-left: 370px; border-radius: 50%;" src="{{ $user->image ? $userAvatarPath . $user->image : $userAvatarPath . 'default.png' }}"  alt="Card image cap">
        <div class="card-body">
            <h5 class="card-title">{{ $user->name }}</h5>
            <p class="card-text">{{ $user->role->name }}</p>

            <a href="{{ route('user.edit', $user) }}" class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
            <form action="{{ route('user.delete', $user) }}" method="post" style="float: right">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" type="submit">
                    <i class="fa-solid fa-delete-left"></i>
                </button>
            </form>
        </div>
    </div>
@endsection
