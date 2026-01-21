@php
    $siteurl = Request::root();
    $sitename = 'raqoonhotel';
    $anotherLang = app()->getLocale() == 'tr' ? 'en' : 'tr';
    $logo = "/public/assets/images/raqoonlogo.svg";
@endphp
<meta charset="UTF-8">
<title>{{ $metaData['title'] }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<meta name="robots" content="index, follow" />
<link rel="alternate" hreflang="{{ $anotherLang }}" href="{{ $siteurl . '/' . $anotherLang }}" />
<meta name="description" content="{{ $metaData['description'] }}" />
<meta name="keywords" content="{{ $metaData['keywords'] }}" />
<meta name="author" content="{{ $sitename }}" />
<link rel="canonical" href="{{ Request::url() }}" />

<!-- Social Media Metadata -->
<meta property="og:type" content="{{ Route::current()->getName() == 'homepage' ? 'website' : 'article' }}" />
<meta property="og:title" content="{{ $metaData['title'] }}" />
<meta property="og:description" content="{{ $metaData['description'] }}" />
<meta property="og:url" content="{{ Request::url() }}" />
<meta property="og:site_name" content="{{ $sitename }}" />
<meta property="og:locale" content="{{ app()->getLocale() . '_' . strtoupper(app()->getLocale()) }}" />
@if ($image)
    <meta property="og:image" content="{{ $image }}" />
    <meta property="og:image:width" content="739" />
    <meta property="og:image:height" content="492" />
@else
    <meta property="og:image" content="{{ $siteurl }}/{{ $logo }}" />
    <meta property="og:image:width" content="100" />
    <meta property="og:image:height" content="100" />
@endif

 

<link rel="apple-touch-icon" sizes="57x57" href="{{ asset('assets/favicon/apple-icon-57x57.png') }}">
<link rel="apple-touch-icon" sizes="60x60" href="{{ asset('assets/favicon/apple-icon-60x60.png') }}">
<link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets/favicon/apple-icon-72x72.png') }}">
<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/favicon/apple-icon-76x76.png') }}">
<link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets/favicon/apple-icon-114x114.png') }}">
<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/favicon/apple-icon-120x120.png') }}">
<link rel="apple-touch-icon" sizes="144x144" href="{{ asset('assets/favicon/apple-icon-144x144.png') }}">
<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/favicon/apple-icon-152x152.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicon/apple-icon-180x180.png') }}">
<link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('assets/favicon/android-icon-192x192.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/favicon/favicon-96x96.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon/favicon-16x16.png') }}">
<link rel="icon" href="{{ asset('assets/favicon.ico') }}" type="image/x-icon">
<link rel="shortcut icon" href="{{ asset('assets/favicon/favicon.ico') }}">
<link rel="manifest" href="{{ asset('assets/favicon/manifest.json') }}">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="{{ asset('assets/favicon/ms-icon-144x144.png') }}">
<meta name="theme-color" content="#ffffff">
    


<!-- Twitter Card Metadata -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="{{ $metaData['title'] }}" />
<meta name="twitter:description" content="{{ $metaData['description'] }}" />
<meta name="twitter:image" content="{{ $image ?? $siteurl . '/' . $logo }}" />

<!-- Favicon and Icons -->
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicon/apple-icon-180x180.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon/favicon-16x16.png') }}">
<link rel="manifest" href="{{ asset('assets/favicon/manifest.json') }}">
<meta name="theme-color" content="#ffffff">

<!-- Schema.org JSON-LD -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "{{ Route::current()->getName() == 'homepage' ? 'WebPage' : 'Article' }}",
  "name": "{{ $metaData['title'] }}",
  "description": "{{ $metaData['description'] }}",
  "url": "{{ Request::url() }}",
  "image": {
    "@type": "ImageObject",
    "url": "{{ $image ?? $siteurl . '/' . $logo }}",
    "width": "739",
    "height": "492"
  },
  "author": {
    "@type": "Organization",
    "name": "{{ $sitename }}",
    "url": "{{ $siteurl }}"
  },
  "publisher": {
    "@type": "Organization",
    "name": "{{ $sitename }}",
    "logo": {
      "@type": "ImageObject",
      "url": "{{ $siteurl }}/{{ $logo }}",
      "width": "100",
      "height": "100"
    }
  },
  "datePublished": "{{ $metaData['datePublished'] ?? now()->toIso8601String() }}",
  "dateModified": "{{ $metaData['dateModified'] ?? now()->toIso8601String() }}",
  "keywords": "{{ $metaData['keywords'] }}",
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "{{ $siteurl }}"
  }
}
</script>


<!-- Analytics Tracking -->
{!! Helper::getSettingMessage('google_analytics_tracking_code') !!}

<!-- Styles -->
@include('includes.css')
