@extends('xadmin.layouts.default')
@section('content')
@php
    $tdClass = 'px-2 border border-gray-300';
@endphp

<div class="bg-white p-4 rounded-lg shadow-md w-full lg:max-w-6xl mx-auto">

        
        <div class="mb-3 relative flex items-center justify-between">
            <h3 class="text-lg font-semibold">Mesajlar</h3>
        </div>




        <div class="relative overflow-x-auto max-w-full">
          <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" id="tableList">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                <tr>
                    <th class="px-4 py-2 border border-gray-300 max-w-14">#</th>
                    <th class="px-4 py-2 border border-gray-300">Ad Soyad</th>
                    <th class="px-4 py-2 border border-gray-300">Email</th>
                    <th class="px-4 py-2 border border-gray-300">Okundu</th>
                    <th class="px-4 py-2 border border-gray-300">Konu</th>
                    <th class="px-4 py-2 border border-gray-300">Mesaj</th>
                    <th class="px-4 py-2 border border-gray-300">Gönderim Tarihi</th>
                    <th class="px-4 py-2 border border-gray-300" width="200">İşlemler</th>
                </tr>
              </thead>
              <tbody>
                  @foreach ($data as $item)
                  <tr>
                      <td class="{{ $tdClass }}">{{ $item->id }}</td>
                      <td class="{{ $tdClass}}">{{ $item->title }}</td> 
                      <td class="{{ $tdClass}}">{{ $item->email }}</td> 
                      <td class="{{ $tdClass}}">
                      @if($item->read)
                      <span class="px-3 py-1 text-sm rounded-full bg-green-500 text-white">Okundu</span>
                      @else
                      <span class="px-3 py-1 text-sm rounded-full bg-gray-200">Okunmadı</span>
                      @endif
                      </td> 
                     
                      <td class="{{ $tdClass}}">{{ $item->subject }}</td> 
                      <td class="{{ $tdClass}}">{{ Str::substr($item->message, 0, 100) }}...</td> 
                      <td class="{{ $tdClass}}">{{ $item->created_at }}</td>

                      <td class="{{ $tdClass}} text-center">
                        <div class="flex items-center gap-3 p-3">
                 

                        <a href="{{ route('messagesShow', ['id' => $item->id]) }}" class="bg-green-500 text-white px-2 py-2 rounded-lg sm:px-4 sm:py-2 sm:rounded-md hover:bg-green-600 focus:outline-none focus:bg-green-600 inline-block">
                            İncele
                          </a> 
                          
                          <a href="{{ route('messagesDelete', ['id' => $item->id]) }}" class="isdelete bg-red-500 text-white px-2 py-2 rounded-lg sm:px-4 sm:py-2 sm:rounded-md mr-2 hover:bg-red-600 focus:outline-none focus:bg-red-600 inline-block">
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

     

    </div>


@endsection

 