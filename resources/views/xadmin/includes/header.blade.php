<nav class="bg-gray-800 p-4 w-full">
    <div class="mx-auto flex justify-between items-center">
      <div class="flex-1 flex">
        <a href="{{ route('home') }}" class="text-white">
          Admin Panel
        </a>
      </div>
      <div>
        <ul class="flex">
          <li class="block lg:hidden">
            <a href="{{ route('home') }}" class="text-white flex gap-2 px-2 border-r border-slate-600 mr-2" id="menu">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
              </svg>
            </a>
          </li>
          <li>
            <a href="{{ Request::root() }}" target="_blank" class="text-white flex items-center gap-2 pl-2 pr-4 border-r border-slate-600 mr-2">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
              </svg>
              <span class="hidden lg:inline-block">Siteye geç</span>
            </a>
          </li>
          <li>
            <a href="{{ route('messagesList') }}" class="text-white flex items-center gap-2 pl-2 pr-4 border-r border-slate-600 mr-2">

            <svg viewBox="0 0 24 24" stroke-width="1.5" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6">
              <path d="M2 7L10.1649 12.7154C10.8261 13.1783 11.1567 13.4097 11.5163 13.4993C11.8339 13.5785 12.1661 13.5785 12.4837 13.4993C12.8433 13.4097 13.1739 13.1783 13.8351 12.7154L22 7M6.8 20H17.2C18.8802 20 19.7202 20 20.362 19.673C20.9265 19.3854 21.3854 18.9265 21.673 18.362C22 17.7202 22 16.8802 22 15.2V8.8C22 7.11984 22 6.27976 21.673 5.63803C21.3854 5.07354 20.9265 4.6146 20.362 4.32698C19.7202 4 18.8802 4 17.2 4H6.8C5.11984 4 4.27976 4 3.63803 4.32698C3.07354 4.6146 2.6146 5.07354 2.32698 5.63803C2 6.27976 2 7.11984 2 8.8V15.2C2 16.8802 2 17.7202 2.32698 18.362C2.6146 18.9265 3.07354 19.3854 3.63803 19.673C4.27976 20 5.11984 20 6.8 20Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              @if(Helper::messageCount())
              <span class="inline-block px-2 font-semibold text-sm py-0 rounded-full bg-red-600 text-white">{{ Helper::messageCount() }}</span>
              @endif
            </a>
          </li>
          @auth
          <li>
            <a href="{{ route('userUpdateGet', ['id' => Auth::user()->id]) }}" class="text-white flex gap-2 pl-2 pr-4 border-r border-slate-600 mr-2">
              <span class="hidden lg:inline-block">{{ Auth::user()->name }}</span>
            </a>
          </li>
          @endauth
          <li>
            <a href="{{ route('logout') }}" class="text-white flex gap-2">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="w-6 h-6"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9"
                />
              </svg>
              <span class="hidden lg:inline-block">Çıkış yap</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="flex flex-col lg:flex-row w-full">
    <!-- Sidebar -->
   @include('xadmin.includes.menu')



