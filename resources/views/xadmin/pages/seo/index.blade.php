

@extends('xadmin.layouts.default')
@section('content')

<div class="bg-white p-4 rounded-lg shadow-md w-full lg:max-w-3xl mx-auto">

        <div class="mb-3 relative">
            <h3 class="text-lg font-semibold">SEO Ayarları</h3>
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


        <form action="{{ route('seo_update') }}" method="post">


            <div class="mx-auto max-w-[600px]">

                    
                <div class="form-group mb-3">
                    <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Meta Title</label>
                    <div class="mt-2">
                        <input type="text" name="meta_title" class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        value="{{ $data ? $data->meta_title : '' }}"> 
                    </div>
                </div>


                <div class="form-group mb-3"> 
                    <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Meta Description</label>
                    <div class="mt-2">
                        <input type="text" name="meta_description" 
                        class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            value="{{ $data ? $data->meta_description : '' }}">  
                    </div>
                </div>


                <div class="form-group mb-3">
                    <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Meta Keywords</label>
                    <div class="mt-2">
                        <input type="text" name="meta_keywords"
                        placeholder="örnek: tag,tag,tag"
                        class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        value="{{ $data ? $data->meta_keywords : '' }}">
                    </div>
                </div>


                <div class="form-group mb-3">
                    <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Title Prefix (Ön Ek)</label>
                    <div class="mt-2">
                        <input type="text" name="title_prefix" class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            value="{{ $data ? $data->title_prefix : '' }}">
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Title Suffix (Uç Ek)</label>
                    <div class="mt-2">
                        <input type="text" name="title_suffix" class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            value="{{ $data ? $data->title_suffix : '' }}">
                    </div>
                </div>



                
                <div class="form-group mb-3 flex justify-end">
                    <button class="bg-orange-600 hover:bg-orange-700 text-white rounded-md px-3 py-1" type="submit">Kaydet</button>
                </div>
            </div>


        </form>
    </div>
@endsection




 