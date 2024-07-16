<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class LanguageController extends Controller
{
    public function setLanguage($code): RedirectResponse
    {
        Log::info($code);
        if (in_array($code, ['en', 'tr'])) {
            Cookie::queue('locale', $code, 60 * 24 * 365); // 1 year expiration
            App::setLocale($code);
        }

        return redirect()->back();
    }
}
