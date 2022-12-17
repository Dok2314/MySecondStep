@extends('layouts.main')

@section('title', 'Пользователи')

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
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Role</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        @if($user->deleted_at)
                            <tr style="background: rgba(255, 0, 0, 0.2); text-decoration: line-through;">
                                <th scope="row">{{ $user->id }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role->name }}</td>
                                @can('user restore')
                                    <td>
                                        <form action="{{ route('user.restore', $user->id) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <button style="background: none; border: none; color: orange;" type="submit">
                                                <i class="fa-solid fa-trash-arrow-up" style="color: orange;"></i>
                                            </button>
                                        </form>
                                    </td>
                                @elsecan
                                    <td class="text text-danger">
                                        <i class="fa-solid fa-circle-info"></i>Данный пользователь удалён, и может быть востановлен только администрацией
                                    </td>
                                @endcan
                            </tr>
                        @else
                            <tr>
                                <th scope="row">{{ $user->id }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role->name }}</td>
                                @can('user read')
                                    <td>
                                        <a href="{{ route('user.show', $user) }}"><i class="fa-solid fa-eye"></i></a>
                                    </td>
                                @endcan
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-4">
                @include('admin.right-sidebar')
            </div>
        </div>
    </div>
    <div class="mb-5">
        {{ $users->links('vendor.pagination.bootstrap-4') }}
    </div>
@endsection
