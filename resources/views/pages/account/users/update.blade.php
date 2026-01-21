@extends('pages.account.layout')
@section('account_content')


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


    <h5 class="text-lg font-semibold mb-4">{{ __('main.edit_user') }}</h5>
    <form method="POST" action="@localizedRoute('account_userUpdatePost')">
        @csrf
        <div class="grid lg:grid-cols-12 md:grid-cols-2 grid-cols-1 gap-4">
            <div class="lg:col-span-4">
                <label class="form-label font-medium">{{ __('main.form_label_name') }} <span class="text-red-600">*</span></label>
                <input type="text" value="{{ $data->user->name }}" class="px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md" id="name" name="name" required="">
            </div>

            <div class="lg:col-span-4">
                <label class="form-label font-medium">{{ __('main.form_label_surname') }} <span class="text-red-600">*</span></label>
                <input type="text" value="{{ $data->user->surname }}" class="px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md" id="surname" name="surname" required="">
            </div>

            <div class="lg:col-span-4">
                <label class="form-label font-medium">{{ __('main.form_label_gender') }}</label>
                <select name="gender" id="gender" class="select2 px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                    <option value="0" {{ $data->user->gender == 0 ? 'selected' : '' }}>{{ __('main.no_gender') }}</option>
                    <option value="1" {{ $data->user->gender == 1 ? 'selected' : '' }}>{{ __('main.gender_man') }}</option>
                    <option value="2" {{ $data->user->gender == 2 ? 'selected' : '' }}>{{ __('main.gender_woman') }}</option>
                </select>
            </div>

            <div class="lg:col-span-4">
                <label class="form-label font-medium">{{ __('main.form_label_email') }} <span class="text-red-600">*</span></label>
                <input type="email" value="{{ $data->user->email }}" class="px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md" name="email" required="">
            </div>


            
            <div class="lg:col-span-4">
                <label class="form-label font-medium">{{ __('main.form_label_country') }}  <span class="text-red-600">*</span></label>
                <select name="country_id" data-selected="{{ $data->user->country_id ? $data->user->country_id : 228 }}" data-url="countrysearch" id="country_id" class="select2ajax px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                    <option value="{{ $countryTR->id }}" selected>{{ $countryTR->name }}</option>
                </select>
            </div>

            <div class="lg:col-span-4">
                <label class="form-label font-medium">{{ __('main.form_label_phone') }}  <span class="text-red-600">*</span></label>
                <input type="phone" value="{{ $data->user->phone }}" class="px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 phone rounded-md" name="phone" required="">
            </div>
 

        </div><!--end grid-->

        <div class="grid grid-cols-1">
            <div class="mt-5">
                <label class="form-label font-medium">{{ __('main.about') }} </label>
                <textarea name="about" id="about" rows="5" class="px-2 block w-full border border-1 border-gray-200 focus:border-gray-300 py-2 mt-1 rounded-md textarea">{{ $data->user->about }}</textarea>
            </div>
        </div><!--end row-->
        <input type="hidden" name="id" value="{{ $data->user->id }}">
        <div class="wrapper_flex flex justify-between items-center">
            <button type="submit" id="submit" class="btn bg-orange-600 hover:bg-orange-700 text-white rounded-md mt-5 py-1 px-4">{{ __('main.update_btn') }}</button>
            <a href="@localizedRoute('account_userDeleteGetSingle', ['id' => $data->user->id])" class="_confirm btn bg-red-600 hover:bg-red-700 text-white rounded-md mt-5 py-1 px-4">{{ __('main.delete_user_account_btn') }}</a>
        </div>
    </form><!--end form-->

@endsection
