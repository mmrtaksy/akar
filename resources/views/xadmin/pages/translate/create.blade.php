@extends('xadmin.layouts.default')
@section('content')
    @php
        $tdClass = 'px-2 border border-gray-300';
    @endphp


    <div class="bg-white p-4 rounded-lg shadow-md w-full lg:max-w-6xl mx-auto">
        <h3 class="text-lg font-semibold mb-3">Yeni Çeviri Ekle</h3>

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

        <!-- Yeni Çeviri Ekleme Formu -->
        <form action="{{ route('translate.create.post') }}" method="POST">
            @csrf


            <!-- Çeviri Anahtarı -->
            <div class="form-group mb-3">
                <label for="key" class="block text-sm font-medium leading-6 text-gray-900">Çeviri Anahtarı*</label>
                <input type="text" id="key" name="key" required
                    class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            </div>

            <!-- Çeviri Metni -->
            <div class="form-group mb-3">
                <label for="value" class="block text-sm font-medium leading-6 text-gray-900">Çeviri Metni*</label>
                @if (Request::get('editor'))
                    <textarea id="value" name="value" required
                        class="content px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                @else
                    <input id="value" name="value" required
                        class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                @endif

            </div>

            <!-- Kaydet Butonu -->
            <div class="form-group flex justify-end">
                <button class="bg-blue-600 hover:bg-blue-700 text-white rounded-md px-3 py-1" type="submit">Ekle</button>
            </div>
        </form>
    </div>

@endsection
