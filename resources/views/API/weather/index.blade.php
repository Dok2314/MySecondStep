@extends('layouts.main')

@section('title', 'Погода')

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
    <div class="container">
        <div class="row">
            @if(isset($res) && $res->cod == 200)
                <div class="col-md-8">
                    <div class="card offset-3 getWeather" style="width: 18rem;">
                        @php
                            $weather = 'weather/';

                            if($res->weather[0]->main == 'Snow') {
                                $weather .= 'snow.jpeg';
                            } elseif($res->weather[0]->main == 'Sun') {
                                $weather .= 'sun.jpeg';
                            } elseif($res->weather[0]->main == 'Rain') {
                                $weather .= 'rain.jpeg';
                            } else {
                                $weather .= 'cloud.jpeg';
                            }
                        @endphp
                        <img class="card-img-top" src="{{ Storage::disk('images')->url($weather) }}" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Weather in {{ $res->name }}</h5>
                            <h5>
                                Today is {{ $res->weather[0]->main }}
                            </h5>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-md-4">
                <form action="{{ route('getWeather') }}">
                    <input type="search" name="search" id="search" placeholder="Введите название города" class="form-control mb-2">
                    <button type="submit" class="btn btn-success">Узнать погоду</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush
