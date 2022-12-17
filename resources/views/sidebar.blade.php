<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 250px; height: 1260px;">
    <ul class="nav nav-pills flex-column mb-auto">
        @if(!Route::is('profile.adminProfile'))
            @can('admin-view', \App\Http\Controllers\AdminController::class)
                <li class="nav-item mb-2">
                    <a href="{{ route('profile.adminProfile') }}" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
                        {{ __('main.admin_sidebar') }}
                    </a>
                </li>
            @endcan
        @endif
        @if(!Route::is('profile.index'))
            <li class="nav-item mb-2">
                <a href="{{ route('profile.index') }}" class="nav-link active" aria-current="page">
                    <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
                    {{ __('main.profile_sidebar') }}
                </a>
            </li>
        @endif
        @if(!Route::is('posts.index'))
            <li class="nav-item mb-2">
                <a href="{{ route('posts.index') }}" class="nav-link active" aria-current="page">
                    <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
                    {{ __('main.my_posts_sidebar') }}
                </a>
            </li>
        @endif
        @if(!Route::is('weather'))
            <li class="nav-item">
                <a href="{{ route('weather') }}" class="nav-link active" aria-current="page">
                    <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
                    {{ __('main.weather_sidebar') }}
                </a>
            </li>
        @endif
    </ul>
</div>
