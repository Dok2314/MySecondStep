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
             <div class="col-md-8">
                 <h2>{{ $user->name }}</h2>
                 @php
                     $userAvatarPath = Storage::disk('images')->url('/user/');
                 @endphp
                 <img src="{{ $user->image ? $userAvatarPath . $user->image : $userAvatarPath . 'default.png' }}" alt="" width="140px" height="100px" style="border-radius: 50%; ">
                 <form action="{{ route('profile.updateImage') }}" method="post" enctype="multipart/form-data">
                     @csrf
                     <label>Сменить фото профиля?
                         <input type="file" name="image" accept="image/*" />
                     </label><br>
                     <button class="btn btn-success mt-2">Сохранить</button>
                 </form>
             </div>
             <div class="col-md-4">

             </div>
         </div>
    </div>
@endsection

