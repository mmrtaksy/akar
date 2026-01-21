@extends('xadmin.layouts.default')
@section('content')

<div class="bg-white p-4 rounded-lg shadow-md w-full lg:max-w-3xl mx-auto">

        <div class="mb-3 relative">
            <h3 class="text-lg font-semibold">Yeni Kayıt Oluştur</h3>
            <div class="text-sm text-gray-400">*'lı alanlar zorunludur</div>
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


        <form action="{{ route('userCreatePost') }}" method="post">
            @csrf


            <div class="mx-auto max-w-[600px] grid grid-cols-2 gap-6">
                <div class="form-group mb-3">
                    <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Ad*</label>
                    <div class="mt-2">
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="surname" class="block text-sm font-medium leading-6 text-gray-900">Soyad*</label>
                    <div class="mt-2">
                        <input id="surname" name="surname" type="text" value="{{ old('surname') }}" required class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email*</label>
                    <div class="mt-2">
                        <input id="email" name="email" type="email" autocomplete="off" value="{{ old('email') }}" required class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="phone" class="block text-sm font-medium leading-6 text-gray-900">Telefon</label>
                    <div class="mt-2">
                        <input id="phone" name="phone" type="text" value="{{ old('phone') }}" class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="user_type_id" class="block text-sm font-medium leading-6 text-gray-900">Üye Tipi*</label>
                    <div class="mt-2">
                        <select id="user_type_id" name="user_type_id" required class="select2 px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            @foreach ($types as $item)
                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
         
 
                <div class="form-group mb-3">
                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Şifre*</label>
                    <div class="mt-2">
                        <input id="password" name="password" autocomplete="off" type="password" required class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="statu" class="block text-sm font-medium leading-6 text-gray-900">Durum*</label>
                    <div class="mt-2">
                        <select id="statu" name="statu" required class="select2 px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            <option value="0">Pasif</option>
                            <option value="1" selected>Aktif</option>
                        </select>
                    </div>
                </div>


                <div class="form-group flex items-center w-full justify-end">
                    <button class="bg-orange-600 hover:bg-orange-700 text-white rounded-md px-3 py-1" type="submit">Kaydet</button>
                </div>
            </div>


        </form>
    </div>
@endsection
