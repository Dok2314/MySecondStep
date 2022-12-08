@extends('layouts.main')

@section('title', 'Мои посты')

@section('header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                 <!-- Modal -->
                 <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog">
                         <div class="modal-content">
                             <div class="modal-header">
                                 <h5 class="modal-title" id="exampleModalLabel">Список уведомлений:</h5>
                                 <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                     <span aria-hidden="true">&times;</span>
                                 </button>
                             </div>
                             <div class="modal-body" id="modal-body">
                                 @if(isset($notifications))
                                      @forelse($notifications as $notification)
                                          <div class="alert alert-success" role="alert">
                                              <a href="#" class="float-right mark-as-read" style="text-decoration: none;" data-id="{{ $notification->id }}">
                                                  Х
                                              </a>

                                              @if($notification->type == 'App\Notifications\PostCreatedNotification')
                                                  [{{ $notification->created_at }}] Пользователь <b>{{ $notification->data['user_name'] }}</b> создал пост
                                                  <b>{{ $notification->data['title'] }}</b>
                                              @else
                                                  Пользователь <b>{{ $notification->data['name'] }}</b>
                                                  совершил вход на сайт в
                                                  [{{ $notification->created_at }}]
                                              @endif
                                          </div>

                                          @if($loop->last)
                                              <a href="#" id="mark-all" style="text-decoration: none;">
                                                  Отметить все как прочитаное
                                              </a>
                                          @endif
                                      @empty
                                          Уведомлений пока нет
                                      @endforelse
                                 @endif
                             </div>
                         </div>
                     </div>
                 </div>
                     <button type="button" class="border-0 bg-transparent" data-bs-toggle="modal" data-bs-target="#exampleModal" style="float: right;">
                         <i class="fa-solid fa-bell" style="font-size: 50px; float: right">
                            {{ $notifications->count() }}
                         </i>
                     </button>
             </div>
         </div>
    </div>
@endsection

@push('styles')
    <style>
        #modal-body
        {
            overflow:scroll;
            max-height: 500px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function sendMarkRequest(id = null) {
            return $.ajax("{{ route('markNotification') }}", {
                method: 'POST',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    id
                }
            });
        }
        $(function() {
            $('.mark-as-read').click(function() {
                let request = sendMarkRequest($(this).data('id'));
                request.done(() => {
                    $(this).parents('div.alert').remove();
                });
            });
            $('#mark-all').click(function() {
                let request = sendMarkRequest();
                request.done(() => {
                    $('div.alert').remove();
                })
            });
        });
    </script>
@endpush
