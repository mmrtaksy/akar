@php
    use App\Models\Languages;

    $langId = Languages::where('native', request()->segment(1))->value('id');
@endphp
@extends('layouts.menu', (array) $metaData)

@section('content')


    <div class="w-full bg-white shadow sticky top-0 z-50">

        <div class="container mx-auto px-4 py-3 flex items-center justify-between">
            <!-- Dil Değiştir Butonu -->

            <div class="relative">
                <a href="@localizedRoute('homepage')"
                    class="relative flex items-center gap-1 text-sm font-medium text-gray-600 hover:text-black transition">

                    <svg width="80px" height="80px" class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M11.7071 4.29289C12.0976 4.68342 12.0976 5.31658 11.7071 5.70711L6.41421 11H20C20.5523 11 21 11.4477 21 12C21 12.5523 20.5523 13 20 13H6.41421L11.7071 18.2929C12.0976 18.6834 12.0976 19.3166 11.7071 19.7071C11.3166 20.0976 10.6834 20.0976 10.2929 19.7071L3.29289 12.7071C3.10536 12.5196 3 12.2652 3 12C3 11.7348 3.10536 11.4804 3.29289 11.2929L10.2929 4.29289C10.6834 3.90237 11.3166 3.90237 11.7071 4.29289Z"
                            fill="#000000" />
                    </svg>
                </a>
            </div>

            <!-- Başlık -->
            <div class="relative">
                <img src="{{ asset('assets/images/raqoonlogo.svg') }}" class="w-[130px] md:w-[200px]" width="200" height="70" alt="{{ env('APP_BRAND') }}"
                    title="{{ env('APP_BRAND') }}">
            </div>

            <!-- Boşluk (Dil butonu ile başlığı ortalamak için) -->
            <div class="relative">
                @if (app()->getLocale() == 'tr')
                    <a href="/en/menu"
                        class="relative flex items-center gap-1 text-sm font-medium text-gray-600 hover:text-black transition">
                        <svg width="80px" height="80px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 text-gray-500">
                            <path
                                d="M21 12C21 16.9706 16.9706 21 12 21C9.69494 21 7.59227 20.1334 6 18.7083L3 16M3 12C3 7.02944 7.02944 3 12 3C14.3051 3 16.4077 3.86656 18 5.29168L21 8M3 21V16M3 16H8M21 3V8M21 8H16"
                                stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        EN
                    </a>
                @else
                    <a href="/tr/menu"
                        class="relative flex items-center gap-1 text-sm font-medium text-gray-600 hover:text-black transition">
                        <svg width="80px" height="80px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 text-gray-500">
                            <path
                                d="M21 12C21 16.9706 16.9706 21 12 21C9.69494 21 7.59227 20.1334 6 18.7083L3 16M3 12C3 7.02944 7.02944 3 12 3C14.3051 3 16.4077 3.86656 18 5.29168L21 8M3 21V16M3 16H8M21 3V8M21 8H16"
                                stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        TR
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="container mx-auto max-w-4xl px-1 md:p-4 pb-20 mb-40">
        <div class="space-y-2">


            <!-- Kategoriler -->
            @foreach ($pageData as $item)
                <div class="bg-white rounded shadow scroll-mt-28" id="menu-block-{{ $item->id }}">
                    <button
                        class="load-category w-full px-4 py-5 flex justify-between items-center text-left hover:bg-gray-50 rounded-lg focus:outline-none transition-all"
                        data-id="{{ $item->id }}">
                        <span class="font-bold uppercase text-base sm:text-lg">{{ $item->title }}</span>
                        <span id="icon-{{ $item->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 stroke-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m7-7H5" />
                            </svg>
                        </span>
                    </button>

                    <div id="category-{{ $item->id }}" class="menu-content grid grid-cols-2 md:grid-cols-3 gap-2"></div>
                </div>
            @endforeach




        </div>
    </div>

    <!-- Alt Sabit Bar -->
    <div class="fixed bottom-0 left-0 w-full bg-white shadow-[0_-2px_10px_rgba(0,0,0,0.05)] border-t border-gray-200 z-50">
        <div class="flex justify-around items-center py-2">
            <a href="@localizedRoute('homepage')"
                class="flex flex-col items-center text-gray-500 hover:text-blue-600 transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 9l9-7 9 7v11a2 2 0 01-2 2h-4a2 2 0 01-2-2V13H9v7a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                </svg>
                <span class="text-xs">Anasayfa</span>
            </a>
            <a href="#" class="flex flex-col items-center text-gray-500 hover:text-blue-600 transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <span class="text-xs">Menü</span>
            </a>
            <a href="#" id="openSearchModal"
                class="flex flex-col items-center text-gray-500 hover:text-blue-600 transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <span class="text-xs">Ara</span>
            </a>
        </div>
    </div>



    <div id="searchModal" class="hidden">
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white  max-w-lg mx-auto w-full relative rounded p-1">
                <button id="closeSearchModal" class="absolute top-2 right-2">✕</button>
                <input type="text" id="searchInput" class="w-full border p-2 mb-4 outline-none" placeholder="Ürün ara...">
                <ul id="searchResults" class="space-y-2"></ul>
            </div>
        </div>
    </div>

    <div id="productModal" class="hidden">
        <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50">
            <div class="bg-white  max-w-lg mx-auto w-full relative rounded">
                <div id="productModalContent" class="shadow rounded"></div>
            </div>
        </div>
    </div>

    <input type="hidden" id="lang" value="{{ $langId }}">

@endsection