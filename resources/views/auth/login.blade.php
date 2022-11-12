@extends('layouts.main')

@section('title', 'Вход')

@section('header')
    <header class="p-3 bg-dark text-white">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="{{ route('homePage') }}" class="nav-link px-2 text-secondary">Главная</a></li>
                </ul>
                @guest
                    <div class="text-end">
                        <a href="{{ route('auth.registration') }}"><button type="button" class="btn btn-outline-light me-2">Зарегистрироваться</button></a>
                    </div>
                @endguest
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <form method="post" class="form-control mt-5">
                @csrf
                @method('POST')
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                    </div>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-group mb-3 mt-3">
                        <label for="password">Пароль</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-group mt-4 mb-4">
                        <div class="captcha">
                            <span>{!! captcha_img() !!}</span>
                            <button type="button" class="btn btn-danger" class="reload" id="reload">
                                &#x21bb;
                            </button>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha">
                    </div>
                    @error('captcha')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-group mt-4">
                        <label for="remember">Запомнить меня?</label>
                        <input type="checkbox" name="remember" id="remember">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-success">Войти</button>
            </form>
        </div>
    </div>
@endsection

@section('footer')

@endsection

@push('scripts')
    <script type="text/javascript">
        $('#reload').click(function () {
            $.ajax({
                type: 'GET',
                url: 'login-reload-captcha',
                success: function (data) {
                    $(".captcha span").html(data.captcha);
                }
            });
        });
    </script>
@endpush
