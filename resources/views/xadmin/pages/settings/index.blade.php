@extends('xadmin.layouts.default')
@section('content')
@php
    $tdClass = 'px-2 border border-gray-300';
@endphp

    <div class="bg-white p-4 rounded-lg shadow-md w-full lg:max-w-6xl mx-auto">


        <div class="mb-3 relative flex items-center justify-between">
            <h3 class="text-lg font-semibold">Ayarlar</h3>
            <a class="text-md text-blue-600 font-medium mt-5 inline-block" href="{{ route('settingsCreateGet') }}">Yeni bir tane ekle</a>
        </div>

        
        @if (session('success'))
            <div class="bg-green-600 text-white px-3 py-1 rounded-sm text-sm my-3">
                {{ session('success') }}
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


        <div class="relative overflow-x-auto max-w-full">
          <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" id="tableList">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                <tr>
                    <th class="px-4 py-2 border border-gray-300">Eylem</th>
                    <th class="px-4 py-2 border border-gray-300">Durum</th>
                    <th class="px-4 py-2 border border-gray-300">Açıklama</th>
                    <th class="px-4 py-2 border border-gray-300" width="200">İşlemler</th>
                </tr>
              </thead>
              <tbody>
                  @foreach ($data as $key => $item)
                  <tr>
                      <td class="{{ $tdClass }}">{{ isset($item['name']) ? $item['name'] : '' }}</td>
                      <td class="{{ $tdClass}}">
                          @if($item['name'] == 'slider_image' || $item['name'] == 'cover_image')
                            <img src="{{ asset('covers/' . $item['value']) }}" class="h-16 my-2 object-cover">
                          @else
                          {{ strip_tags($item['value']) }}
                          @endif
                      
                      </td>
                      <td class="{{ $tdClass}}">{{ $item['description'] }}</td>
                      <td class="{{ $tdClass}} text-center">
                        <div class="flex items-center gap-1 p-3">
                          <a href="{{ route('settingsUpdateGet', ['id' => $key]) }}" class="bg-green-500 text-white px-2 py-2 rounded-lg sm:px-4 sm:py-2 sm:rounded-md mr-2 hover:bg-green-600 focus:outline-none focus:bg-green-600 inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 block sm:hidden">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                            <span class="hidden sm:inline-block">Düzenle</span>
                          </a>
                          
                          <a href="{{ route('settingsDelete', ['id' => $key]) }}" class="isdelete bg-red-500 text-white px-2 py-2 rounded-lg sm:px-4 sm:py-2 sm:rounded-md mr-2 hover:bg-red-600 focus:outline-none focus:bg-red-600 inline-block">
                            Sil
                          </a>
                        </div>
                      </td>
                  </tr>
                  @endforeach

                  <!-- Diğer satırları buraya ekle -->
              </tbody>
            </table>
          
        </div>

   

    </div>


@endsection
