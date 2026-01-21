@php
    use App\Models\Languages;
    use App\Models\Seo;

    // $mainMenu = Category::whereNull('parent_id')->with('sub')->orderBy('id', 'asc')
    //     ->limit(5)
    //     ->get();

    $lang = Languages::where('native', app()->getLocale())->value('id');



    $seo = Seo::where('id', 1)->first();

    $social = Helper::social();

    $isData = isset($metaData->title) ? $metaData : null;
    $metaData = Helper::generateSeoMeta($isData);



@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="ltr">

<head>
    @include('includes.head', ['data' => $metaData, 'image' => $image])
</head>

<body>

    <div class="page-wrapper">


        <!-- Preloader -->
        <div class="preloader"></div>

        @include('includes.header')
        @yield('content')
        @include('includes.footer', ['social' => $social])



    </div>

    @include('includes.js')
    @stack('scripts')
</body>

</html>