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


    <h5 class="text-lg font-semibold mb-4">{{ __('main.user_password_title') }}</h5>
    <form method="POST" action="@localizedRoute('userPasswordChangePost')">
        @csrf
        <div class="grid lg:grid-cols-12 md:grid-cols-2 grid-cols-1 gap-4">
            <div class="lg:col-span-4">
                <label class="form-label font-medium" id="new_password">{{ __('main.user_new_password') }} <span class="text-red-600">*</span></label>
                <input type="password" class="px-2 dark:bg-gray-800 dark:text-white block w-full border border-1 dark:border-gray-700 focus:border-gray-300 py-1 mt-1 rounded-md" id="new_password" name="new_password" required>
            </div>
            <div class="lg:col-span-4">
                <label class="form-label font-medium" id="new_password_confirmation">{{ __('main.user_new_repassword') }} <span class="text-red-600">*</span></label>
                <input type="password" class="px-2 dark:bg-gray-800 dark:text-white block w-full border border-1 dark:border-gray-700 focus:border-gray-300 py-1 mt-1 rounded-md" id="new_password_confirmation" name="new_password_confirmation" required>
            </div>

        </div>


        <button type="submit" id="submit" class="btn bg-orange-600 hover:bg-orange-700 text-white rounded-md mt-5 py-1 px-4">{{ __('main.update_btn') }}</button>
    </form><!--end form-->

@endsection
