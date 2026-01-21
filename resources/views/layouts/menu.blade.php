<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="ltr">

<head>
    @include('inc_menu.head')
    @include('inc_menu.css')
</head>

<body class="bg-gray-100">


    @yield('content')


    @include('inc_menu.js')
    @stack('scripts')
</body>

</html>