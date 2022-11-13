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
    <form method="post" action="{{ route('posts.update', $post->id) }}" class="form-control">
        @method('PATCH')
        @csrf
        <div class="form-group">
            <label for="title">Название</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $post->title }}">
        </div>
        @error('title')
        <div class="text-danger">{{ $message }}</div>
        @enderror
        <div class="form-group mt-3 mb-2">
            <label for="editor">Пост</label>
            <textarea name="post" id="editor" cols="30" rows="10" class="form-control">{{ $post->post }}</textarea>
        </div>
        @error('post')
        <div class="text-danger">{{ $message }}</div>
        @enderror
        <button class="btn btn-warning" type="submit">Сохранить</button>
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
