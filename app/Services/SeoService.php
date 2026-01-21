<?php

namespace App\Services;

use Illuminate\Support\Str;

class SeoService
{
    public function make_slug($title)
    {
        // "and", "the", "ve", "&" ifadelerini başta veya sonda olduğu durumda kaldırıyoruz
        $title = strtolower($title);
        $title = preg_replace('/\b(and|the|ve|&)\b/', '', $title);
    
        // Çift boşlukları tek boşluğa indirgeme
        $title = preg_replace('/\s+/', ' ', $title);
    
        // Slug yapısını oluşturma
        $slug = Str::slug(trim($title));
    
        return $slug;
    }
}
