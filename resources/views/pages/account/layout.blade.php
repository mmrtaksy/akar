@php
    $data = Helper::account()
@endphp

@extends('layouts.default', ['title' => $data->name . ' ' . $data->surname, 'image' => ''])
@section('content')

<section class="relative lg:pt-24 pt-[74px] pb-16 bg-gray-100 dark:bg-gray-900 min-h-screen">
    <div class="lg:container container-fluid">
        <div class="profile-banner relative text-transparent">
            <div class="relative shrink-0">
                <img src="{{ asset('cover-bg.png') }}" class="h-64 w-full object-cover lg:rounded-xl shadow dark:shadow-gray-700" alt="">
            </div>
        </div>

        <div class="md:flex mx-4 -mt-12">
            <div class="md:w-full">
                <div class="relative flex flex-col md:flex-row justify-between items-center w-full ">
                    <div class="lefter_wrap flex items-center">
                        <div class="profile-pic text-center">
                            <div>
                                <div class="relative size-28 max-w-[112px] max-h-[112px] mx-auto">
                                    @if($data->company->info->avatar)
                                    <img src="{{ asset('avatars/' . $data->company->info->avatar) }}" class="rounded-full shadow bg-white dark:shadow-gray-800 ring-4 ring-slate-50 dark:ring-slate-800 size-28 object-cover">
                                    @else
                                    <div class="rounded-full shadow dark:shadow-gray-800 ring-4 w-28 h-28 bg-gray-700 ring-slate-50 dark:ring-slate-800"></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="ms-4 mt-14 lefter_content">
                            <h5 class="text-2xl font-semibold dark:text-white">{{ $data->company->info->title }}</h5>
                            <p class="text-slate-400">{{ $data->name . ' ' . $data->surname }}</p>
                        </div>
                    </div>
                    <div class="righter_wrap">
                        <div class="relative text-center flex gap-5 mt-14 dark:text-white">
                            <div class="wr_box">
                                <div class="text-3xl font-semibold">{{ $data->total_ad_quantity }}</div>
                                <span>{{ __('main.total_ad_quantity') }}</span>
                            </div>
                            <div class="wr_box">
                                <div class="text-3xl font-semibold">{{ $data->total_feature_ad_quantity }}</div>
                                <span>{{ __('main.total_feature_ad_quantity') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!--end -->

    <div class="container mt-16">
        <div class="grid lg:grid-cols-12 grid-cols-1 gap-[30px]">

            @include('components.leftmenu')

            <div class="lg:col-span-9">

                @if (!$data->company->info->isactive)
                    <div class="bg-blue-600 text-white px-4 py-2 rounded-md mb-3">
                        {{ __('main.company_pending_statu') }}
                    </div>
                @endif

                @if (!Helper::isBillFilled() || !Helper::isCompanyFilled())
                    <div class="bg-red-600 text-white px-4 py-2 rounded-md mb-3">
                        {{ __('main.filled_text') }}
                    </div>
                @endif

                <div class="p-6 rounded-lg shadow  text-black dark:text-white dark:shadow-gray-800 bg-white dark:bg-slate-800">
                    @yield('account_content')
                </div>
            </div>

        </div>
    </div>
</section>
<!-- End Hero -->

@endsection
