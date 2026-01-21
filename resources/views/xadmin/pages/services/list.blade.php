@php
    $panelMenu = Helper::panelMenu($modelId);
@endphp
@extends('xadmin.layouts.default')
@section('content')
    @php
        $tdClass = 'px-2 border border-gray-300';
    @endphp

    <div class="bg-white p-4 rounded-lg shadow-md w-full mx-auto">


        <div class="mb-3 relative flex items-center justify-between">
            <h3 class="text-lg font-semibold">{{ $panelMenu['title'] }}</h3>
            <form action="{{ route('servicesList') }}" method="GET" class="mb-0">
                <input type="text" placeholder="Listelerde ara..." value="{{ Request::get('q') ?? '' }}" name="q"
                    class="border-2 border-gray-200 px-2 py-1 rounded-md">
                <input type="hidden" name="model_id" value="{{ $modelId }}" />
                <input type="hidden" name="lang" value="{{ $listlang }}" />
            </form>
            <a class="text-md text-blue-600 font-medium inline-block"
                href="{{ route('servicesCreateGet', ['model_id' => $modelId, 'parent_id' => $parent_id, 'lang' => $listlang]) }}">Yeni
                bir tane
                ekle</a>
        </div>



        @if (session('success'))
            <div class="bg-green-600 text-white px-3 py-1 rounded-sm text-sm my-3">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-600 text-white px-3 py-1 rounded-sm text-sm my-3">
                {{ session('error') }}
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



        <div class="mb-3 relative flex items-center gap-3">
            @foreach (Helper::langs() as $lang)
                <a href="{{ route('servicesList', ['lang' => $lang->id, 'model_id' => $modelId]) }}"
                    class="{{ $lang->id == $listlang ? 'bg-green-600' : 'bg-gray-500' }} text-white px-4 rounded-full sm:py-1 hover:bg-green-600 focus:outline-none focus:bg-green-700 inline-block">
                    {{ strtoupper($lang->native) }}
                </a>
            @endforeach
        </div>




        <div class="relative overflow-x-auto lg:overflow-visible max-w-full">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" id="tableList">
                <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 border border-gray-300">#</th>
                        @if ($panelMenu['image'])
                            <th class="px-4 py-2 border border-gray-300">Resim</th>
                        @endif
                        <th class="px-4 py-2 border border-gray-300">Başlık</th>
                        <th class="px-4 py-2 border border-gray-300">Parent</th>
                        <th class="px-4 py-2 border border-gray-300">Açıklama</th>
                        <th class="px-4 py-2 border border-gray-300">Durum</th>
                        @if ($panelMenu['categories'])
                            <th class="px-4 py-2 border border-gray-300">Alt Kategori</th>
                        @endif
                        <th class="px-4 py-2 border border-gray-300" width="200">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        @if ($panelMenu['image'])
                            @php
                                $detail = $item->primaryModel;
                                $imageCover =
                                    $detail && $detail->primaryImages->isNotEmpty()
                                        ? $detail->primaryImages->firstWhere('is_first', true)
                                        : null;
                            @endphp
                        @endif


                        <tr>
                            <td class="{{ $tdClass }}">{{ $item->id }}</td>
                            @if ($panelMenu['image'])
                                <td class="{{ $tdClass }}">
                                    @isset($item->single_path)
                                        @php
                                            $path = 'uploads/' . $item->single_path->path;
                                            $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                                            $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif']);
                                        @endphp

                                        @if ($isImage)
                                            <img src="{{ asset($path) }}" class="size-10 object-cover">
                                        @else
                                            <div class="w-10 h-10 flex items-center justify-center bg-gray-100 rounded">
                                                @switch($extension)
                                                    @case('pdf')
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-600"
                                                            fill="currentColor" viewBox="0 0 24 24">
                                                            <path
                                                                d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6zm1 7V3.5L20.5 9H15z" />
                                                        </svg>
                                                    @break

                                                    @case('doc')
                                                    @case('docx')
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600"
                                                            fill="currentColor" viewBox="0 0 24 24">
                                                            <path
                                                                d="M4 2a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h16a2 2 0 0 0 2-2V6l-6-4H4zm14 18H6V4h7v5h5v11z" />
                                                        </svg>
                                                    @break

                                                    @case('xls')
                                                    @case('xlsx')
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600"
                                                            fill="currentColor" viewBox="0 0 24 24">
                                                            <path
                                                                d="M19 2H8c-1.1 0-2 .9-2 2v2H5a2 2 0 0 0-2 2v10c0 1.1.9 2 2 2h1v2c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V4a2 2 0 0 0-2-2zM6.5 12.5 8 11l1.5 1.5L11 11l1.5 1.5L11 14l1.5 1.5L11 17l-1.5-1.5L8 17l-1.5-1.5L8 14l-1.5-1.5z" />
                                                        </svg>
                                                    @break

                                                    @default
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400"
                                                            fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z" />
                                                        </svg>
                                                @endswitch
                                            </div>
                                        @endif
                                    @endisset
                                </td>
                            @endif
                            <td class="{{ $tdClass }}">{{ $item->title }}</td>
                            <td class="{{ $tdClass }}">{{ $item->parentadmin ? $item->parentadmin->title : '' }}</td>
                            <td class="{{ $tdClass }}">{{ Str::of(Helper::turkishcharacters(strip_tags($item->description)))->limit(100) }}</td>
                            <td class="{{ $tdClass }}">{{ $item->statu == 1 ? 'Yayında' : 'Taslak' }}</td>
                            @if ($panelMenu['categories'])
                                <td class="{{ $tdClass }}">{{ $item->childrenadmin()->count() }}</td>
                            @endif
                            <td class="{{ $tdClass }} text-center">
                                <div class="grid grid-cols-4 w-96 items-center gap-3 p-3">


                                    @if ($panelMenu['categories'])
                                        @if ($item->childrenadmin()->count() > 0)
                                            <a href="{{ route('servicesList', ['parent_id' => $item->id, 'lang' => $listlang, 'model_id' => $modelId]) }}"
                                                class="bg-gray-500 text-white px-2 py-2 rounded-lg sm:px-4 sm:py-2 sm:rounded-md hover:bg-green-600 focus:outline-none focus:bg-green-600 inline-block">
                                                Kategoriler
                                            </a>
                                        @else
                                            <span></span>
                                        @endif
                                        <a href="{{ route('servicesCreateGet', ['parent_id' => $item->id, 'model_id' => $modelId]) }}"
                                            class="bg-gray-500 text-white px-2 py-2 rounded-lg sm:px-4 sm:py-2 sm:rounded-md hover:bg-green-600 focus:outline-none focus:bg-green-600 inline-block">
                                            Yeni Alt Kategori
                                        </a>
                                    @endif


                                    <a href="{{ route('servicesUpdateGet', ['id' => $item->id, 'lang' => $listlang, 'model_id' => $modelId]) }}"
                                        class="bg-green-500 text-white px-2 py-2 rounded-lg sm:px-4 sm:py-2 sm:rounded-md hover:bg-green-600 focus:outline-none focus:bg-green-600 inline-block">
                                        Düzenle
                                    </a>


                                    <a href="{{ route('servicesDelete', ['id' => $item->id]) }}"
                                        class="isdelete bg-red-500 text-white px-2 py-2 rounded-lg sm:px-4 sm:py-2 sm:rounded-md mr-2 hover:bg-red-600 focus:outline-none focus:bg-red-600 inline-block">
                                        Sil
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    <!-- Diğer satırları buraya ekle -->
                </tbody>
            </table>
        </div>
        @if (!$data->count())
            <div class="text-center mt-5">
                <div class="text-sm text-gray-400">Veri bulunamadı</div>
                <a class="text-md text-blue-600 font-medium mt-5 inline-block"
                    href="{{ route('servicesCreateGet', ['model_id' => $modelId, 'parent_id' => $parent_id]) }}">Yeni
                    bir tane ekle</a>
            </div>
        @endif


        <div class="flex flex-wrap justify-between items-center pagination mt-3 gap-6">
            <div class="flex flex-wrap gap-6">
                <a class="text-md text-blue-600 font-medium inline-block"
                    href="{{ route('servicesSortGet', ['lang' => $listlang, 'model_id' => $modelId]) }}">Yeniden Sırala</a>
                <a class="isdelete text-md text-red-600 font-medium inline-block"
                    href="{{ route('servicesDeleteAll', ['lang' => $listlang, 'model_id' => $modelId]) }}">Tüm verileri
                    sil</a>
            </div>
            <div>
                {{ $data->links('vendor.pagination.bootstrap') }}
            </div>
        </div>
    </div>
@endsection
