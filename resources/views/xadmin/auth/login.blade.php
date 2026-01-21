@extends('xadmin.layouts.default') @section('content')



    <div class="fixed top-0 left-0 right-0 bottom-0 bg-gray-100"></div>

    <div class="flex min-h-full flex-col items-center justify-center px-6 py-12 lg:px-8 z-20 relative">

        <div class="wrapper_login w-full max-w-[400px] bg-white py-5 px-5 sm:py-10 sm:px-10 rounded-lg">
            <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Admin Panel</h2>
            </div>

            <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">

                @if ($errors->any())
                    <div class="bg-red-600 mb-3 text-white p-1 px-2 rounded-sm text-sm">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form class="space-y-3" action="{{ route('xloginPost') }}"method="POST">

                    <div class="wrapper_control mb-2">
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                        <div class="mt-2">
                            <input id="email" name="email" type="email" autocomplete="email" required
                                class="px-2 block w-full rounded-md border border-gray-200 py-1.5 text-gray-900 shadow-sm sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div class="wrapper_control">
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Şifre</label>
                        <div class="mt-2">
                            <input id="password" name="password" type="password" autocomplete="email" required
                                class="px-2 block w-full rounded-md border border-gray-200 py-1.5 text-gray-900 shadow-smsm:text-sm sm:leading-6">
                        </div>
                    </div>



                    <div>
                        <button type="submit"
                            class="flex w-full justify-center rounded-md bg-orange-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-orange-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-600">Giriş
                            yap</button>
                    </div>
                </form>

                <div class="flex justify-center items-center py-6">
                    <a href="https://mstofix.com" title="mstofix mersin web tasarım ve yazılım hizmetleri"
                        rel="noopener noreferrer" target="_blank">
                        <img src="https://mstofix.com/public/mstofix.png"
                            alt="mstofix - Mersin'de Web Tasarım ve Yazılım Hizmetleri" loading="lazy" width="50"
                            height="auto" />
                    </a>
                </div>

            </div>
        </div>

    </div>

@endsection
