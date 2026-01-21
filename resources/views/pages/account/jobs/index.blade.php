@php
    use Carbon\Carbon;
@endphp
@extends('pages.account.layout')
@section('account_content')

    <h5 class="text-lg font-semibold mb-4 flex justify-between items-center"> <span>{{ __('main.ad_list') }}</span>
        <a href="@localizedRoute('userJobCreateGet')" class="text-white text-sm p-1 px-3 rounded-md bg-orange-600 hover:bg-orange-700">{{ __('main.add_new_ad') }}</a>
    </h5>


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



    <div class="data_list w-full p-3">

        @foreach ($data as $item)


        <div class="group relative mt-6 p-3 border-2 border-gray-200 dark:border-gray-700 rounded-md">
            <div class="flex w-full justify-between items-start">
                <div class="left_wrap flex-1">
                        <h5 class="text-lg font-medium mb-0">{{ $item->title }}</h5>
                        @if (Helper::CalcJobLeftDay($item->end_at) != 0)
                        <span class="text-slate-500 dark:text-gray-300 block text-sm my-2">Onay Durumu: {!! $item->approve_statu ? '<span class="bg-green-500 text-white px-2 rounded-full">Onaylandı</span>' : '<span class="bg-gray-500 text-white px-2 rounded-full">Beklemede</span>' !!}</span>
                        <span class="text-slate-500 dark:text-gray-300 block text-sm my-2">Öne Çıkarıldı: {!! $item->is_featured ? '<span class="bg-green-500 text-white px-2 rounded-full">Evet</span>' : '<span class="bg-gray-500 text-white px-2 rounded-full">Hayır</span>' !!}</span>
                        <div class="flex flex-col w-full">
                            <span class="text-slate-500 block text-xs">Oluşturma tarihi: {{ date_format( $item->created_at,"d.m.Y H:i") }}</span>
                            <span class="text-slate-500 block text-xs">Bitiş tarihi: {{ date_format( Carbon::parse($item->end_at), "d.m.Y H:i") }}</span>
                            <span class="text-slate-500 block text-xs">Kalan gün: {{ Helper::CalcJobLeftDay($item->end_at) }}</span>
                            <span class="text-slate-500 block text-xs">Referans: {{ $item->reference_code }}</span>
                        </div>
                        @else
                        <span class="text-slate-500 block text-sm">Süresi dolduğu için ilan yayından kaldırılmıştır</span>
                        @endif
                </div>

                <ul class="buy-button list-none mb-0">
                    <li class="dropdown inline-block relative ps-1">
                        <button data-dropdown-toggle="dropdown" class="dropdown-toggle items-center" type="button">
                            <i class="uil uil-setting align-middle text-lg text-gray-400 group-hover:text-orange-600"></i>
                        </button>
                        <div class="dropdown-menu absolute end-0 m-0 mt-4 z-10 w-44 rounded-md overflow-hidden bg-white dark:bg-slate-900 shadow dark:shadow-gray-700 hidden" onclick="event.stopPropagation();">
                            <ul class="text-start">
                                <li>
                                    <a href="@localizedRoute('userJobUpdateGet', ['id' => $item->id])" class="flex items-center font-medium py-2 px-4 text-gray-400 hover:text-gray-500 dark:text-white/70  dark:hover:text-white">İlanı düzenle</a>
                                </li>
                                <li>
                                    <a href="@localizedRoute('userJobShow', ['slug' => $item->slug])" class="flex items-center font-medium py-2 px-4 text-gray-400 hover:text-gray-500 dark:text-white/70  dark:hover:text-white">İlanı görüntüle</a>
                                </li>
                                <li>
                                    <a href="@localizedRoute('userJobSetFeatured', ['id' => $item->id])" class="flex items-center font-medium py-2 px-4 text-gray-400 hover:text-gray-500 dark:text-white/70  dark:hover:text-white">{{ $item->is_featured ? 'İlanı öne çıkarma' : 'İlanı öne çıkar' }}</a>
                                </li>
                                <li>
                                    <a href="@localizedRoute('userJobDeleteGet', ['id' => $item->id])" class="_confirm flex items-center font-medium py-2 px-4 text-gray-400 hover:text-gray-500 dark:text-white/70  dark:hover:text-white">İlanı sil</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>

            </div>
        </div>

        @endforeach

        @if (!$data->count())
            <div class="wrapper_no_data w-full p-3">
                <span class="text-gray-400 text-center block">{{ __('main.not_yet_publish_ad') }}</span>
            </div>
        @endif


    </div>

@endsection
