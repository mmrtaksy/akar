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


    <div class="mb-4 relative w-full">
        <h5 class="text-lg font-semibold">{{ __('main.new_job') }}</h5>
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('main.your_company') }}: {{ $company->title }}</p>
    </div>

    <form method="POST" action="@localizedRoute('userJobCreatePost')">
        @csrf
        <div class="grid md:grid-cols-2 grid-cols-1 gap-4">


                <div class="form-group mb-3">
                    <label for="lang" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.lang') }}*</label>
                    <div class="mt-2">
                        <select id="lang" name="lang" required class="select2 px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                            @foreach ($languages as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="end_at" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.end_date') }}*</label>
                    <div class="mt-2">
                        <input id="end_at" name="end_at" type="date" min="{{ $today }}"  value="{{ old('end_at') }}" required class="px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                    </div>
                </div>

                <div class="form-group mb-3 col-span-2">
                    <label for="title" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.title') }}*</label>
                    <div class="mt-2">
                        <input id="title" name="title" type="text" value="{{ old('title') }}" required class="px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                    </div>
                </div>

                <div class="form-group mb-3 col-span-2">
                    <label for="description" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.description') }}*</label>
                    <div class="mt-2">
                        <textarea id="description" name="description"required class=" min-h-32 content px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="reference_code" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.reference_code') }}</label>
                    <div class="mt-2">
                        <input id="reference_code" name="reference_code" type="text" value="{{ old('reference_code') }}" class="px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                    </div>
                </div>


                <div class="form-group mb-3">
                    <label for="job_type_id" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.ad_type') }}*</label>
                    <div class="mt-2">
                        <select id="job_type_id" name="job_type_id" required class="select2 px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            @foreach ($jobtypes as $item)
                                <option value="{{ $item->id }}" {{ old('job_type_id') == $item->id ? 'selected' : '' }}>{{ $item->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="job_sector_id" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.sector') }}</label>
                    <div class="mt-2">
                        <select id="job_sector_id" name="job_sector_id" class="select2 px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                            @foreach ($jobsector as $item)
                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="job_position_id" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.position') }}</label>
                    <div class="mt-2">
                        <select id="job_position_id" name="job_position_id" data-url="positions" class="select2ajax px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md"></select>
                    </div>
                    <a href="javascript:void(0);" class="text-sm inline-block mt-2 text-gray-600 dark:text-white" id="newReqPos">{{ __('main.position_not_found') }}</a>

                    <div class="form-group mb-3 col-span-2 bg-gray-100 dark:bg-gray-600 p-2 hidden" id="createNewPos">
                        <label for="new_position_name" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.new_position_name') }}</label>
                        <div class="mt-2 flex gap-2 items-center">
                            <input id="new_position_name" name="new_position_name" type="text" class="px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                            <button type="button" id="requestForNewPosition" class="bg-orange-600 hover:bg-orange-700 text-white rounded-md py-1 px-4 disabled:bg-gray-400" disabled>{{ __('main.create') }}</button>
                        </div>
                        <a href="javascript:void(0);" class="text-sm inline-block mt-2 text-gray-600 dark:text-white" id="newReqPosCancel">{{ __('main.cancel') }}</a>
                    </div>

                </div>


                <div class="form-group mb-3">
                    <label for="country_id" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.country') }}</label>
                    <div class="mt-2">
                        <select id="country_id" data-url="countrysearch" name="job_country_id" class="select2ajax px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md"></select>
                    </div>
                </div>


                <div class="form-group mb-3">
                    <label for="job_city_ids" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.city') }}</label>
                    <div class="mt-2">
                        <select id="job_city_ids" data-url="citysearch" name="job_city_ids[]" multiple class="select2city px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md"></select>
                    </div>
                </div>

                

                <div class="form-group mb-3">
                    <label for="job_education_ids" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.education_level') }}</label>
                    <div class="mt-2">
                        <select id="job_education_ids" name="job_education_ids[]" multiple class="select2 px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                            @foreach ($educationlevel as $item)
                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="job_position_level" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.position_level') }}</label>
                    <div class="mt-2">
                        <select id="job_position_level" name="job_position_level" class="select2 px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                            @foreach ($positionlevel as $item)
                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="job_language_level" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.language_level') }}</label>
                    <div class="mt-2">
                        <select id="job_language_level" name="job_language_level[]" multiple class="select2 px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                            @foreach ($languagelevel as $item)
                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="job_experience_level" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.work_experience_year') }}</label>
                    <div class="mt-2">
                        <select id="job_experience_level" name="job_experience_level" class="select2 px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                            @foreach ($experiencelevel as $item)
                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="user_phone" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.user_phone') }}</label>
                    <div class="mt-2">
                        <input id="user_phone" name="user_phone" type="text" value="{{ old('user_phone') }}" class="phone px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                    </div>
                    <div class="mt-2 d-flex gap-3">
                        <input id="user_phone_statu" name="user_phone_statu" type="checkbox" value="1">
                        <label for="user_phone_statu" class="text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.phone_is_hidden') }}</label>
                    </div>
                </div>


                <div class="form-group mb-3">
                    <label for="approve_type" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.application_type') }}</label>
                    <div class="mt-2">
                        <select id="approve_type" name="approve_type" class="px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                            <option value="0">{{ __('main.application_type_email') }}</option>
                            <option value="1">{{ __('main.application_type_link') }}</option>
                        </select>
                    </div>
                </div>

                <div class="form-group mb-3" id="connect_type_input">
                    <label for="approve_email" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('main.form_label_email') }}</label>
                    <div class="mt-2">
                        <input id="approve_email" name="approve_email" type="email" value="{{ old('approve_email') }}" required class="px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md" />
                    </div>
                </div>

                

        </div>


        <button type="submit" id="submit" class="btn bg-orange-600 hover:bg-orange-700 text-white rounded-md mt-5 py-1 px-4">{{ __('main.save_btn') }}</button>
    </form><!--end form-->

@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            $('#newReqPos').on('click', function(){
                $('#createNewPos').removeClass('hidden').addClass('block');
            })
            $('#newReqPosCancel').on('click', function(){
                $('#createNewPos').removeClass('block').addClass('hidden');
            })

            const emailTxt = "{{ __('main.application_type_email') }}";
            const linkTxt = "{{ __('main.application_type_link') }}";

            const emailInput = `<label for="approve_email" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">${emailTxt}</label>
            <div class="mt-2">
                <input id="approve_email" name="approve_email" text="email" class="px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md" />
            </div>`;

            const linkInput = `<label for="approve_link" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">${linkTxt}</label>
            <div class="mt-2">
                <input id="approve_link" name="approve_link" text="text" class="px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md" />
            </div>`;


            $(document).on('change', '#approve_type', function(){
                const thv = $(this).val();
                if(thv == 0){
                    $('#connect_type_input').html(emailInput);
                }else{
                    $('#connect_type_input').html(linkInput);
                }
            })


            $('#new_position_name').on('keyup', function(){
                let v = $(this).val().trim();
                if(v.length > 0){
                    $('#requestForNewPosition').attr('disabled', false);
                }else{
                    $('#requestForNewPosition').attr('disabled', true);
                }
            })
            $('#requestForNewPosition').on('click', function(){
                let np = $('#new_position_name').val().trim();
                if(np && np.length > 0){
                    $.ajax({
                        type: 'POST',
                        url: '/api/requestnewposition',
                        data: {np: np},
                        success: function(res){
                            alert(res.message);
                            // Sektör isteği başarıyla yapıldı!
                        }
                    })
                }
            })
        })
    </script>
@endpush
