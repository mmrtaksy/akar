@extends('pages.account.layout')
@section('account_content')

    <h5 class="text-lg font-semibold mb-4 flex justify-between items-center"> <span>{{ __('main.user_list') }}</span>
        <a href="@localizedRoute('account_userCreateGet')" class="text-white text-sm p-1 px-3 rounded-md bg-orange-600 hover:bg-orange-700">{{ __('main.add_new') }}</a>
    </h5>


    <div class="data_list w-full p-3">

        @foreach ($users as $item)


        <div class="group relative mt-6 p-3 border-2 border-gray-200 hover:border-orange-600 rounded-md">
            <a href="@localizedRoute('account_userUpdateGet', ['id' => $item->id])" class="flex w-full justify-between items-center">
                <div class="left_wrap">
                    <h5 class="text-lg font-medium mb-0">{{ $item->user->fullname }}</h5>
                    <span class="text-slate-500 block">{{ $item->user->email }}
                     @if ($item->user->email_verified_at)
                         <i class="uil uil-check align-middle text-xl text-green-600" title="{{ __('main.email_verified') }}"></i>
                        @else
                        <i class="uil uil-info-circle align-middle text-lg text-gray-400" title="{{ __('main.email_not_verified') }}"></i>
                     @endif
                    </span>
                    <span class="text-slate-500 block text-sm">{{ __('main.register_date') }}: {{ date_format( $item->user->created_at,"d.m.Y H:i") }}</span>
                </div>
                <i class="uil uil-setting align-middle text-lg text-gray-400 group-hover:text-orange-600"></i>
            </a>
        </div>

        @endforeach


    </div>

@endsection
