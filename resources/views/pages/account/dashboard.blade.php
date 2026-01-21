
@extends('pages.account.layout')
@section('account_content')



    <h5 class="text-lg font-semibold mb-4">Dashboard</h5>


        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">


            <div class="p-2 relative">
                <div class="bg-white dark:bg-gray-700  p-4 rounded-lg shadow border-l-2 border-orange-400">
                    <h3 class="text-xl font-semibold mb-2">{{ $pendingJob }}</h3>
                    <div class="flex flex-wrap justify-between items-center">
                        <p class="text-gray-600 dark:text-white">{{ __('main.pending_ad') }}</p>
                    </div>
                </div>
            </div>

            <div class="p-2 relative">
                <div class="bg-white dark:bg-gray-700  p-4 rounded-lg shadow border-l-2 border-orange-400">
                    <h3 class="text-xl font-semibold mb-2">{{ $approveJob }}</h3>
                    <div class="flex flex-wrap justify-between items-center">
                        <p class="text-gray-600 dark:text-white">{{ __('main.approve_ad') }}</p>
                    </div>
                </div>
            </div>

            <div class="p-2 relative">
                <div class="bg-white dark:bg-gray-700  p-4 rounded-lg shadow border-l-2 border-orange-400">
                    <h3 class="text-xl font-semibold mb-2">{{ $myPackages }}</h3>
                    <div class="flex flex-wrap justify-between items-center">
                        <p class="text-gray-600 dark:text-white">{{ __('main.my_packages') }}</p>
                    </div>
                </div>
            </div>

            <div class="p-2 relative">
                <div class="bg-white dark:bg-gray-700  p-4 rounded-lg shadow border-l-2 border-orange-400">
                    <h3 class="text-xl font-semibold mb-2">{{ $pendingOrder }}</h3>
                    <div class="flex flex-wrap justify-between items-center">
                        <p class="text-gray-600 dark:text-white">{{ __('main.my_orders') }}</p>
                    </div>
                </div>
            </div>

        </div>



        <div class="w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4">


            <canvas id="myChart" class="w-full"></canvas>


        </div>





@endsection

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>


const daysOfWeek = @json($allDays);
const visitsData = @json($visitsData);
const mainLabel = "{{ __('main.visit_of_days') }}";
const systemLocale = "{{ app()->getLocale() }}";

  $(document).ready(function() {
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: daysOfWeek.map(day => {
                if (systemLocale === 'tr') {
                    switch (day) {
                        case 'Monday': return 'Pazartesi';
                        case 'Tuesday': return 'Salı';
                        case 'Wednesday': return 'Çarşamba';
                        case 'Thursday': return 'Perşembe';
                        case 'Friday': return 'Cuma';
                        case 'Saturday': return 'Cumartesi';
                        case 'Sunday': return 'Pazar';
                        default: return day;
                    }
                } else {
                    return day;
                }
            }),
            datasets: [{
            label: mainLabel,
            data: visitsData,
            borderWidth: 1
            }]
        },
        options: {
            scales: {
            y: {
                beginAtZero: true
            }
            }
        }
    });
  })
</script>
@endpush
