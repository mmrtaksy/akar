@extends('pages.account.layout')
@section('account_content')



    @if (session('error'))
    <div class="bg-red-600 text-white px-3 py-1 rounded-sm text-sm my-3">
        {{ session('error') }}
    </div>
    @endif

    <h5 class="text-lg font-semibold mb-4 flex justify-between items-center"> <span>{{ __('main.package_list') }} ({{ $data->count() }})</span>
        <a href="@localizedRoute('userPackageTakeGet')" class="text-white text-sm p-1 px-3 rounded-md bg-orange-600 hover:bg-orange-700">{{ __('main.get_new_package') }}</a>
    </h5>


    <div class="data_list w-full p-3">

        @foreach ($data as $item)


        <div class="group relative mt-6 p-3 border-2 border-gray-200 dark:border-gray-700 rounded-md">
            <div class="flex w-full flex-wrap">
                    <div class="flex justify-between items-center w-full">
                        <h5 class="text-lg font-medium mb-0 flex-1">{{ $item->package->title }}</h5>
                        <span class="text-gray-500 dark:text-white text-sm font-medium block">{{ Helper::paystatu($item->pay_statu) }}</span>
                    </div>
                    <span class="text-gray-600 dark:text-gray-400 text-sm block">{{ $item->package->description }}</span>
                    <hr class="my-3 block w-full border-gray-200 dark:border-gray-700">

                    <div class="w-full block relative">
                        <p class="text-sm mb-2">{{ __('main.right_of_featured') }}: {{ $item->package->feature_ad_quantity }}</p>
                        <p class="text-sm mb-2">{{ __('main.left_of_day') }}: {{ $item->package->left_duration_day }}</p>
                        <div class="bg-gray-200 h-1.5 rounded-full dark:bg-gray-700">
                            <div class="bg-orange-600 h-1.5 rounded-full dark:bg-orange-500" style="width: {{ $item->package->progress_percentage }}%"></div>
                        </div>
                    </div>


                    <hr class="my-3 block w-full border-gray-200 dark:border-gray-700">

                    <div class="flex justify-between items-center w-full">
                        <span class="text-gray-500 block text-sm">{{ __('main.order_date') }}: {{ date_format( $item->created_at,"d.m.Y H:i") }}</span>
                        @if ($item->pay_statu == 'approved')
                            <span class="text-gray-500 block text-sm">{{ __('main.approve_date') }}: {{ date_format( $item->updated_at,"d.m.Y H:i") }}</span>
                        @elseif ($item->pay_statu == 'cancelled')
                            <span class="text-gray-500 block text-sm">{{ __('main.reject_date') }}: {{ date_format( $item->updated_at,"d.m.Y H:i") }}</span>
                        @endif

                    </div>
            </div>
        </div>

        @endforeach


    </div>

@endsection
