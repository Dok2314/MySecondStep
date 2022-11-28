<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class VersionObserver
{
    public function created()
    {
        Cache::forget('version');
    }
}
