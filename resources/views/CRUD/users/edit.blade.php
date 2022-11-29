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
        <div class="form-group mb-3">
            <label for="">Новый пароль?</label>
            <input type="password" name="new_pass" class="form-control">
        </div>
        @error('new_pass')
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
    <script src="https://cdn.ckeditor.com/ckeditor5/35.3.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>
@endpush