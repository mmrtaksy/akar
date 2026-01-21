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


    <h5 class="text-lg font-semibold mb-4">{{ __('main.tax_information') }}</h5>
    <form method="POST" action="@localizedRoute('account_companyBillUpdate')">
        @csrf
            <div class="form-group mb-3">
                <label for="title" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.tax_type') }}*</label>
                <div class="mt-2 flex gap-3">
                    <div class="wrapper_type">
                        <input type="radio" id="personel" name="tax_type" value="personel" {{ $data ? $data->tax_type == 'personel' ? 'checked' : ''  : 'checked' }} class="tax_type">
                        <label for="personel">{{ __('main.tax_type_personel') }}</label>
                    </div>
                    <div class="wrapper_type">
                        <input type="radio" id="company" name="tax_type" value="company" {{ $data ? $data->tax_type == 'company' ? 'checked' : ''  : '' }} class="tax_type">
                        <label for="company">{{ __('main.tax_type_company') }}</label>
                    </div>
                </div>
            </div>

            <div class="form-group mb-3 only_company" style="display:none;">
                <label for="company_name" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.companies_page_input_placeholder') }}*</label>
                <div class="mt-2">
                    <input id="company_name" name="company_name" value="{{ $data ? $data->company_name : '' }}" type="text" class="px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                </div>
            </div>

            <div class="form-group mb-3 only_personel">
                <label for="user_name" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.contact_name_surname') }}*</label>
                <div class="mt-2">
                    <input id="user_name" name="user_name" type="text" value="{{ $data ? $data->user_name : '' }}" required class="px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="address" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.form_label_address') }}*</label>
                <div class="mt-2">
                    <input id="address" name="address" type="text" value="{{ $data ? $data->address : '' }}" required class="px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                </div>
            </div>

            <div class="form-group mb-3">
                <label class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.form_label_country') }}*</label>
                <select name="country_id" data-url="countrysearch" data-selected="226" id="country_id" required class="select2ajax px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                    @if ($data && $data->country_id)
                    <option value="{{ $data->country->id }}" selected="selected">{{ $data->country->name }}</option>
                    @endif
                </select>
            </div>


            <div class="form-group mb-3">
                <label class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.city') }}*</label>
                <select name="city_id" id="city_id" required class="select2city px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                    @if ($data && $data->city_id)
                    <option value="{{ $data->city->id }}" selected="selected">{{ $data->city->name }}</option>
                    @endif
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="countien" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.countien') }}*</label>
                <div class="mt-2">
                    <input id="countien" name="countien" type="text" value="{{ $data ? $data->countien : '' }}" required class="px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                </div>
            </div>

            <div class="form-group mb-3 only_company" style="display:none;">
                <label for="tax_company" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.tax_office') }}*</label>
                <div class="mt-2">
                    <input id="tax_company" name="tax_company" type="text" value="{{ $data ? $data->tax_company : '' }}" class="px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                </div>
            </div>

            <div class="form-group mb-3 only_company" style="display:none;">
                <label for="tax_no" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.tax_no') }}*</label>
                <div class="mt-2">
                    <input id="tax_no" name="tax_no" type="text" value="{{ $data ? $data->tax_no : '' }}" class="px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                </div>
            </div>

            <div class="form-group mb-3 only_personel">
                <label for="tc_no" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.tc_no') }}*</label>
                <div class="mt-2">
                    <input id="tc_no" name="tc_no" type="text" value="{{ $data ? $data->tc_no : '' }}" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="11" maxlength="11" required class="px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                </div>
            </div>



        <button type="submit" id="submit" class="btn bg-orange-600 hover:bg-orange-700 text-white rounded-md mt-5 py-1 px-4">{{ __('main.update_btn') }}</button>
    </form>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $('.tax_type').on('change', function(){
                let type = $(this).attr('id');
                if(type == 'personel'){
                    $('.only_company').hide().find('input').removeAttr('required');
                    $('.only_personel').show().find('input').attr('required', true);
                }else{
                    $('.only_personel').hide().find('input').removeAttr('required');
                    $('.only_company').show().find('input').attr('required', true);
                }
            })
        })
    </script>
@endpush
