@extends('xadmin.layouts.default')
@section('content')

    <div class="bg-white p-4 rounded-lg shadow-md w-full lg:max-w-3xl mx-auto">

        <div class="mb-3 relative">
            <h3 class="text-lg font-semibold">Kaydı Düzenle</h3>
            <div class="text-sm text-gray-400">*'lı alanlar zorunludur</div>
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


        <form action="{{ route('userUpdatePost') }}" method="post">
            @csrf


            <div class="mx-auto max-w-[600px] grid grid-cols-2 gap-6">
                <div class="form-group mb-3">
                    <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Ad*</label>
                    <div class="mt-2">
                        <input id="name" name="name" type="text" value="{{ $data->name }}" required
                            class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="surname" class="block text-sm font-medium leading-6 text-gray-900">Soyad*</label>
                    <div class="mt-2">
                        <input id="surname" name="surname" type="text" value="{{ $data->surname }}" required
                            class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email*</label>
                    <div class="mt-2">
                        <input id="email" name="email" type="email" value="{{ $data->email }}" required
                            class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="phone" class="block text-sm font-medium leading-6 text-gray-900">Telefon</label>
                    <div class="mt-2">
                        <input id="phone" name="phone" type="text" value="{{ $data->phone }}"
                            class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="user_type_id" class="block text-sm font-medium leading-6 text-gray-900">Üye Tipi*</label>
                    <div class="mt-2">
                        <select id="user_type_id" name="user_type_id" required
                            class="select2 px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            @foreach ($types as $item)
                                <option value="{{ $item->id }}"
                                    {{ $data && $data->user_type_id == $item->id ? 'selected' : '' }}>{{ $item->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="statu" class="block text-sm font-medium leading-6 text-gray-900">Durum*</label>
                    <div class="mt-2">
                        <select id="statu" name="statu" required
                            class="select2 px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            <option value="0" {{ $data->statu == 0 ? 'selected' : '' }}>Pasif</option>
                            <option value="1" {{ $data->statu == 1 ? 'selected' : '' }}>Aktif</option>
                        </select>
                    </div>
                </div>

                <div class="form-group flex justify-end col-span-2">
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    <button class="bg-orange-600 hover:bg-orange-700 text-white rounded-md px-3 py-1"
                        type="submit">Kaydet</button>
                </div>
            </div>

        </form>
    </div>



    <div class="bg-white p-4 rounded-lg shadow-md w-full lg:max-w-3xl mx-auto mt-5 text-sm">

        <div class="mb-3 relative">
            <h3 class="text-lg font-semibold">Diğer İşlemler</h3>
        </div>

        <a href="{{ route('userUpdatePasswordGet', ['id' => $data->id]) }}"
            class="bg-blue-500 text-white px-2 py-2 rounded-lg sm:px-4 sm:py-2 sm:rounded-md mr-2 hover:bg-blue-600 focus:outline-none focus:bg-blue-600 inline-block">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-5 h-5 block sm:hidden">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
            </svg>
            <span class="hidden sm:inline-block">Şifresini Değiştir</span>
        </a>
        @if (Auth()->user()->id != $data->id)
            <a href="{{ route('loginAsUser', ['id' => $data->id]) }}"
                class="isdelete bg-purple-500 text-white px-2 py-2 rounded-lg sm:px-4 sm:py-2 sm:rounded-md mr-2 hover:bg-purple-600 focus:outline-none focus:bg-purple-600 inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5 block sm:hidden">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                <span class="hidden sm:inline-block">Bununla Giriş Yap</span>
            </a>
        @endif
        <a href="{{ route('userDelete', ['id' => $data->id]) }}"
            class="isdelete bg-red-500 text-white px-2 py-2 rounded-lg sm:px-4 sm:py-2 sm:rounded-md mr-2 hover:bg-red-600 focus:outline-none focus:bg-red-600 inline-block">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 block sm:hidden">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
            </svg>
            <span class="hidden sm:inline-block">Kullanıcıyı Sil</span>
        </a>
    </div>

    <div class="bg-white p-4 rounded-lg shadow-md w-full lg:max-w-3xl mx-auto mt-5 text-sm">
        <div class="mb-3 relative">
            <h3 class="text-lg font-semibold">Menü İşlemleri</h3>
        </div>
        <a href="{{ route('panel_menus.index') }}"
            class="bg-red-500 text-white px-2 py-2 rounded-lg sm:px-4 sm:py-2 sm:rounded-md mr-2 hover:bg-red-600 focus:outline-none focus:bg-red-600 inline-block">
            <span class="hidden sm:inline-block">Düzenle</span>
        </a>
    </div>


@endsection
