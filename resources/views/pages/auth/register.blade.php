@extends('layouts.default', ['title' => 'Yeni Hesap Oluştur', 'image' => ''])

@section('content')



<section class="min-h-screen py-24 flex flex-wrap items-center justify-center relative overflow-hidden bg-no-repeat bg-center bg-cover">
    <div class="absolute inset-0 bg-gradient-to-b to-orange-800 from-black"></div>
    <div class="container">
        <div class="flex flex-col items-center">

            <h2 class="text-white text-center my-10 text-4xl font-extralight">{!! __('main.login_title') !!}</h2>

            <div class="relative w-full md:max-w-xl overflow-hidden dark:text-white bg-white dark:bg-gray-900 shadow-md dark:shadow-gray-800 rounded-md">
                <div class="p-6">

                    <img src="{{ asset('assets/images/logo-dark.png') }}" class="mx-auto h-[40px] block dark:hidden" alt="">
                    <img src="{{ asset('assets/images/logo-light.png') }}" class="mx-auto h-[40px] dark:block hidden" alt="">

                    @if (session('success'))
                        <div class="bg-green-700 my-8 text-center text-white">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                    <div class="bg-red-700 my-8 text-center text-white">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="text-start" action="@localizedRoute('registerPost')" method="post">
                        <div class="grid grid-cols-2">
                            <h5 class="my-6 col-span-2 text-sm text-center font-semibold text-orange-600">{!! __('main.form_title_1') !!}</h5>
                            <div class="mb-4 text-start px-2">
                                <label class="font-semibold text-sm" for="name">{{ __('main.form_label_name') }}*</label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" class="px-2 block w-full border border-1 border-gray-200  dark:bg-gray-800 dark:border-gray-800 py-1 mt-1 rounded-md" required>
                            </div>
                            <div class="mb-4 text-start px-2">
                                <label class="font-semibold text-sm" for="surname">{{ __('main.form_label_surname') }}*</label>
                                <input id="surname" type="text" name="surname" value="{{ old('surname') }}" class="px-2 block w-full border border-1 border-gray-200  dark:bg-gray-800 dark:border-gray-800 py-1 mt-1 rounded-md" required>
                            </div>
                            <div class="mb-4 text-start px-2">
                                <label class="form-label font-medium">{{ __('main.form_label_country') }}</label>
                                <select name="country_id" data-url="countrysearch" data-selected="226" id="country_id" class="select2ajax px-2 block w-full border border-1 border-gray-200  dark:bg-gray-800 dark:border-gray-800 py-1 mt-1 rounded-md">
                                    @if($currentCountry)
                                        <option value="{{ $currentCountry->id }}">{{ $currentCountry->name }}</option>
                                    @endif
                                </select>
                            </div>
                            <div class="mb-4 text-start px-2">
                                <label class="font-semibold text-sm" for="phone">{{ __('main.form_label_phone') }}*</label>
                                <input id="phone" type="phone" name="phone" value="{{ old('phone') }}" class="px-2 block w-full border border-1 border-gray-200  dark:bg-gray-800 dark:border-gray-800 py-1 mt-1 rounded-md phone" required>
                            </div>
                            <div class="mb-4 text-start px-2 col-span-2">
                                <label class="font-semibold text-sm" for="email">{{ __('main.form_label_email') }}*</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" class="px-2 block w-full border border-1 border-gray-200  dark:bg-gray-800 dark:border-gray-800 py-1 mt-1 rounded-md" required>
                            </div>
                            <div class="mb-4 text-start px-2">
                                <label class="font-semibold text-sm" for="password">{{ __('main.form_label_password') }}*</label>
                                <input id="password" type="password" name="password" class="px-2 block w-full border border-1 border-gray-200  dark:bg-gray-800 dark:border-gray-800 py-1 mt-1 rounded-md" required>
                            </div>
                            <div class="mb-4 text-start px-2">
                                <label class="font-semibold text-sm" for="password_confirmation">{{ __('main.form_label_repassword') }}*</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" class="px-2 block w-full border border-1 border-gray-200  dark:bg-gray-800 dark:border-gray-800 py-1 mt-1 rounded-md" required>
                            </div>

                            <div class="text-start px-2 col-span-2">
                                <p class="text-xs">{{ __('main.form_subinfo') }}</p>
                            </div>

                            <h5 class="my-6 col-span-2 text-sm text-center font-semibold text-orange-600">{{ __('main.form_title_2') }}</h5>

                            <div class="mb-4 text-start px-2 col-span-2">
                                <label class="font-semibold text-sm" for="company_name">{{ __('main.form_label_company') }}*</label>
                                <input id="company_name" type="text" name="company_name" value="{{ old('company_name') }}" class="px-2 block w-full border border-1 border-gray-200  dark:bg-gray-800 dark:border-gray-800 py-1 mt-1 rounded-md" required>
                            </div>

                            <div class="mb-4 text-start px-2 col-span-2">
                                <label class="font-semibold text-sm" for="company_about">{{ __('main.form_label_company_description') }}*</label>
                                <textarea id="company_about" rows="4" name="company_about" class="px-2 block w-full border border-1 border-gray-200  dark:bg-gray-800 dark:border-gray-800 py-1 mt-1 rounded-md" required>{{ old('company_about') }}</textarea>
                                <p class="text-xs text-center mt-1">{{ __('main.form_label_company_sort_text') }}</p>
                            </div>

                            <div class="col-span-2 text-center mb-4">
                                <div class="g-recaptcha flex justify-center" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}"></div>
                            </div>

                            <div class="col-span-2 text-center text-sm">
                                <a href="{{ Helper::getPage(9, true) }}" class="px-1 text-gray-500 hover:text-gray-700 dark:hover:text-gray-400" target="_blank">{{ __('main.form_term_text_1') }}</a>
                                <span>{{ __('main.and') }}</span>
                                <a href="{{ Helper::getPage(7, true) }}" class="px-1 text-gray-500 hover:text-gray-700 dark:hover:text-gray-400" target="_blank">{{ __('main.form_term_text_2') }}</a>
                            </div>
                            <div class="col-span-2 text-center text-sm mb-4">
                                <label for="agree">
                                    <input type="checkbox" name="agree" required id="agree"> {{ __('main.form_term_agree') }}
                                </label>
                            </div>

                            <div class="mb-4 col-span-2 text-center">
                                <input type="submit" class="btn cursor-pointer py-2 bg-orange-600 hover:bg-orange-700 border-orange-600 hover:border-orange-700 text-white rounded-md w-full" value="{{ __('main.form_register') }}">
                            </div>

                            <div class="col-span-2 text-center mb-4">
                                <span class="text-gray-400">{{ __('main.have_account') }} </span> <a href="@localizedRoute('loginGet')" class="text-black dark:text-white font-bold">{{ __('main.login') }}</a>
                            </div>
 
                        </div>
                    </form>
                </div>


            </div>

        </div>
    </div>
</section>



@endsection



@push('scripts')
    @once
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endonce
@endpush
