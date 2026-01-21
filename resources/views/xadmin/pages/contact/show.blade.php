
@extends('xadmin.layouts.default')
@section('content')

<div class="bg-white p-4 rounded-lg shadow-md w-full lg:max-w-3xl mx-auto">

        <div class="mb-3 relative">
            <h3 class="text-lg font-semibold">Mesaj Detayı</h3>
            <p class="text-gray-600">Bu mesaj sistem tarafından okundu olarak işaretlenecektir.</p>
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

 
       


            <div class="mx-auto grid grid-cols-1 md:grid-cols-3 gap-10 mt-10 max-w-[600px]">
               
                <div class="form-group">
                    <strong class="text-sm font-medium">Ad Soyad</strong>
                    <div class="form-floating">
                        <p>{{ $data ? $data->title : '' }}</p>
                    </div>
                </div>
                <div class="form-group">
                    <strong class="text-sm font-medium">Email</strong>
                    <div class="form-floating">
                        <p>{{ $data ? $data->email : '' }}</p>
                    </div>
                </div>
                <div class="form-group">
                    <strong class="text-sm font-medium">Konu</strong>
                    <div class="form-floating">
                        <p>{{ $data ? $data->subject : '' }}</p>
                    </div>
                </div>
                <div class="form-group">
                    <strong class="text-sm font-medium">Tarih</strong>
                    <div class="form-floating">
                        <p>{{ $data ? $data->created_at->translatedFormat('d M, Y') : '' }}</p>
                    </div>
                </div>
                <div class="form-group">
                    <strong class="text-sm font-medium">Saat</strong>
                    <div class="form-floating">
                        <p>{{ $data ? $data->created_at->translatedFormat('H:i:s') : '' }}</p>
                    </div>
                </div>
                <div class="form-group col-span-3">
                    <strong class="text-sm font-medium">Mesaj</strong>
                    <div class="form-floatinxg">
                        <p>{{ $data ? $data->message : '' }}</p>
                    </div>
                </div>
                
            </div>

 
    </div>
@endsection


 