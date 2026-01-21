@extends('layouts.default', ['title' =>  __('main.package_page__title'), 'image' => null])
@section('content')




       <!-- Start Hero -->
       <section class="relative table w-full py-24">
        <div class="absolute inset-0 bg-orange-700"></div>
        <div class="container">
            <div class="grid grid-cols-1 text-center mt-10">
                <h3 class="md:text-3xl text-2xl md:leading-snug tracking-wide leading-snug font-medium text-white">{{ __('main.package_page__title') }}</h3>
                <p class="text-center text-white">{{ __('main.package_page_subtitle') }}</p>

            </div><!--end grid-->
        </div><!--end container-->

    </section><!--end section-->
    <!-- End Hero -->

    <!-- Start -->
    <section class="relative lg:py-24 py-16 min-h-screen">
        <div class="container">
            <div class="grid md:grid-cols-3 grid-cols-1 gap-[30px]">

                @php
                    $prevItem = null;
                @endphp


                @foreach ($data as $key => $item)


                    @if ($key == 2)
                    <div class="group border-2 border-orange-600 relative shadow hover:shadow-md dark:shadow-gray-800 rounded-md z-2 bg-gray-100 dark:bg-slate-700 transition-all duration-500 dark:text-white">
                        @else
                        <div class="group border border-transparent relative shadow hover:shadow-md dark:shadow-gray-800 rounded-md bg-white dark:bg-slate-800 transition-all duration-500 dark:text-white">
                    @endif


                    <div class="p-6 py-8">

                        <h6 class="text-lg text-center font-bold uppercase mb-5 text-orange-600">{{ $item->title }}</h6>

                        <div class="flex justify-center w-full">
                            <span class="text-4xl text-center font-black uppercase text-orange-600">{{ number_format(($item->price), 0, ',', '.') }}</span>
                            <span class="text-lg font-semibold text-orange-600">TL</span>
                        </div>

                        <div class="flex mt-3 justify-center items-center w-full">
                            <span class="text-lg font-semibold">{{ __('main.each_ad') }} / </span>
                            <span class="price text-lg font-semibold mb-0 ml-2">{{ number_format(($item->price / $item->ad_quantity), 0, ',', '.') }}</span>
                            <span class="text-lg font-semibold">TL</span>
                        </div>
                        <h6 class="text-lg text-center font-semibold mb-5">{{ __('main.earning') }}: {{ $prevItem ? ($prevItem->price * 2) - $item->price : 0 }} <span class="text-md font-semibold">TL</span></h6>

                       <div class="description text-gray-500 dark:text-gray-300 text-sm text-center">
                         <span>{{ $item->description }}</span>
                       </div>
                       <div class="warning my-4 text-center">
                        <span class="font-semibold"> {{ __('main.no_include_vat') }}</span>
                       </div>

                        <div class="flex justify-center">
                            <a href="@localizedRoute('userPackageTakeReviewGet', ['id' => $item->id])"
                            class="inline-block px-4 py-2 bg-orange-600 hover:bg-orange-700 border-orange-600 hover:border-orange-700 text-white rounded-md mt-5 font-semibold">
                            {{ __('main.get_package') }}
                            </a>
                        </div>
                    </div>
                </div>

                    @php
                        $prevItem = $item;
                    @endphp

                @endforeach


            </div>
        </div><!--end container-->
        @if($data->count())
        <div class="my-10">
            <span class="text-center block font-medium text-lg dark:text-white">{{ __('main.or') }}</span>
        </div>
        @endif
        <div class="flex justify-center">
            <a href="@localizedRoute('userPackageRequestGet')" class="inline-block px-4 py-2 bg-orange-600 hover:bg-orange-700 border-orange-600 hover:border-orange-700 text-white rounded-md mt-5 font-semibold">{{ __('main.package_page_btn_text') }}</a>
        </div>
    </section>



@endsection
