<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;

class ThemeController extends Controller
{
    public function setTheme($theme)
    {
        Cookie::queue('theme', $theme, 43200); // 30 gün (30 * 24 * 60)
        return back();
    }

    public function getTheme()
    {
        return Cookie::get('theme', 'light'); // Varsayılan olarak 'light'
    }
}
