<!-- Basic Page Needs -->
<meta charset="utf-8" />
<title>Admin Panel</title>

<!-- Mobile Specific Metas -->
<meta
    name="viewport"
    content="width=device-width, initial-scale=1, maximum-scale=1"
/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{ asset('libs/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css">
@if(env('IS_LOCAL'))
<link rel="stylesheet" href="{{ Request::root() }}{{ mix('css/app.css') }}">
@else 
<link rel="stylesheet" href="{{ Request::root() }}/public{{ mix('css/app.css') }}">
@endif

<link href="{{ asset('panel/assets/css/nestable.css') }}" rel="stylesheet" />
<link href="{{ asset('panel/assets/css/css.css') }}" rel="stylesheet" />

@stack('styles')
