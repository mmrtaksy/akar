@extends('xadmin.layouts.default')
@section('content')


    <div class="bg-white p-4 rounded-lg shadow-md w-full lg:max-w-6xl mx-auto">


        <div class="mb-3 relative flex items-center justify-between">
            <h3 class="text-lg font-semibold">Menü Listesi</h3>
            <a class="text-md text-blue-600 font-medium inline-block" href="{{ route('panel_menus.create') }}">Yeni bir tane
                ekle</a>
        </div>



        @if (session('success'))
            <div class="bg-green-600 text-white px-3 py-1 rounded-sm text-sm my-3">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-600 text-white px-3 py-1 rounded-sm text-sm my-3">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-600 text-white px-3 py-1 rounded-sm text-sm my-3">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif



        <div class="relative overflow-x-auto lg:overflow-visible max-w-full">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" id="tableList">
                <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 border border-gray-300">Başlık</th>
                        <th class="px-4 py-2 border border-gray-300">Durum</th>
                        <th class="px-4 py-2 border border-gray-300" width="200">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($menus as $menu)
                        <tr>
                            <td class="border px-4 py-2">{{ $menu->title }}</td>
                            <td class="border px-4 py-2">{{ $menu->statu ? 'Aktif' : 'Pasif' }}</td>
                            <td class="border px-4 py-2">

                                <a href="{{ route('panel_menus.edit', ['id' => $menu->id]) }}"
                                    class="bg-green-500 text-white px-2 py-2 rounded-lg sm:px-4 sm:py-2 sm:rounded-md hover:bg-green-600 focus:outline-none focus:bg-green-600 inline-block">
                                    Düzenle
                                </a>

                                <a href="{{ route('panel_menus.delete', ['id' => $menu->id]) }}"
                                    class="isdelete bg-red-500 text-white px-2 py-2 rounded-lg sm:px-4 sm:py-2 sm:rounded-md mr-2 hover:bg-red-600 focus:outline-none focus:bg-red-600 inline-block">
                                    Sil
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection
