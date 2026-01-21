@extends('layouts.default', ['title' => 'Hesabınıza Giriş Yapın', 'image' => ''])

@section('content')




<section class="h-screen flex items-center justify-center relative overflow-hidden bg-no-repeat bg-center bg-cover">
    <div class="absolute inset-0 bg-gradient-to-b to-orange-800 from-black"></div>
    <div class="container">
        <div class="flex flex-wrap items-center">
            <div class="relative w-full md:w-1/3 overflow-hidden bg-white dark:bg-slate-900 shadow-md dark:shadow-gray-800 dark:text-white rounded-md">
                <div class="p-6">
                    <img src="{{ asset('assets/images/logo-dark.png') }}" class="mx-auto h-[40px] block dark:hidden" alt="">
                    <img src="{{ asset('assets/images/logo-light.png') }}" class="mx-auto h-[40px] dark:block hidden" alt="">

                    @if (session('success'))
                        <div class="bg-green-700 my-8 text-center text-white">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-700 my-8 text-center text-white">
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

                    <h5 class="my-6 text-xl font-semibold">Yeni Şifre Oluştur</h5>
                    <form class="text-start" action="{{ route('newPasswordPost') }}" method="post">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ $email }}">

                        <div class="grid grid-cols-1">
                            <div class="mb-4 text-start">
                                <label class="font-semibold" for="new_password">Yeni Şifre:</label>
                                <input id="new_password" type="new_password" name="new_password"  class="px-2 block w-full border border-1 border-gray-200 py-1 mt-1 rounded-md dark:bg-gray-800 dark:border-gray-800" required>
                            </div>
                            <div class="mb-4 text-start">
                                <label class="font-semibold" for="new_password_confirmation">Yeni Şifre Tekrar:</label>
                                <input id="new_password_confirmation" type="new_password_confirmation" name="new_password_confirmation"  class="px-2 block w-full border border-1 border-gray-200 py-1 mt-1 rounded-md dark:bg-gray-800 dark:border-gray-800" required>
                            </div>

                            <div class="mb-4">
                                <button type="submit" class="btn cursor-pointer py-2 bg-orange-600 hover:bg-orange-700 border-orange-600 hover:border-orange-700 text-white rounded-md w-full">Yeni Şifreyi Kaydet</button>
                            </div>

                            <div class="text-center">
                                <span class="text-slate-400 me-2">Hesabınız yok mu ?</span> <a href="{{ route('registerGet') }}" class="text-black dark:text-white font-bold">Yeni Hesap Oluştur</a>
                            </div>
                        </div>
                    </form>
                </div>


            </div>
            <div class="relative flex-1 text-right px-5">
                <h2 class="text-white text-6xl font-extralight mb-5">Yeni <span class="font-extrabold">şifre</span> belirleyin.</h2>
                <p class="text-white">Yeni şifreniz güvenilir olmalıdır.</p>
            </div>
        </div>
    </div>
</section><!--end section -->



@endsection
