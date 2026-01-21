@extends('xadmin.layouts.default')
@section('content')

<div class="bg-white p-4 rounded-lg shadow-md w-full lg:max-w-3xl mx-auto">

        <div class="mb-3 relative">
            <h3 class="text-lg font-semibold">Kaydı Düzenle - <span class="bg-green-600 text-white px-1 text-sm">{{ $locale->name }}</span></h3>
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


        <form action="{{ route('filesUpdatePost') }}" method="post" enctype="multipart/form-data">
            @csrf


            <div class="mx-auto max-w-[600px]">
                <div class="form-group mb-3">
                    <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Başlık*</label>
                    <div class="mt-2">
                        <input id="title" name="title" type="text" value="{{ $data->title }}" required class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>
         
                <div class="form-group mb-3">
                    <label for="statu" class="block text-sm font-medium leading-6 text-gray-900">Durum*</label>
                    <div class="mt-2">
                        <select id="statu" name="statu" required class="select2 px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            <option value="0" {{ $data->statu == 0 ? 'selected' : '' }}>Taslak</option>
                            <option value="1" {{ $data->statu == 1 ? 'selected' : '' }}>Yayınla</option>
                        </select>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="image" class="block text-sm font-medium leading-6 text-gray-900">Belge</label>
                    <div class="mt-2">
                        <input id="image" name="image" accept="file/*" type="file" class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>
                @if ($data->image)
                    <div class="form-group mb-3">
                        <label for="image" class="block text-sm font-medium leading-6 text-gray-900">{{ $data->image }}</label> 
                    </div>
                @endif
             
                <div class="form-group flex justify-end">
                    @if($data->id)
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    @endif
                    <input type="hidden" name="lang" value="{{ $locale->id }}">
                    <button class="bg-orange-600 hover:bg-orange-700 text-white rounded-md px-3 py-1" type="submit">Kaydet</button>
                </div>
            </div>


        </form>
    </div>
@endsection
