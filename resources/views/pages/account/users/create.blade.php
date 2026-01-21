@extends('pages.account.layout')
@section('account_content')


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


    <h5 class="text-lg font-semibold mb-4">{{ __('main.create_new_user') }}</h5>
    <form method="POST" action="@localizedRoute('account_userCreatePost')">
        @csrf
        <div class="grid lg:grid-cols-12 md:grid-cols-2 grid-cols-1 gap-4">
            <div class="lg:col-span-4">
                <label class="form-label font-medium">{{ __('main.form_label_name') }} <span class="text-red-600">*</span></label>
                <input type="text" class="px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md" id="name" name="name" required="">
            </div>

            <div class="lg:col-span-4">
                <label class="form-label font-medium">{{ __('main.form_label_surname') }}  <span class="text-red-600">*</span></label>
                <input type="text" class="px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md" id="surname" name="surname" required="">
            </div>

            <div class="lg:col-span-4">
                <label class="form-label font-medium">{{ __('main.form_label_gender') }} </label>
                <select name="gender" id="gender" class="select2 px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                    <option value="0">{{ __('main.no_gender') }} </option>
                    <option value="1">{{ __('main.gender_man') }} </option>
                    <option value="2">{{ __('main.gender_woman') }} </option>
                </select>
            </div>

            <div class="lg:col-span-4">
                <label class="form-label font-medium">{{ __('main.form_label_email') }}  <span class="text-red-600">*</span></label>
                <input type="email" class="px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md" name="email" required="">
            </div>


            <div class="lg:col-span-4">
                <label class="form-label font-medium">{{ __('main.form_label_country') }}  <span class="text-red-600">*</span></label>
                <select name="country_id" data-url="countrysearch" id="country_id" class="select2ajax px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                    <option value="{{ $countryTR->id }}" selected>{{ $countryTR->name }}</option>
                </select>
            </div>


            <div class="lg:col-span-4">
                <label class="form-label font-medium">{{ __('main.form_label_phone') }}  <span class="text-red-600">*</span></label>
                <input type="phone" class="px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 phone rounded-md" name="phone" required="">
            </div>
            
        </div><!--end grid-->

        <div class="grid grid-cols-1">
            <div class="mt-5">
                <label class="form-label font-medium">{{ __('main.about') }} </label>
                <textarea name="about" id="about" rows="5" class="px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-2 mt-1 rounded-md textarea"></textarea>
            </div>
        </div><!--end row-->
        <button type="submit" id="submit" class="btn bg-orange-600 hover:bg-orange-700 text-white rounded-md mt-5 py-1 px-4">{{ __('main.update_btn') }}</button>
    </form><!--end form-->

@endsection
