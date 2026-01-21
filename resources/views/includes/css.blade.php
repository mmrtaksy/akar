

<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}?v={{ Helper::cacheCssVersion(env('APP_ASSET_CACHE')) }}">
<link rel="stylesheet" href="{{ asset('assets/css/animations.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}"> 

@stack('styles')