@extends('xadmin.layouts.default')
@section('content')
@php
    $tdClass = 'px-2 border border-gray-300';
@endphp

    <div class="bg-white p-4 rounded-lg shadow-md w-full mx-auto">

    

        <div class="relative flex items-center justify-between">
            <h3 class="text-lg font-semibold">Kullanıcılar Listesi</h3>
            <a class="text-md text-blue-600 font-medium mt-5 inline-block" href="{{ route('userCreateGet') }}">Yeni bir tane ekle</a>
        </div>
 

        <div class="mb-5 relative flex items-center gap-2"> 
            <a class="text-md inline-block bg-lime-600 text-white px-2 py-1 rounded-sm tab" id="tab1" href="javascript:void(0);">Kullanıcılar</a>
            <a class="text-md inline-block bg-gray-500 text-white px-2 py-1 rounded-sm tab" id="tab2" href="javascript:void(0);">Adminler</a>
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

      



        <div class="relative overflow-x-auto max-w-full">
          <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" id="tableList">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                <tr>
                    <th class="px-4 py-2 border border-gray-300">
                        <a href="?order=id" class="flex justify-between items-center">
                            <span>#</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                            </svg>
                        </a> 
                    </th>
                    <th class="px-4 py-2 border border-gray-300">Ad Soyad</th>
                    <th class="px-4 py-2 border border-gray-300">Email</th>
                    <th class="px-4 py-2 border border-gray-300">Telefon</th>  
                    <th class="px-4 py-2 border border-gray-300">
                        <a href="?order=user_type_id" class="flex justify-between items-center">
                            <span>Statü</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                            </svg>
                        </a> 
                    </th>
                    <th class="px-4 py-2 border border-gray-300" width="200">İşlemler</th>
                </tr>
              </thead>
              <tbody id="tab1" class="contentx">
                  @foreach ($dataUsers as $item)
                  <tr>
                      <td class="{{ $tdClass }}">{{ $item->id }}</td>
                      <td class="{{ $tdClass}}">{{ $item->name . ' ' . $item->surname }}</td>
                      <td class="{{ $tdClass}}">{{ $item->email }}</td>
                      <td class="{{ $tdClass}}">{{ $item->phone }}</td>  
                      
                      <td class="{{ $tdClass}}">
                        @if($item->user_type_id == 1)
                            <span class="bg-green-500 px-2 rounded-full text-white  font-medium">Admin</span>
                        @else
                        <span class="bg-gray-500 px-2 rounded-full text-white font-medium">Kullanıcı</span>
                        @endif
                        </td>
                      <td class="{{ $tdClass}} text-center">
                        <div class="flex flex-wrap items-center gap-1 p-3">
                          <a href="{{ route('userUpdateGet', ['id' => $item->id]) }}" class="bg-green-500 text-white px-2 py-2 rounded-lg sm:px-4 sm:py-2 sm:rounded-md mr-2 hover:bg-green-600 focus:outline-none focus:bg-green-600 inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 block sm:hidden">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                              </svg>
                            <span class="hidden sm:inline-block">Düzenle</span>
                          </a>
                        </div>
                      </td>
                  </tr>
                  @endforeach

                  <!-- Diğer satırları buraya ekle -->
              </tbody>
              <tbody id="tab2" class="contentx" style="display:none;">
                  @foreach ($dataAdmins as $item)
                  <tr>
                      <td class="{{ $tdClass }}">{{ $item->id }}</td>
                      <td class="{{ $tdClass}}">{{ $item->name . ' ' . $item->surname }}</td>
                      <td class="{{ $tdClass}}">{{ $item->email }}</td>
                      <td class="{{ $tdClass}}">{{ $item->phone }}</td>
                      
                      <td class="{{ $tdClass}}">
                        @if($item->user_type_id == 1)
                            <span class="bg-green-500 px-2 rounded-full text-white  font-medium">Admin</span>
                        @else
                        <span class="bg-gray-500 px-2 rounded-full text-white font-medium">Kullanıcı</span>
                        @endif
                        </td>
                      <td class="{{ $tdClass}} text-center">
                        <div class="flex flex-wrap items-center gap-1 p-3">
                          <a href="{{ route('userUpdateGet', ['id' => $item->id]) }}" class="bg-green-500 text-white px-2 py-2 rounded-lg sm:px-4 sm:py-2 sm:rounded-md mr-2 hover:bg-green-600 focus:outline-none focus:bg-green-600 inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 block sm:hidden">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                              </svg>
                            <span class="hidden sm:inline-block">Düzenle</span>
                          </a>
                        </div>
                      </td>
                  </tr>
                  @endforeach

                  <!-- Diğer satırları buraya ekle -->
              </tbody>
            </table>
        </div>


        <div class="flex justify-end pagination mt-3 tab1">
            {{ $dataUsers->links() }}
        </div>

        <div class="flex justify-end pagination mt-3 tab2" style="display:none;">
            {{ $dataAdmins->links() }}
        </div>

    </div>


@endsection

@push('scripts')
    <script>
        $(function(){
            $('.tab').on('click', function(){
                let id = $(this).attr('id');
                $('.contentx').hide();
                $('#' + id +'.contentx').show();

                $('.pagination').hide();
                $('.' + id + '.pagination').show();

                $('.tab').removeClass('bg-lime-600').addClass('bg-gray-500');
                $(this).removeClass('bg-gray-500').addClass('bg-lime-600');

                return false;
            })
        })
    </script>
@endpush