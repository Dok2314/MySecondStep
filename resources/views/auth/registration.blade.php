@extends('layouts.main')

@section('title', 'Регистрация')

@section('header')
    <header class="p-3 bg-dark text-white">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="{{ route('homePage') }}" class="nav-link px-2 text-secondary">Главная</a></li>
                </ul>

                <div class="text-end">
                    <a href="{{ route('auth.login') }}"><button type="button" class="btn btn-outline-light me-2">Войти</button></a>
                </div>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <form method="post" class="form-control mt-5 mb-5">
                @method('POST')
                @csrf
                <div class="form-group mt-4">
                    <label for="name">Имя</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                </div>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="form-group mt-4">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                </div>
                @error('email')
                <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="form-group mt-4">
                    <label for="password">Пароль</label>
                    <input type="password" name="password" id="password" class="form-control" value="{{ old('password') }}">
                </div>
                @error('password')
                <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="form-group mt-4">
                    <label for="password_confirmation">Повторите пароль</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                </div>
                @error('password-confirm')
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
                <br>
                <button type="submit" class="btn btn-success">Зарегистрироваться</button>
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
                url: 'registration-reload-captcha',
                success: function (data) {
                    $(".captcha span").html(data.captcha);
                }
            });
        });
    </script>
@endpush
