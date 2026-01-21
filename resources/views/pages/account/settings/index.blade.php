@extends('pages.account.layout')
@section('account_content')


    @if (session('success'))
    <div class="bg-green-600 text-white px-3 py-1 rounded-sm text-sm my-3">
        {{ session('success') }}
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

    <form method="POST" action="@localizedRoute('account_userDeletePost')">
        <h5 class="text-lg font-semibold mb-4">{{ __('main.settings') }}</h5>
        @csrf
        <div class="wrapper_set_box p-2 border border-gray-200 dark:border-gray-700 rounded-md">
            <div class="text-2xl text-center dark:text-white font-semibold">{{ __('main.attention_please') }}</div>
            <div class="wrapper_warning mb-5 mt-3 text-center p-2 max-w-96 bg-gray-200 dark:bg-gray-700 mx-auto text-sm dark:text-white">
                {!! __('main.attention_please_not_1') !!}
                {!! __('main.attention_please_not_2') !!}
            </div>

            <div class="set_content my-3 text-center">
                <p>{{ __('main.delete_account_confirm', ['name' => Auth::user()->fullname]) }}</p>
                <input type="text" id="checkanswer" data-answer="{{ __('main.delete_key') }}" name="delete_answer_key" class="px-2 block w-full dark:bg-gray-800 dark:text-white border border-1 dark:border-gray-700 py-1 mt-3 rounded-md max-w-36 mx-auto text-center" placeholder="{{ __('main.delete_key') }}" required>
                <button type="submit" id="deleteAgreeBtn" class="inline-block bg-orange-600 hover:bg-orange-700 disabled:bg-gray-400 text-white rounded-sm mt-5 py-1 px-4" disabled>{{ __('main.delete_confirm_text') }}</button>
            </div>
        </div>
    </form>


@endsection


@push('scripts')
    <script>
        $(document).ready(function(){
            $('#checkanswer').on('keyup', function(){
                const dAnswer = $(this).attr('data-answer');
                const val = $(this).val().trim();
                if(val === dAnswer){
                    $('#deleteAgreeBtn').attr('disabled', false);
                }else{
                    $('#deleteAgreeBtn').attr('disabled', true);
                }
            })
        })
    </script>
@endpush
