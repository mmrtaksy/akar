@extends('layouts.default', ['title' => 'Paket Sipariş Ödemesi', 'image' => null])
@section('content')
    <!-- Start Hero -->
    <section class="relative table w-full py-24">
        <div class="absolute inset-0 bg-orange-700"></div>
        <div class="container">
            <div class="grid grid-cols-1 text-center mt-10">
                <h3 class="md:text-3xl text-2xl md:leading-snug tracking-wide leading-snug font-medium text-white">{{ __('main.result_page_title') }}</h3>
                <p class="text-center text-white">{{ __('main.result_page_title_sub') }}</p>

            </div><!--end grid-->
        </div><!--end container-->

    </section><!--end section-->
    <!-- End Hero -->

    <!-- Start -->
    <section class="relative lg:py-24 py-16 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="container">
            <div class="flex flex-wrap">
                <div class=" w-full p-2">
                    <div class="bg-white dark:bg-gray-800 p-10 rounded-lg dark:text-white shadow-sm mb-4">
                        <h1 class="text-2xl dark:text-white">{{ __('main.result_page_info_text_1') }}</h1>
                        <h3 class="text-1xl dark:text-white">{{ __('main.result_page_info_text_2') }}</h3>
                        <h4 class="text-lg dark:text-white">{{ __('main.result_page_info_text_3') }}</h4>
                        @php
                            $link = Helper::localizedRoute('account_userPackagesGet');
                        @endphp
                        <div class="mt-6 text-lg dark:text-white">{!! __('main.result_page_info_text_4', ['link' => $link]) !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@tsparticles/confetti@3.0.3/tsparticles.confetti.bundle.min.js"></script>
<script>
    $(document).ready(function(){
        const defaults = {
        spread: 360,
        ticks: 50,
        gravity: 0,
        decay: 0.94,
        startVelocity: 30,
        shapes: ["star"],
        colors: ["FFE400", "FFBD00", "E89400", "FFCA6C", "FDFFB8"],
        };

        function shoot() {
        confetti({
            ...defaults,
            particleCount: 40,
            scalar: 1.2,
            shapes: ["star"],
        });

        confetti({
            ...defaults,
            particleCount: 10,
            scalar: 0.75,
            shapes: ["circle"],
        });
        }

        setTimeout(shoot, 0);
        setTimeout(shoot, 100);
        setTimeout(shoot, 200);
        setTimeout(shoot, 300);
        setTimeout(shoot, 400);
        setTimeout(shoot, 1500);
    })
</script>
@endpush
