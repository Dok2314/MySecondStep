@extends('layouts.main')

@section('title', 'Оставить коментарий')

@section('header')
    @include('includes.defaultHeader')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="{{ route('homePage') }}">
                                <button class="btn btn-warning btn-sm">
                                    Вернуться ко всем постам
                                </button>
                            </a>
                        </div>
                        <div class="col-md-8">
                            Коментарии к посту "<strong style="color: green;">{{ $post->title }}</strong>"
                        </div>
                    </div>
                </div>
                <section style="background-color: #eee;">
                    @foreach($comments as $comment)
                        <div class="container my-2 py-2">
                            <div class="row d-flex justify-content-center">
                                <div class="col-md-12 col-lg-10 col-xl-8">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex flex-start align-items-center">
                                                {{--                                                <img class="rounded-circle shadow-1-strong me-3"--}}
                                                {{--                                                     src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(19).webp" alt="avatar" width="60"--}}
                                                {{--                                                     height="60" />--}}
                                                <div>
                                                    <h6 class="fw-bold text-primary mb-1">{{ $comment->user->name }}</h6>
                                                    <p class="text-muted small mb-0">
                                                        Created: {{ $comment->created_at->toDateString() }}
                                                    </p>
                                                </div>
                                            </div>

                                            <p class="mt-3 mb-4 pb-2">
                                                {!! $comment->comment !!}
                                            </p>

                                            <div class="small d-flex justify-content-start">
                                                <a href="#!" class="d-flex align-items-center me-3">
                                                    <i class="far fa-thumbs-up me-2"></i>
                                                    <p class="mb-0">Like</p>
                                                </a>
                                                <a href="#!" class="d-flex align-items-center me-3">
                                                    <i class="far fa-comment-dots me-2"></i>
                                                    <p class="mb-0">Comment</p>
                                                </a>
                                                <a href="#!" class="d-flex align-items-center me-3">
                                                    <i class="fas fa-share me-2"></i>
                                                    <p class="mb-0">Share</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </section>

            </div>
            <div class="col-md-4">
                <h4>Оставить комментарий</h4>
                <form action="{{ route('comments.store') }}" method="post" class="form-control">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <div class="form-group mb-3">
                        <label for="title">Заголовок</label>
                        <input type="text" name="title" id="title" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="editor">Комментарий</label>
                        <textarea name="comment" id="editor" cols="30" rows="10" class="form-control">{{ old('comment') }}</textarea>
                    </div>
                    <button class="btn btn-primary btn-sm">Добавить</button>
                </form>
            </div>
        </div>
    </div>
    <div>
        {{ $comments->withQueryString()->links('vendor.pagination.bootstrap-4') }}
    </div>
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
