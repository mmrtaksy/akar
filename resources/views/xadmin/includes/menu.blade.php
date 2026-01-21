@php
    $items = Helper::panelMenu();
    $menu = 'block py-2 px-4 hover:bg-gray-800 toggleMenu';
    $menuSingle = 'block py-2 px-4 hover:bg-gray-800';
    $submenu = 'block py-2 px-4 text-gray-300 hover:text-white text-sm';
    $ul = 'relative left-0 hidden pl-3 bg-gray-700 shadow-md w-full';
@endphp

<aside class="bg-gray-900 text-gray-300 min-h-screen w-full max-w-64 -left-full lg:left-0 absolute lg:relative z-20"
    id="sidebar">
    <ul class="py-4">
        <li>
            <a href="{{ route('home') }}" class="block py-2 px-4 hover:bg-gray-800">Dashboard</a>
        </li>

        @foreach ($items as $item)
            @if ($item['statu'])
                <li class="relative group">
                    <a href="javascript:void(0)" class="{{ $menu }}">
                        <div class="flex gap-2 items-center">
                            <span class="size-2 bg-red-400 rounded-full"></span>
                            <span>{{ $item['title'] }}</span>
                        </div>
                    </a>
                    <ul class="{{ $ul }}">
                        <li>
                            <a href="{{ route('servicesList', ['lang' => 1, 'model_id' => $item['id']]) }}"
                                class="{{ $submenu }}">Listele</a>
                        </li>
                        <li>
                            <a href="{{ route('servicesCreateGet', ['lang' => 1, 'model_id' => $item['id']]) }}"
                                class="{{ $submenu }}">Yeni Ekle</a>
                        </li>
                        <li>
                            <a href="{{ route('servicesSortGet', ['lang' => 1, 'model_id' => $item['id']]) }}"
                                class="{{ $submenu }}">Sırala</a>
                        </li>
                    </ul>
                </li>
            @endif
        @endforeach



        {{-- <li class="relative group">
            <a href="javascript:void(0)" class="{{ $menu }}">Galeri</a>
            <ul class="{{ $ul }}">
                <li>
                    <a href="{{ route('galleryList') }}" class="{{ $submenu }}">Listele</a>
                </li>
                <li>
                    <a href="{{ route('galleryCreateGet') }}" class="{{ $submenu }}">Yeni Ekle</a>
                </li> 
            </ul>
        </li> --}}

        {{-- <li class="relative group">
            <a href="javascript:void(0)" class="{{ $menu }}">Dil Yönetimi</a>
            <ul class="{{ $ul }}">
                <li>
                    <a href="{{ route('languagesList') }}" class="{{ $submenu }}">Listele</a>
                </li>
                <li>
                    <a href="{{ route('languagesCreateGet') }}" class="{{ $submenu }}">Yeni Ekle</a>
                </li>
            </ul>
        </li> --}}

        {{-- <li class="relative">
            <a href="{{ route('settingsIndex') }}" class="{{ $menuSingle }}">Ayarlar</a>
        </li> --}}

        <li class="relative">
            <a href="{{ route('translate_index') }}" class="{{ $menuSingle }}">Çeviriler</a>
        </li>

        <li class="relative">
            <a href="{{ route('seo_page') }}" class="{{ $menuSingle }}">SEO</a>
        </li>

        <li class="relative group">
            <a href="javascript:void(0)" class="{{ $menu }}">Kullanıcılar</a>
            <ul class="{{ $ul }}">
                <li>
                    <a href="{{ route('userList') }}" class="{{ $submenu }}">Listele</a>
                </li>
                <li>
                    <a href="{{ route('userCreateGet') }}" class="{{ $submenu }}">Yeni Ekle</a>
                </li>
                <li>
                    <a href="{{ route('usertypeList') }}" class="{{ $submenu }}">Kullanıcı Tipleri</a>
                </li>
            </ul>
        </li>



    </ul>

    </ul>
</aside>
