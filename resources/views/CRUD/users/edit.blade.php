@extends('layouts.main')

@section('title', 'Редактирование пользователя')

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
    @php
        $userAvatarPath = Storage::disk('images')->url('/user/');
    @endphp

    <form method="post" class="form-control" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label for="">Имя</label>
            <input type="text" name="name" value="{{ $user->name }}" class="form-control">
        </div>
        @error('name')
            <div class="text-danger">{{ $message }}</div>
        @enderror
        <div class="form-group mb-3">
            <label for="">E-mail</label>
            <input type="text" name="email" value="{{ $user->email }}" class="form-control">
        </div>
        @error('email')
            <div class="text-danger">{{ $message }}</div>
        @enderror
        <div class="form-group mb-3">
            <label for="">Роль</label>
            <br>
            <select name="role" id="" class="form-control">
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ $user->role->is($role) ? 'selected' : '' }}>{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
        @error('role')
            <div class="text-danger">{{ $message }}</div>
        @enderror
        <div class="form-group mb-3 pass">
            <label for="new_pass">Новый пароль?</label>
            <span class="icon_new_pass" id="icon_new_pass">&#128065</span>
            <input type="password" name="new_pass" id="new_pass" class="form-control new_pass">
        </div>
        @error('new_pass')
            <div class="text-danger">{{ $message }}</div>
        @enderror
        <div class="form-group mb-3">
            <label for="new_pass_confirmation">Повторите пароль</label>
            <span class="icon_new_pass_confirmation" id="icon_new_pass_confirmation">&#128065</span>
            <input type="password" name="new_pass_confirmation" id="new_pass_confirmation" class="form-control new_pass_confirmation">
        </div>
        @error('new_pass_confirmation')
            <div class="text-danger">{{ $message }}</div>
        @enderror
        <div class="form-group mb-3">
            <label for="">Фото профиля?</label>
            <img style="width: 150px; height: 100px; border-radius: 50%; display: block; margin-top: 10px; margin-bottom: 10px;" src="{{ $user->image ? $userAvatarPath . $user->image : $userAvatarPath . 'default.png' }}" alt="">
            <input type="file" name="new_profile_image">
        </div>
        @error('new_profile_image')
            <div class="text-danger">{{ $message }}</div>
        @enderror
        <button class="btn btn-warning">Сохранить</button>
    </form>
@endsection

@push('scripts')
    <script>
        $('#new_pass_confirmation').prop( "disabled", true);

        $('#new_pass').on('click', function (e) {
            e.preventDefault();

            $('#new_pass_confirmation').prop( "disabled", false);
        })

        const inputNewPass = document.getElementById('new_pass');
        const iconNewPass  = document.getElementById('icon_new_pass');

        const inputNewPassConfirmation = document.getElementById('new_pass_confirmation');
        const iconNewPassConfirmation  = document.getElementById('icon_new_pass_confirmation');

        iconNewPass.addEventListener('click', function () {
           if(inputNewPass.getAttribute('type') === 'password') {
               inputNewPass.setAttribute('type', 'text');
           } else {
               inputNewPass.setAttribute('type', 'password');
           }
        });

        iconNewPassConfirmation.addEventListener('click', function () {
            if(inputNewPassConfirmation.getAttribute('type') === 'password') {
                inputNewPassConfirmation.setAttribute('type', 'text');
            } else {
                inputNewPassConfirmation.setAttribute('type', 'password');
            }
        });
    </script>
@endpush

@push('styles')
    <style>
        .pass {
            position: relative;
        }

        .icon_new_pass {
            position: absolute;
            right: 20px;
            top: 70%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .icon_new_pass_confirmation {
            position: absolute;
            right: 105px;
            top: 67.5%;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
@endpush
