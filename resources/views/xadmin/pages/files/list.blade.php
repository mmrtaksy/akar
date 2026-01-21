@extends('xadmin.layouts.default')
@section('content')
@php
    $tdClass = 'px-2 border border-gray-300';
@endphp

<div class="bg-white p-4 rounded-lg shadow-md w-full lg:max-w-6xl mx-auto">

        
        <div class="mb-3 relative flex items-center justify-between">
            <h3 class="text-lg font-semibold">Belge Listesi</h3>
            <a class="text-md text-blue-600 font-medium inline-block" href="{{ route('filesCreateGet') }}">Yeni bir tane ekle</a>
        </div>


        <div class="mb-3 relative flex items-center gap-3">
          @foreach(Helper::langs() as $lang)
          <a href="{{ route('filesList', ['listlang' => $lang->id]) }}" class="{{ $lang->id == $listlang ? 'bg-green-600' : 'bg-gray-500' }} text-white px-4 rounded-full sm:py-1 hover:bg-green-600 focus:outline-none focus:bg-green-700 inline-block">
            {{ strtoupper($lang->native) }}
          </a>
          @endforeach
        </div>


        <div class="relative overflow-x-auto max-w-full">
          <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" id="tableList">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                <tr>
                    <th class="px-4 py-2 border border-gray-300 max-w-14">#</th>
                    <th class="px-4 py-2 border border-gray-300">Başlık</th> 
                    <th class="px-4 py-2 border border-gray-300">Belge</th>
                    <th class="px-4 py-2 border border-gray-300">Durum</th>
                    <th class="px-4 py-2 border border-gray-300">Yayın Tarihi</th>
                    <th class="px-4 py-2 border border-gray-300">Güncellenme Tarihi</th>
                    <th class="px-4 py-2 border border-gray-300" width="200">İşlemler</th>
                </tr>
              </thead>
              <tbody>
                  @foreach ($data as $item)
                  <tr>
                      <td class="{{ $tdClass }}">{{ $item->id }}</td>
                      <td class="{{ $tdClass}}">{{ $item->title }}</td> 
                      <td class="{{ $tdClass}}">
                        <a href="{{ asset('uploads/' . $item->image) }}" target="_blank">{{ $item->image }}</a>  
                      </td> 
                      <td class="{{ $tdClass}}">{{ $item->statu == 1 ? 'Yayında' : 'Taslak' }}</td>
                      <td class="{{ $tdClass}}">{{ $item->created_at }}</td>
                      <td class="{{ $tdClass}}">{{ $item->updated_at }}</td>

                      <td class="{{ $tdClass}} text-center">
                        <div class="flex items-center gap-3 p-3">
                 

                        <a href="{{ route('filesUpdateGet', ['id' => $item->id, 'lang' => $listlang]) }}" class="bg-green-500 text-white px-2 py-2 rounded-lg sm:px-4 sm:py-2 sm:rounded-md hover:bg-green-600 focus:outline-none focus:bg-green-600 inline-block">
                            Düzenle
                          </a> 
                          
                          <a href="{{ route('filesDelete', ['id' => $item->id]) }}" class="isdelete bg-red-500 text-white px-2 py-2 rounded-lg sm:px-4 sm:py-2 sm:rounded-md mr-2 hover:bg-red-600 focus:outline-none focus:bg-red-600 inline-block">
                            Sil
                          </a>
                        </div>
                      </td>

                  </tr>
                  @endforeach

                  <!-- Diğer satırları buraya ekle -->
              </tbody>
            </table>
            <div class="flex justify-end">
                {{ $data->links() }}
            </div>
        </div>

        @if(!$data->count())
            <div class="text-center mt-5">
                <div class="text-sm text-gray-400">Veri bulunamadı</div>
                <a class="text-md text-blue-600 font-medium mt-5 inline-block" href="{{ route('filesCreateGet') }}">Yeni bir tane ekle</a>
            </div>
        @endif

    </div>


@endsection
