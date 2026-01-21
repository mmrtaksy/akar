<html lang="tr" dir="ltr">
<head>
    @include('xadmin.includes.head')
</head>

<body>
    @auth
        @include('xadmin.includes.header')
    @endauth
    <main class="p-2 lg:p-8 flex-auto bg-gray-100">
        @yield('content')
    </main>
    @auth
        @include('xadmin.includes.footer')
    @endauth
</body>

</html>
