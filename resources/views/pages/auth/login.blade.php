@extends('layouts.default', ['title' => 'Hesabınıza Giriş Yapın', 'image' => ''])

@section('content')




<section class="h-screen flex items-center justify-center relative overflow-hidden bg-no-repeat bg-center bg-cover">
    <div class="absolute inset-0 bg-gradient-to-b to-orange-800 from-black"></div>
    <div class="container">
        <div class="flex flex-col items-center">

            <div class="relative flex-1 my-10 text-center px-5">
                <h2 class="text-white text-4xl font-extralight mb-5">{!! __('main.login_title') !!}</h2>
                <p class="text-white text-sm">{{ __('main.login_subtitle') }}</p>
            </div>

            <div class="relative w-full md:max-w-md overflow-hidden bg-white dark:bg-gray-900 shadow-md dark:shadow-gray-800 rounded-md dark:text-white">
                <div class="p-6">

                    <img src="{{ asset('assets/images/logo-dark.png') }}" class="mx-auto h-[40px] block dark:hidden" alt="gelbasla">
                    <img src="{{ asset('assets/images/logo-light.png') }}" class="mx-auto h-[40px] dark:block hidden" alt="gelbasla">

                    @if (session('success'))
                        <div class="bg-green-700 my-8 text-center text-white p-2">
                            {{ session('success') }}
                        </div>
                    @endif


                    @if (session('error'))
                        <div class="bg-red-700 my-8 text-center text-white p-2">
                            {{ session('error') }}
                        </div>
                    @endif



                    @if ($errors->any())
                    <div class="bg-red-700 my-8 text-center text-white">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <h5 class="my-6 text-xl font-semibold">{{ __('main.login') }}</h5>
                    <form class="text-start" action="@localizedRoute('loginPost')" method="post">
                        <div class="grid grid-cols-1">
                            <div class="mb-4 text-start">
                                <label class="font-semibold" for="email">{{ __('main.email') }}:</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" class="px-2 block w-full border border-1 border-gray-200 py-1 mt-1 rounded-md dark:bg-gray-800 dark:border-gray-800" required>
                            </div>

                            <div class="mb-4 text-start">
                                <label class="font-semibold" for="LoginPassword">{{ __('main.password') }}:</label>
                                <input id="password" type="password" name="password" class="px-2 block w-full border border-1 border-gray-200 py-1 mt-1 rounded-md dark:bg-gray-800 dark:border-gray-800" required>
                            </div>

                            <div class="flex justify-end mb-4">
                                <a href="@localizedRoute('resetPasswordGet')" class="text-gray-400 hover:text-gray-600">{{ __('main.forgot_password') }}</a>
                            </div>

                            <div class="mb-4">
                                <input type="submit" class="btn cursor-pointer py-2 bg-orange-600 hover:bg-orange-700 border-orange-600 hover:border-orange-700 text-white rounded-md w-full" value="{{ __('main.login') }}">
                            </div>

                            <div class="text-center">
                                <span class="text-slate-400 me-2">{{ __('main.not_yet_account') }}</span> <a href="@localizedRoute('registerGet')" class="text-black dark:text-white font-bold">{{ __('main.create_new_account') }}</a>
                            </div>
                        </div>
                    </form>
                </div>


            </div>

        </div>
    </div>
</section><!--end section -->



@endsection
