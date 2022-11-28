<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\VersionCollection;
use App\Http\Resources\VersionResource;
use App\Models\Version;
use Illuminate\Support\Facades\Cache;

class
IndexController extends Controller
{
    public function index()
    {
        return new VersionResource(Cache::remember('version', 60 * 60 * 24, function () {
            return Version::orderByDesc('release_date')->first();
        }));
    }

    public function all()
    {
        return new VersionCollection(Cache::remember('versions', 60 * 60 * 24, function () {
            return Version::all();
        }));
    }
}
