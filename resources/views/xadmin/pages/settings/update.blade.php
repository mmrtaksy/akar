
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


        <form action="{{ route('settingsUpdateSet') }}" method="post" enctype="multipart/form-data">
            @csrf


            <div class="mx-auto max-w-[600px]">
            
                <div class="form-group mb-3">
                    <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Eylem*</label>
                    <div class="mt-2">
                        <input id="name" name="name" type="text" disabled value="{{ $data && isset($data['name']) ? $data['name'] : old('name') }}" required class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        <div class="text-right">
                            <a href="#" class="text-sm font-semibold" id="openkey">Kilidi aç</a>
                        </div>
                    </div>
                </div>
                @if(isset($data['name']) && $data['name'] == 'slider_image')
                <div class="form-group mb-3">
                    <label for="image" class="block text-sm font-medium leading-6 text-gray-900">Durum*</label>
                    <div class="mt-2">
                        <input id="image" name="image" type="file" required class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>
                @else
                <div class="form-group mb-3">
                    <label for="value" class="block text-sm font-medium leading-6 text-gray-900">Durum*</label>
                    <div class="mt-2">
                        <textarea id="value" name="value" type="text" required class="content px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            {{ $data ? $data['value'] : old('value') }}
                        </textarea>
                    </div>
                </div>
                @endif
                <div class="form-group mb-3">
                    <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Açıklama</label>
                    <div class="mt-2">
                        <input id="description" name="description" type="text" value="{{ $data ? $data['description'] : old('description') }}"   class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>


                <div class="form-group flex justify-end">
                    <input type="hidden" name="id" value="{{ $id }}">
                    <button class="bg-orange-600 hover:bg-orange-700 text-white rounded-md px-3 py-1" type="submit">Kaydet</button>
                </div>
            </div>


        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $('#openkey').on('click', function(){
                $('#name').removeAttr('disabled').focus();
            })
        })
    </script>
@endpush
