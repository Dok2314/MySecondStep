@extends('layouts.main')

@section('title', 'Главная')

@section('header')
    <header class="p-3 bg-dark text-white">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="{{ route('homePage') }}" class="nav-link px-2 text-secondary">Главная</a></li>
{{--                    <li><a href="#" class="nav-link px-2 text-white">Features</a></li>--}}
{{--                    <li><a href="#" class="nav-link px-2 text-white">Pricing</a></li>--}}
{{--                    <li><a href="#" class="nav-link px-2 text-white">FAQs</a></li>--}}
{{--                    <li><a href="#" class="nav-link px-2 text-white">About</a></li>--}}
                </ul>

{{--                <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">--}}
{{--                    <input type="search" class="form-control form-control-dark" placeholder="Search..." aria-label="Search">--}}
{{--                </form>--}}

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

@endsection
