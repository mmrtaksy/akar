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


    <h5 class="text-lg font-semibold mb-4">{{ __('main.form_title_2') }}</h5>
    <form method="POST" action="@localizedRoute('account_companyUpdate')" enctype="multipart/form-data">
        @csrf
            <div class="form-group mb-3">
                <label for="title" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.companies_page_input_placeholder') }}*</label>
                <div class="mt-2">
                    <input id="title" name="title" type="text" value="{{ $data->info->title }}" required class="px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                </div>
            </div>
            <div class="flex flex-wrap justify-center items-center gap-10 mt-5">
                <div class="form-group mb-3">
                    <label for="avatar" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Logo <span class="text-xs text-gray-600 dark:text-gray-300 font-normal">{{ __('main.upload_size_text') }} </span> </label>
                    <div class="mt-2">
                        <input id="avatar" name="avatar" accept="image/*" type="file" class="px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                    </div>
                </div>
                <div class="right_wrapper text-center">
                    @if ($data->info->avatar)
                        <img src="{{ asset('avatars/' . $data->info->avatar) }}" class="size-20 roudned-md object-contain bg-white border border-gray-200 dark:border-gray-700">
                    @else
                        <div class="bg-gray-300 size-20 roudned-md"></div>
                    @endif
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="about" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.about') }}*</label>
                <div class="mt-2">
                    <textarea id="about" name="about" required class="min-h-36  content px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">{{ $data->info->about }}</textarea>
                </div>
            </div>

            <div class="form-group mb-3">
                <label class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.form_label_country') }}</label>
                <select name="country_id" data-url="contrysearch" data-selected="{{ $data->info->country_id ? $data->info->country_id : 226 }}" id="country_id" class="select2ajax px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                    @if ($data->info->country_id)
                    <option value="{{ $data->info->country->id }}" selected="selected">{{ $data->info->country->name }}</option>
                    @endif
                </select>
            </div>


            <div class="form-group mb-3">
                <label class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.city') }}</label>
                <select name="city_id" id="city_id" class="select2city px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                    @if ($data->info->city_id)
                    <option value="{{ $data->info->city->id }}" selected="selected">{{ $data->info->city->name }}</option>
                    @endif
                </select>
            </div>



            <div class="form-group mb-3">
                <label for="address" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.form_label_address') }}</label>
                <div class="mt-2">
                    <input id="address" name="address" value="{{ $data->info->address }}" type="text" class="px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="phone" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.form_label_phone') }}</label>
                <div class="mt-2">
                    <input id="phone" name="phone" value="{{ $data->info->phone }}" type="text" class="phone px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                </div>
            </div>
           
            <div class="form-group mb-3">
                <label for="email" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.form_label_email') }}</label>
                <div class="mt-2">
                    <input id="email" name="email" value="{{ $data->info->email }}" type="email" class="px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="website" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.form_label_website') }}</label>
                <div class="mt-2">
                    <input id="website" name="website" placeholder="https://..." value="{{ $data->info->website }}" type="url" class="px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                </div>
            </div>


            <div id="social-links-container" class="form-group mb-3">
                <label class="block text-sm font-medium leading-6 text-gray-900 dark:text-white my-6">{{ __('main.form_label_socials') }}  <button type="button" id="add-social-link" class=" bg-blue-500 hover:bg-blue-700 text-white text-sm py-1 px-4 font-normal rounded">{{ __('main.add_new') }}</button></label>
                @foreach ($data->info->social as $key => $social)
                    <div class="mt-2 flex">
                        <select name="links[{{ $key }}][type]" class="px-2 mr-2 block w-1/4 dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                            <option value="instagram" {{ $social->type == 'instagram' ? 'selected' : '' }}>Instagram</option>
                            <option value="facebook" {{ $social->type == 'facebook' ? 'selected' : '' }}>Facebook</option>
                            <option value="twitter" {{ $social->type == 'twitter' ? 'selected' : '' }}>Twitter</option>
                            <option value="linkedin" {{ $social->type == 'linkedin' ? 'selected' : '' }}>LinkedIn</option>
                        </select>
                        <input name="links[{{ $key }}][link]" type="url" value="{{ $social->link }}" placeholder="https://..." class="_link px-2 block w-3/4 dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                    </div>
                @endforeach
            </div>



        <input type="hidden" name="id" value="{{ $data->info->id }}">
        <button type="submit" id="submit" class="btn bg-orange-600 hover:bg-orange-700 text-white rounded-md mt-5 py-1 px-4">{{ __('main.update_btn') }}</button>
    </form><!--end form-->

@endsection


@push('scripts')
<script>
    document.getElementById('add-social-link').addEventListener('click', function() {
        let totalLink = $('._link').length;
        if(totalLink > 3){
            return false;
        }

        const container = document.getElementById('social-links-container');
        const index = container.children.length - 1;
        const newLinkDiv = document.createElement('div');
        newLinkDiv.className = 'mt-2 flex';
        newLinkDiv.innerHTML = `
            <select name="links[${index}][type]" class="px-2 mr-2 block w-1/4 dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                <option value="website">Website</option>
                <option value="facebook">Facebook</option>
                <option value="twitter">Twitter</option>
                <option value="linkedin">LinkedIn</option>
            </select>
            <input name="links[${index}][link]" type="url" placeholder="https://..." class="_link px-2 block w-3/4 dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
        `;
        container.appendChild(newLinkDiv);
    });
</script>
@endpush
