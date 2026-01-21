@extends('xadmin.layouts.default')
@section('content')
    @php
        $tdClass = 'px-2 border border-gray-300';
    @endphp


    <div class="bg-white p-4 rounded-lg shadow-md w-full lg:max-w-6xl mx-auto">
        <div class="flex flex-wrap justify-between items-center">
            <h3 class="text-lg font-semibold mb-3">Çeviriyi Düzenle </h3>
            <a href="{{ route('translate_index') }}"
                class="bg-orange-600 hover:bg-orange-700 text-white rounded-md px-3 py-1">Listeye Dön</a>
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

        <!-- Yeni Çeviri Ekleme Formu -->
        <form action="{{ route('translate.update.post') }}" method="POST">
            @csrf

            <input type="hidden" name="id" value="{{ $id }}">

            <!-- Çeviri Anahtarı -->
            <div class="form-group mb-3">
                <label for="key" class="block text-sm font-medium leading-6 text-gray-900">Çeviri Anahtarı*</label>
                <input type="text" id="key" value="{{ $data->key }}" name="key" required
                    class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            </div>

            <!-- Çeviri Metni -->
            <div class="form-group mb-3">
                <label for="value" class="block text-sm font-medium leading-6 text-gray-900">Çeviri Metni*</label>

                @if (Request::get('editor'))
                    <textarea id="value" name="value" required
                        class="content px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">{{ $data->value }}</textarea>
                @else
                    <input id="value" name="value" required value="{{ $data->value }}"
                        class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                @endif




            </div>


            <div class="form-group mb-3">
                <label for="next" class="block text-sm font-medium leading-6 text-gray-900">Sonraki Kayıttan Devam
                    et</label>
                <input type="checkbox" id="next" {{ old('next') ? 'checked' : '' }} name="next">
            </div>

            <!-- Kaydet Butonu -->
            <div class="form-group flex justify-end gap-3">
                @if (request()->get('pass_id') && $nextTranslation2)
                    <a href="{{ route('translate.edit', ['id' => request()->get('pass_id'), 'pass_id' => $nextTranslation2->id]) }}"
                        class="bg-orange-600 hover:bg-orange-700 text-white rounded-md px-3 py-1">Atla</a>
                @endif


                <button class="bg-blue-600 hover:bg-blue-700 text-white rounded-md px-3 py-1" type="submit">Kaydet</button>
            </div>

            <iframe class="mt-10" height="500" width="100%" src="https://www.bing.com/translator"></iframe>

        </form>
    </div>

@endsection
