@extends('xadmin.layouts.default')
@section('content')
@php
    $tdClass = 'px-2 border border-gray-300';
@endphp

<div class="bg-white p-4 rounded-lg shadow-md w-full mx-auto"> 
    <div class="mb-3 relative flex items-center justify-between">
        <h3 class="text-lg font-semibold">Çeviriler</h3>
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
    
 
    <div class="flex flex-wrap lg:flex-nowrap gap-4 justify-center">
    @foreach ($data as $group)
    
    <div class="relative overflow-x-auto max-w-full mb-10">
       <div class="mb-5 flex items-center gap-3">
              <span class="bg-green-600 inline-block  text-white rounded-md px-3 py-1">{{ $group['language']->name }} </span>
              @if($group['language']->is_default)
              <span class="bg-blue-500 inline-block  text-white rounded-md px-3 py-1">Default </span>
              <a href="{{ route('translate.create.get') }}" class="bg-orange-600 inline-block hover:bg-orange-700 text-white rounded-md px-3 py-1">Yeni Ekle</a>
              <a href="{{ route('translate.create.get') }}?editor=true" class="bg-orange-600 inline-block hover:bg-orange-700 text-white rounded-md px-3 py-1">Editör ile Ekle</a>
              <form action="{{ route('translate_index') }}" method="GET" class="mb-0">
                <input type="text" placeholder="Listelerde ara..." value="{{ Request::get('q') ?? '' }}" name="q" class="border-2 border-gray-200 px-2 py-1 rounded-md">
              </form>
             @endif
            </div>
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" id="tableList">
          <thead class="text-xs text-gray-700 uppercase bg-gray-200">
              <tr>
                  <th class="px-4 py-2 border border-gray-300 max-w-14">#</th>
                  <th class="px-4 py-2 border border-gray-300">Anahtar</th>
                  <th class="px-4 py-2 border border-gray-300">Çeviri</th> 
                  <th class="px-4 py-2 border border-gray-300" width="200">İşlemler</th>
              </tr>
            </thead>
            <tbody>
                 

            
                @foreach ($group['translations'] as $item)
                <tr>
                    <td class="{{ $tdClass }}">{{ $item->id }}</td>
                    <td class="{{ $tdClass }}">{{ $item->key }}</td>
                    <td class="{{ $tdClass }}">{{ $item->value }}</td> 

                    <td class="{{ $tdClass}} text-center">
                      <div class="flex items-center gap-3 p-3">
               
                        <a href="{{ route('translate.edit', $item->id) }}" class="bg-green-500 text-white px-2 py-2 rounded-lg sm:px-4 sm:py-2 sm:rounded-md hover:bg-green-600 focus:outline-none focus:bg-green-600 inline-block">Düzenle</a> 
                        <a href="{{ route('translate.edit', $item->id) }}?editor=true" class="bg-green-500 text-white px-2 py-2 rounded-lg sm:px-4 sm:py-2 sm:rounded-md hover:bg-green-600 focus:outline-none focus:bg-green-600 inline-block">Editör</a> 
                        <a href="{{ route('translate.delete', $item->id) }}" class="isdelete bg-red-500 text-white px-2 py-2 rounded-lg sm:px-4 sm:py-2 sm:rounded-md mr-2 hover:bg-red-600 focus:outline-none focus:bg-red-600 inline-block">Sil</a>
                      </div>
                    </td>

                </tr>
                @endforeach
 
            </tbody>
          </table>


          
        <div class="mt-3">
            {{ $group['translations']->links('vendor.pagination.bootstrap') }} 
        </div>

         
      </div>
 
    @endforeach
</div>

</div>
@endsection
