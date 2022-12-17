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
    <form method="post" action="{{ route('posts.store') }}" class="form-control">
        @method('POST')
        @csrf
        <div class="form-group">
            <label for="title">Название</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
        </div>
        @error('title')
            <div class="text-danger">{{ $message }}</div>
        @enderror
        <div class="form-group mt-3 mb-2">
            <label for="editor">Пост</label>
            <textarea name="post" id="editor" cols="30" rows="10" class="form-control">{{ old('post') }}</textarea>
        </div>
        @error('post')
            <div class="text-danger">{{ $message }}</div>
        @enderror
        <button class="btn btn-success" type="submit">Создать</button>
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
