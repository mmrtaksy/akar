@extends('layouts.default', ['title' => __('main.ad_package_request'), 'image' => null])
@section('content')




       <!-- Start Hero -->
       <section class="relative table w-full py-24">
        <div class="absolute inset-0 bg-orange-700"></div>
        <div class="container">
            <div class="grid grid-cols-1 text-center mt-10">
                <h3 class="md:text-3xl text-2xl md:leading-snug tracking-wide leading-snug font-medium text-white">{{ __('main.ad_package_request') }}</h3>
                <p class="text-center text-white">{{ __('main.ad_package_request_text') }}</p>

            </div><!--end grid-->
        </div><!--end container-->

    </section><!--end section-->
    <!-- End Hero -->

    <!-- Start -->
    <section class="relative lg:py-24 py-16 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-[600px] mx-auto bg-white dark:bg-gray-800 p-16 rounded-lg dark:text-white">

            @if (session('success'))
            <div class="bg-green-600 text-white px-3 py-1 rounded-sm text-sm mb-5">
                {{ session('success') }}
            </div>
            @endif

            @if ($errors->any())
            <div class="bg-red-600 text-white px-3 py-1 rounded-sm text-sm mb-5">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif


            <form method="POST" action="@localizedRoute('userPackageRequestPost')">
                @csrf
                <div class="flex flex-wrap gap-6">
                    <div class="form-group w-full flex gap-3">
                        <label class="form-label font-medium w-20">{{ __('main.form_label_name') }}<span class="text-red-600">*</span></label>
                        <input type="text" class="px-2 dark:bg-gray-800 block w-full border border-1 dark:border-gray-700 py-1 mt-1 rounded-md" id="name" name="name" required value="{{ Auth::user()->name }}" disabled>
                    </div>

                    <div class="form-group w-full flex gap-3">
                        <label class="form-label font-medium w-20">{{ __('main.form_label_surname') }}<span class="text-red-600">*</span></label>
                        <input type="text" class="px-2 dark:bg-gray-800 block w-full border border-1 dark:border-gray-700 py-1 mt-1 rounded-md" id="surname" name="surname" required value="{{ Auth::user()->surname }}" disabled>
                    </div>


                    <div class="form-group w-full flex gap-3">
                        <label class="form-label font-medium w-20">{{ __('main.form_label_email') }}<span class="text-red-600">*</span></label>
                        <input type="email" class="px-2 dark:bg-gray-800 block w-full border border-1 dark:border-gray-700 py-1 mt-1 rounded-md" name="email" required value="{{ Auth::user()->email }}" disabled>
                    </div>


                    <div class="form-group w-full flex gap-3">
                        <label class="form-label font-medium w-20">{{ __('main.form_label_phone') }}<span class="text-red-600">*</span></label>
                        <input type="phone" class="px-2 dark:bg-gray-800 block w-full border border-1 dark:border-gray-700 py-1 mt-1 phone rounded-md" name="phone" required value="{{ Auth::user()->phone }}">
                    </div>

                    <div class="form-group w-full flex gap-3">
                        <label class="form-label font-medium w-20">{{ __('main.form_label_message') }}<span class="text-red-600">*</span></label>
                        <textarea name="message" id="message" rows="5" class="px-2 dark:bg-gray-800 block w-full border border-1 dark:border-gray-700 py-2 mt-1 rounded-md textarea" required></textarea>
                    </div>

                </div><!--end grid-->


                <button type="submit" id="submit" class="btn bg-orange-600 hover:bg-orange-700 text-white rounded-md mt-5 py-1 px-4">{{ __('main.send') }}</button>
            </form><!--end form-->


        </div>
    </section>



@endsection
