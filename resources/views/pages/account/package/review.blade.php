@extends('layouts.default', ['title' => 'Paketler', 'image' => null])
@section('content')
    <!-- Start Hero -->
    <section class="relative table w-full py-24">
        <div class="absolute inset-0 bg-orange-700"></div>
        <div class="container">
            <div class="grid grid-cols-1 text-center mt-10">
                <h3 class="md:text-3xl text-2xl md:leading-snug tracking-wide leading-snug font-medium text-white">{{ __('main.ad_buy_page_title') }}</h3>
                <p class="text-center text-white">{{ __('main.ad_buy_page_title_sub') }}</p>

            </div><!--end grid-->
        </div><!--end container-->

    </section><!--end section-->
    <!-- End Hero -->

    <!-- Start -->
    <section class="relative lg:py-24 py-16 bg-gray-100 dark:bg-gray-900">
        <div class="container">
            <div class="flex flex-wrap">
                <div class=" w-full md:w-2/3 p-2">
                    <div class="bg-white dark:bg-gray-800 p-10 rounded-lg dark:text-white shadow-sm mb-4">

                        <div class="form-group w-full flex flex-wrap">
                            <h5 class="font-bold mb-2 text-md block">{{ __('main.selected_package') }}</h5>
                            <div class="w-full px-2">{{ $data->title }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-300">{{ $data->description }}</div>
                        </div>

                        <hr class="w-full my-5 dark:border-gray-700">

                        <div class="form-group w-full  flex flex-wrap max-w-96">
                            <label class="font-medium w-full block">{{ __('main.ad_packages') }}</label>
                            <select name="package" id="package"
                                class="select2 px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-1 rounded-md">
                                @foreach ($packages as $item)
                                    <option value="{{ $item->id }}" {{ $data->id == $item->id ? 'selected' : '' }}>
                                        {{ $item->title }}</option>
                                @endforeach
                            </select>
                            <div class="p-2 text-sm text-gray-400 dark:text-gray-500">{{ __('main.ad_packages_note') }}</div>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 p-10 rounded-lg dark:text-white shadow-sm">

                        <div class="flex flex-wrap mb-6">
                            <div class="w-1/2 p-2">
                                <div class="font-bold mb-2 text-md block p-10 text-center border-2 border-gray-400 hover:border-gray-400 rounded-md cursor-pointer _paytab"
                                    id="#tab1"> {{ __('main.pay_as_credit_card') }} </div>
                            </div>
                            <div class="w-1/2 p-2">
                                <div class="font-bold mb-2 text-md block p-10 text-center border-2 border-gray-700 hover:border-gray-400 rounded-md cursor-pointer _paytab"
                                    id="#tab2">{{ __('main.pay_as_eft') }} </div>
                            </div>
                        </div>

                        <div class="_tabs w-full">
                            <div class="tab tab1 block" id="tab1">
                                <div class=" bg-white text-black text-xs">
                                    @include('components.terms1')
                                </div>

                                <div class="wrapper_online_pay_method_wrapper hidden" id="opmwrapper">
                                    {!! $checkoutFormContent !!}
                                    <div id="iyzipay-checkout-form" class="responsive"></div>
                                </div>

                            </div>
                            <div class="tab tab2 hidden" id="tab2">
                                <div class=" bg-white text-black text-xs">
                                    @include('components.terms1')
                                </div>

                                @include('components.terms2')
                            </div>


                            <div class="wrapper_terms_check my-2 flex justify-between gap-2">
                                <div class="terms_left">
                                    <input type="checkbox" name="terms_check" id="terms_check">
                                    <label for="terms_check">{{ __('main.agree_terms') }}</label>
                                </div>
                                <div class="terms_right text-right">
                                    <a href="#" id="print">{{ __('main.print') }}</a>
                                </div>
                            </div>

                            <div class="hidden mt-5 text-right" id="eftpaywrapper">
                                <button data-to="@localizedRoute('userPackageOrderCreateGet', ['id' => $data->id])" class="px-4 py-2 text-white bg-orange-600 disabled:bg-gray-400" id="eftpayBtn" disabled>{{ __('main.agree_all_process') }}</button>
                            </div>
                        </div>


                    </div>
                </div>
                <div class=" w-full md:w-1/3 p-2">
                    <div class=" bg-white dark:bg-gray-800 p-10 rounded-lg dark:text-white shadow-sm">

                        <div class="form-group w-full flex flex-wrap">
                            <h5 class="font-bold text-md block mb-3">{{ __('main.order_summary') }}</h5>
                            <div class="flex items-center justify-between w-full px-2">
                                <div class=" text-sm text-black dark:text-white font-semibold">1 {{ __('main.item') }}</div>
                                <div class="text-sm text-black dark:text-white font-semibold">
                                    {{ number_format($data->price, 2, ',', '.') }} TL + {{ __('main.vat') }}</div>
                            </div>
                        </div>

                        <hr class="w-full my-5 dark:border-gray-700">


                        <div class="form-group w-full flex flex-wrap">
                            <h5 class="font-bold text-md block mb-3">{{ __('main.subtotal') }}</h5>
                            <div class="flex items-center justify-between w-full px-2 pb-2">
                                <div class="text-sm text-black dark:text-white font-semibold">{{ __('main.vat') }}</div>
                                <div class="text-sm text-black dark:text-white font-semibold">
                                    {{ number_format($data->price + ($data->price * 20) / 100 - $data->price, 2, ',', '.') }}
                                    TL</div>
                            </div>
                            <div class="flex items-center justify-between w-full px-2 pb-2">
                                <div class="text-sm text-black dark:text-white font-semibold">{{ __('main.vat_included') }}</div>
                                <div class="text-sm text-black dark:text-white font-semibold">
                                    {{ number_format($data->price + ($data->price * 20) / 100, 2, ',', '.') }} TL</div>
                            </div>
                            <div class="flex items-center justify-between w-full px-2 pb-2">
                                <div class="text-sm text-black dark:text-white font-semibold">{{ __('main.discount') }}</div>
                                <div class="text-sm text-black dark:text-white font-semibold">0.00 TL</div>
                            </div>
                        </div>

                        <hr class="w-full my-5 dark:border-gray-700">

                        <div class="form-group w-full flex flex-wrap">
                            <div class="flex items-center justify-between w-full px-2">
                                <div class="text-sm text-black dark:text-white font-semibold ">{{ __('main.general_total_inc_vat') }}</div>
                                <div class="text-sm text-black dark:text-white font-semibold">
                                    {{ number_format($data->price + ($data->price * 20) / 100, 2, ',', '.') }} TL</div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/printThis.js') }}"></script>
    <script>
        let _newUrlTemplate = "@localizedRoute('userPackageTakeReviewGet', ['id' => ':id'])";
        let activeTab = 1;

        $('#package').on('change', function() {
            const id = $(this).val();
            let _newUrl = _newUrlTemplate.replace(':id', id);
            window.location.href = _newUrl;
        });

        $('._paytab').on('click', function() {
            let th = $(this);
            const _id = th.attr('id');
            $('.tab').removeClass('block').addClass('hidden');
            $(_id + '.tab').removeClass('hidden').addClass('block');

            $('._paytab').removeClass('border-gray-400').addClass('border-gray-700')
            th.removeClass('border-gray-700').addClass('border-gray-400')

            if(_id == '#tab2'){
                activeTab = 2;
                $('#eftpaywrapper').removeClass('hidden').addClass('block');
            }else{
                activeTab = 1;
                $('#eftpaywrapper').removeClass('block').addClass('hidden');
            }


            if(activeTab == 1){
                if($('#terms_check').prop('checked')){
                    $('#opmwrapper').removeClass('hidden').addClass('block');
                }
            }else{
                $('#opmwrapper').removeClass('block').addClass('hidden');
            }


        })

        $('#print').on('click', function(e){
            e.preventDefault();
            $('#printPage').printThis({
                importCSS: false,
                footer: false,
                header: false
            });
        });


        $('#terms_check').on('change', function(){
            if( $(this).prop('checked') ){
                $('#eftpayBtn').attr('disabled', false);

                if(activeTab == 1){
                    $('#opmwrapper').removeClass('hidden').addClass('block');
                }

            }else{
                $('#eftpayBtn').attr('disabled', true);

                if(activeTab == 1){
                    $('#opmwrapper').removeClass('block').addClass('hidden');
                }
            }
        })

        $('#eftpayBtn').on('click', function(){
           const _orderuri = $(this).attr('data-to');
           window.location.href = _orderuri;
        })



    </script>
@endpush
