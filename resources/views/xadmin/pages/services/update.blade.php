@php
    $panelMenu = Helper::panelMenu($modelId);
@endphp
@extends('xadmin.layouts.default')
@section('content')


    <form action="{{ route('servicesUpdatePost') }}" method="post">
        @csrf
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 md:col-span-6">
                <div class="bg-white p-4 rounded-lg shadow-md">

                    <div class="p-3 relative ">
                        <div class="flex flex-wrap justify-between">
                            <div class="mb-3 relative">
                                <h3 class="text-lg font-semibold"> <span>{{ $panelMenu['title'] }}</span> <span>- Kaydı
                                        Düzenle </span>
                                    @if ($locale->id != 1)
                                        <span>-</span>
                                        <span
                                            class="bg-green-600 py-1 px-4 text-white rounded-md text-sm mx-2">{{ strtoupper($locale->native) }}
                                            dilini düzenliyorsunuz</span>
                                    @endif
                                </h3>
                                <div class="text-sm text-gray-400">*'lı alanlar zorunludur</div>
                            </div>

                            <div class="form-group flex items-center justify-end col-span-2 gap-2">
                                <input type="hidden" name="model_id" value="{{ $modelId }}">
                                <input type="hidden" name="id" value="{{ $data->id }}">
                                <input type="hidden" name="lang" value="{{ $locale->id }}">
                                <a href="{{ route('servicesList', ['model_id' => $modelId, 'lang' => $locale->id]) }}"
                                    class="bg-gray-400 hover:bg-gray-500 text-white rounded-md px-3 py-1"
                                    type="submit">Listeye dön</a>
                               

                                @foreach (Helper::langs() as $lang)
                                    @if($lang->id != 1)
                                        <a href="{{ route('servicesUpdateGet', ['id' => ($data->id + 1), 'lang' => $lang->id, 'model_id' => $modelId]) }}"
                                            class="bg-green-600 text-white px-4 rounded-full sm:py-1 hover:bg-green-600 focus:outline-none focus:bg-green-700 inline-block">
                                            {{ strtoupper($lang->native) }}
                                        </a>
                                    @endif
                                @endforeach

                                
                                <button class="bg-orange-600 hover:bg-orange-700 text-white rounded-md px-3 py-1"
                                    type="submit">Güncelle</button>
                            </div>
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



                        <div class="mx-auto grid grid-cols-2 gap-6">


                            <div class="form-group mb-3 col-span-2">
                                <label for="title"
                                    class="block text-sm font-medium leading-6 text-gray-900">Başlık*</label>
                                <div class="mt-2">
                                    <input id="title" name="title" type="text"
                                        value="{{ old('title') ?? $data->title }}" required
                                        class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>



                            <div class=" col-span-2 mb-3">
                                <div class="grid md:grid-cols-2 gap-4">

                                    @if ($panelMenu['categories'])
                                        <div class="form-group">
                                            <label for="parent_id"
                                                class="block text-sm font-medium leading-6 text-gray-900">Kategori</label>
                                            <div class="mt-2">
                                                <select id="parent_id" name="parent_id"
                                                    class="select2 px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                    <option value="">Ana kategori</option>
                                                    @foreach ($parents as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ $data->parent_id == $item->id ? 'selected' : '' }}>
                                                            {{ $item->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif


                                    <div class="form-group">
                                        <label for="statu"
                                            class="block text-sm font-medium leading-6 text-gray-900">Durum</label>
                                        <div class="mt-2">
                                            <select id="statu" name="statu"
                                                class="select2 px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                <option value="0" {{ $data->statu ? 'selected' : '' }}>Taslak</option>
                                                <option value="1" {{ $data->statu ? 'selected' : '' }}>Yayında
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="form-group mb-3 col-span-2">
                                <label for="description"
                                    class="block text-sm font-medium leading-6 text-gray-900">Açıklama*</label>
                                <div class="mt-2">
                                    @if ($panelMenu['editor'])
                                        <textarea id="description" rows="6" name="description" required
                                            class="content px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">{{ old('description') ?? $data->description }}</textarea>
                                    @else
                                        <input type="text" id="description" name="description" required
                                            value="{{ old('description') ?? $data->description }}"
                                            class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    @endif
                                </div>
                            </div>






                            @isset($panelMenu['extra'])
                                @foreach (Helper::isArray($panelMenu['extra']) as $extra)
                                    <div class="form-group mb-3 col-span-2">
                                        <h3 class="text-md font-semibold text-gray-900 mb-2">{{ $extra['field_title'] }}</h3>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
                                            @foreach ($extra['fields'] as $field)
                                                <div class="mb-3">
                                                    <label for="{{ $field['name'] }}"
                                                        class="block text-sm font-medium leading-6 text-gray-900">
                                                        {{ $field['label'] }}
                                                    </label>
                                                    <div class="mt-2">
                                                        <input id="{{ $field['name'] }}"
                                                            name="extra[{{ $loop->index }}][{{ $field['name'] }}]"
                                                            value="{{ collect($mergedExtras)->where('name', $field['name'])->first()['value'] ?? '' }}"
                                                            type="text"
                                                            value="{{ old('extra.' . $loop->index . '.' . $field['name']) }}"
                                                            required
                                                            class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            @endisset





                        </div>


                    </div>
                </div>

            </div>


            @if ($panelMenu['image'] || $panelMenu['meta'])
                <div class="col-span-12 md:col-span-3">
                    @if ($panelMenu['meta'])
                        <div class="bg-white p-4 rounded-lg shadow-md relative">
                            <div class="mb-3 relative">
                                <h3 class="text-lg font-semibold flex justify-between items-center"><span>SEO
                                        Yönetimi</span>
                                    @if ($locale->id != 1)
                                        <a data-id="{{ $data->id }}"
                                            class="transferMetaFromTR text-gray-400 hover:text-red-600 text-center text-sm"
                                            href="#">Türkçeden Aktar</a>
                                    @endif
                                </h3>


                                <div class="text-sm text-gray-400">Uygun meta bilgilerini giriniz</div>
                            </div>

                            <div class="form-group mb-3 col-span-2">
                                <label for="slug" class="block text-sm font-medium leading-6 text-gray-900">Slug</label>
                                <div class="my-2">
                                    <input id="slug" name="slug" type="text"
                                        value="{{ old('slug') ?? $data->slug }}"
                                        class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                                <label for="meta_title" class="block text-sm font-medium leading-6 text-gray-900">Meta
                                    Title</label>
                                <div class="my-2">
                                    <input id="meta_title" name="meta_title" type="text"
                                        value="{{ old('meta_title') ?? $data->meta_title }}"
                                        class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>

                                <label for="meta_description"
                                    class="block text-sm font-medium leading-6 text-gray-900">Meta
                                    Description</label>
                                <div class="my-2">
                                    <input id="meta_description" name="meta_description" type="text"
                                        value="{{ old('meta_description') ?? $data->meta_description }}"
                                        class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>

                                <label for="meta_keywords" class="block text-sm font-medium leading-6 text-gray-900">Meta
                                    Keywords</label>
                                <div class="my-2">
                                    <input id="meta_keywords" name="meta_keywords" type="text"
                                        value="{{ old('meta_keywords') ?? $data->meta_keywords }}"
                                        class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>

                        </div>
                    @endif




                    <div class="bg-white p-4 rounded-lg shadow-md relative {{ $panelMenu['meta'] ? 'mt-4' : '' }}">
                        <div class="form-group mb-3 col-span-2">


                            <h3 class="text-lg font-semibold flex justify-between items-center"><span>Seçilen
                                    Resimler</span>
                                @if ($locale->id != 1)
                                    <a data-id="{{ $data->id }}"
                                        class="transferFromTR text-gray-400 hover:text-red-600 text-center text-sm"
                                        href="#">Türkçeden Aktar</a>
                                @endif
                            </h3>

                            <div class="mt-2 flex flex-wrap gap-2 adderImages">

                                @foreach ($data->images as $item)
                                    @php
                                        $path = 'uploads/' . $item->path;
                                        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                                        $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif']);
                                    @endphp

                                    <div class="relative static-image-item border {{ $item->is_first ? 'border-green-400' : '' }} p-2"
                                        data-image-path="{{ $item->path }}">

                                        @if ($isImage)
                                            <img src="{{ asset($path) }}" class="size-24 object-cover">
                                        @else
                                            <div class="w-24 h-24 flex items-center justify-center bg-gray-100 rounded">
                                                @switch($extension)
                                                    @case('pdf')
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-red-600"
                                                            fill="currentColor" viewBox="0 0 24 24">
                                                            <path
                                                                d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6zm1 7V3.5L20.5 9H15z" />
                                                        </svg>
                                                    @break

                                                    @case('doc')
                                                    @case('docx')
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-blue-600"
                                                            fill="currentColor" viewBox="0 0 24 24">
                                                            <path
                                                                d="M4 2a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h16a2 2 0 0 0 2-2V6l-6-4H4zm14 18H6V4h7v5h5v11z" />
                                                        </svg>
                                                    @break

                                                    @case('xls')
                                                    @case('xlsx')
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-green-600"
                                                            fill="currentColor" viewBox="0 0 24 24">
                                                            <path
                                                                d="M19 2H8c-1.1 0-2 .9-2 2v2H5a2 2 0 0 0-2 2v10c0 1.1.9 2 2 2h1v2c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V4a2 2 0 0 0-2-2zM6.5 12.5 8 11l1.5 1.5L11 11l1.5 1.5L11 14l1.5 1.5L11 17l-1.5-1.5L8 17l-1.5-1.5L8 14l-1.5-1.5z" />
                                                        </svg>
                                                    @break

                                                    @default
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-400"
                                                            fill="currentColor" viewBox="0 0 24 24">
                                                            <path
                                                                d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z" />
                                                        </svg>
                                                @endswitch
                                            </div>
                                        @endif

                                        <a href="#"
                                            class="remove_image block text-gray-400 hover:text-red-600 text-center text-sm my-2 font-semibold">kaldır</a>
                                        <a href="#"
                                            class="set_first block text-gray-400 hover:text-red-600 text-center text-sm my-2 font-semibold"
                                            data-serviceid="{{ $data->id }}" data-id="{{ $item->id }}">kapak
                                            seç</a>
                                        <input type="hidden" value="{{ $item->path }}" name="images[]" />
                                    </div>
                                @endforeach


                            </div>
                        </div>
                    </div>


                </div>
            @endif


            @if ($panelMenu['image'])
                <div class="col-span-12 md:col-span-3">
                    <div class="bg-white p-4 rounded-lg shadow-md relative">
                        <div class="mb-3 relative">
                            <h3 class="text-lg font-semibold flex justify-between items-center"><span>Dosya/Resim Yönetimi</span>
                                <a class="getImages text-gray-400 hover:text-red-600 text-center text-sm"
                                    href="#">Dosya/Resimleri getir</a>
                            </h3>
                            <div class="text-sm text-gray-400">İlgili resme tıklayıp seçim yapabilirsiniz</div>
                        </div>
                        <div class="form-group mb-3 col-span-2">
                            <label for="image" class="block text-sm font-medium leading-6 text-gray-900">Yeni Dosya/Resim
                                Ekle</label>
                            <div class="mt-2">

                                <form id="image-upload-form">
                                    <input id="newimages" {{ $panelMenu['multiple_image'] ? 'multiple' : '' }}
                                        type="file"
                                        class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    <div class="p-2 text-center">
                                        <button type="button" id="upload-button"
                                            class="bg-orange-600 hover:bg-orange-700 text-white rounded-md px-3 py-1">Yükle</button>
                                    </div>
                                </form>


                                <div id="image-preview" class="grid grid-cols-3 gap-4 mt-4"></div>

                            </div>
                        </div>
                        <div id="images-container"
                            class="uploaded-images grid grid-cols-3 gap-3 border-t border-gray-200 pt-4 overflow-x-hidden max-h-[500px]">
                            <button type="button"
                                class="getImages text-orange-600 border-2 border-orange-600 font-semibold px-6 py-4 mx-auto col-span-4">Dosya/Resimleri
                                getir</button>
                        </div>


                    </div>
                </div>
            @endif

        </div>


    </form>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });




            const staticPath = "{{ env('IS_LOCAL') ? '/uploads/' : '/public/uploads/' }}";

            // Görsellerin yükleneceği container
            const imagesContainer = $('#images-container');
            const transferRoute = "{{ route('transferImages') }}";
            const transferMetaRoute = "{{ route('transferMetaRoute') }}";
            const uploadImages = "{{ route('uploadImages') }}";
            const imagesRoute = "{{ route('getImages') }}";

            function fetchImages() {
                $.ajax({
                    url: imagesRoute,
                    method: 'POST',
                    dataType: 'json',
                    xhrFields: {
                        withCredentials: true
                    },
                    success: function(data) {
                        // Mevcut içeriği temizle
                        imagesContainer.empty();

                        var result = Object.values(data);

                        // Eğer görseller varsa
                        if (result.length > 0) {
                            $.each(result, function(index, image) {
                                const fileExtension = image.split('.').pop().toLowerCase();
                                const isImage = ['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(
                                    fileExtension);
                                let fileElement;

                                if (isImage) {
                                    // Resimse direkt img göster
                                    fileElement = `
                <div class="image-item border p-2" data-image-path="${image}">
                    <img src="${staticPath}${image}" data-path="${image}" class="size-40 object-cover cursor-pointer selectImage">
                    <p class="text-xs mt-2 truncate w-full text-center" title="${image}">${image}</p>
                    <div class="relative flex justify-between w-full mt-2">
                        <a href="#" id="${image}" class="delete_image block text-center bg-gray-100 hover:bg-gray-200 w-full">sil</a>
                        <a href="#" data-link="${staticPath}${image}"  class="copylink block text-center bg-gray-100 hover:bg-gray-200 w-full">kopyala</a>
                    </div>
                </div>
            `;
                                } else {
                                    // Dosya türüne göre ikon seçimi
                                    let iconSVG = '';
                                    switch (fileExtension) {
                                        case 'pdf':
                                            iconSVG =
                                                `<svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-red-600 mx-auto" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6zm1 7V3.5L20.5 9H15z"/></svg>`;
                                            break;
                                        case 'doc':
                                        case 'docx':
                                            iconSVG =
                                                `<svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-blue-600 mx-auto" fill="currentColor" viewBox="0 0 24 24"><path d="M4 2a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h16a2 2 0 0 0 2-2V6l-6-4H4zm14 18H6V4h7v5h5v11z"/></svg>`;
                                            break;
                                        case 'xls':
                                        case 'xlsx':
                                            iconSVG =
                                                `<svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-green-600 mx-auto" fill="currentColor" viewBox="0 0 24 24"><path d="M19 2H8c-1.1 0-2 .9-2 2v2H5a2 2 0 0 0-2 2v10c0 1.1.9 2 2 2h1v2c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V4a2 2 0 0 0-2-2zM6.5 12.5 8 11l1.5 1.5L11 11l1.5 1.5L11 14l1.5 1.5L11 17l-1.5-1.5L8 17l-1.5-1.5L8 14l-1.5-1.5z"/></svg>`;
                                            break;
                                        default:
                                            iconSVG =
                                                `<svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-500 mx-auto" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/></svg>`;
                                    }

                                    fileElement = `
                <div class="image-item border p-2 flex flex-col items-center" data-image-path="${image}">
                    <div class="w-40 h-40 flex items-center justify-center bg-gray-50 cursor-pointer selectImage" data-path="${image}" >
                        ${iconSVG}
                    </div>
                    <p class="text-xs mt-2 truncate w-full text-center" title="${image}">${image}</p>
                    <div class="relative flex justify-between w-full mt-2">
                        <a href="#" id="${image}" class="delete_image block text-center bg-gray-100 hover:bg-gray-200 w-full">sil</a>
                        <a href="#" data-link="${staticPath}${image}"  class="copylink block text-center bg-gray-100 hover:bg-gray-200 w-full">kopyala</a>
                    </div>
                </div>
            `;
                                }

                                imagesContainer.append(fileElement);
                            });
                        } else {
                            imagesContainer.append('<p>Henüz yüklenmiş resim bulunamadı</p>');
                        }
                    },
                    error: function(xhr) {
                        console.error('Resimler getirilirken bir sorun oluştu:', xhr);
                    },
                });
            }



            $(document).on('click', '.copylink', function() {
                event.preventDefault();
                navigator.clipboard.writeText($(this).attr("data-link"));
            })

            function transferImages(pageid) {
                $.ajax({
                    url: transferRoute, // Laravel Route
                    method: 'POST',
                    data: {
                        "id": pageid
                    },
                    dataType: 'json',
                    xhrFields: {
                        withCredentials: true
                    },
                    success: function(data) {

                        $('.adderImages').html("");

                        var result = Object.values(data);

                        // Eğer görseller varsa
                        if (result.length > 0) {




                            $.each(result, function(index, item) {

                                let imagesBox = ` <div class="relative static-image-item border p-2" data-image-path="${item.path}">
                                                <img src="${staticPath}${item.path}" class="size-24 object-cover">
                                                <a href="#"
                                                    class="remove_image block text-gray-400 hover:text-red-600 text-center text-sm my-2 font-semibold">kaldır</a>
                                                    <input type="hidden" value="${item.path}" name="images[]" />
                                            </div>`;

                                $('.adderImages').append(imagesBox);


                            });
                        }
                    },
                    error: function(xhr) {
                        console.error('Resimler getirilirken bir sorun oluştu:', xhr);
                    },
                });
            }

            function transferMeta(pageid) {
                $.ajax({
                    url: transferMetaRoute, // Laravel Route
                    method: 'POST',
                    data: {
                        "id": pageid
                    },
                    dataType: 'json',
                    xhrFields: {
                        withCredentials: true
                    },
                    success: function(data) {

                        if (data) {
                            $('[name="meta_title"]').val(data.meta_title);
                            $('[name="meta_description"]').val(data.meta_description);
                            $('[name="meta_keywords"]').val(data.meta_keywords);
                        }

                    },
                    error: function(xhr) {
                        console.error('Resimler getirilirken bir sorun oluştu:', xhr);
                    },
                });
            }




            $(document).on('click', '.getImages', function() {

                $.get('/sanctum/csrf-cookie').then(() => {

                    fetchImages();
                });
            });

            $(document).on('click', '.transferFromTR', function() {
                let pageid = $(this).attr('data-id');
                transferImages(pageid);
            });

            $(document).on('click', '.transferMetaFromTR', function() {
                let pageid = $(this).attr('data-id');
                transferMeta(pageid);
            });


            $(document).on('click', '.remove_image', function() {
                $(this).parent('.static-image-item').remove();
                return false;
            });

            $(document).on('change', '#image', function() {
                const files = this.files;
                const previewContainer = $('#image-preview');
                previewContainer.empty(); // Önizleme alanını temizle

                if (files.length > 0) {
                    $.each(files, function(index, file) {
                        if (file.type.startsWith('image/')) {
                            const reader = new FileReader();

                            reader.onload = function(e) {
                                const imgElement = `
                                    <div class="image-item border p-2">
                                        <img src="${e.target.result}" alt="Image Preview" class="w-full h-auto">
                                    </div>
                                `;
                                previewContainer.append(imgElement);
                            };

                            reader.readAsDataURL(file);
                        } else {
                            alert('Lütfen yalnızca resim dosyaları seçin.');
                        }
                    });
                }
            });

            $(document).on('click', '#upload-button', function(e) {
                e.preventDefault();

                let formData = new FormData();


                const fileInput = $('#newimages')[0];


                // Dosyaların olup olmadığını kontrol ediyoruz
                if (fileInput && fileInput.files) {
                    Array.from(fileInput.files).forEach(image => {
                        formData.append('images[]', image);
                    });

                    console.log('FormData içerik:', ...formData);
                } else {
                    console.error('Dosyalar alınamadı!');
                }

                $('#upload-button').text('Yükleniyor...').prop('disabled', true);


                $.ajax({
                    url: uploadImages, // Laravel'deki yükleme rotası
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        $('#upload-button').text('Yükle').prop('disabled', false);
                        $('#image-preview').empty(); // Önizleme alanını temizle
                        $('#image').val(''); // Input'u sıfırla
                        fetchImages();
                    },
                    error: function(xhr) {
                        console.error('Yükleme sırasında hata oluştu:', xhr);
                        $('#upload-button').text('Yükle').prop('disabled', false);
                    },
                });
            });


            $(document).on('click', '.selectImage', function() {
                const image_path = $(this).attr('data-path');
                const extension = image_path.split('.').pop().toLowerCase();
                const isImage = ['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(extension);

                // Daha önce eklenmiş mi?
                if ($(`.adderImages input[value="${image_path}"]`).length === 0) {

                    let previewElement = '';

                    if (isImage) {
                        previewElement =
                            `<img src="${staticPath}${image_path}" class="size-24 object-cover">`;
                    } else {
                        let iconSVG = '';
                        switch (extension) {
                            case 'pdf':
                                iconSVG =
                                    `<svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-red-600" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6zm1 7V3.5L20.5 9H15z"/></svg>`;
                                break;
                            case 'doc':
                            case 'docx':
                                iconSVG =
                                    `<svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M4 2a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h16a2 2 0 0 0 2-2V6l-6-4H4zm14 18H6V4h7v5h5v11z"/></svg>`;
                                break;
                            case 'xls':
                            case 'xlsx':
                                iconSVG =
                                    `<svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-green-600" fill="currentColor" viewBox="0 0 24 24"><path d="M19 2H8c-1.1 0-2 .9-2 2v2H5a2 2 0 0 0-2 2v10c0 1.1.9 2 2 2h1v2c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V4a2 2 0 0 0-2-2zM6.5 12.5 8 11l1.5 1.5L11 11l1.5 1.5L11 14l1.5 1.5L11 17l-1.5-1.5L8 17l-1.5-1.5L8 14l-1.5-1.5z"/></svg>`;
                                break;
                            default:
                                iconSVG =
                                    `<svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-500" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/></svg>`;
                        }

                        previewElement =
                            `<div class="flex items-center justify-center w-24 h-24 bg-gray-100">${iconSVG}</div>`;
                    }

                    let imagesBox = `
            <div class="relative static-image-item border p-2 flex flex-col items-center">
                ${previewElement}
                    <p class="text-xs mt-2 truncate w-full text-center" title="${image_path}">${image_path}</p>
                <a href="#" class="remove_image block text-gray-400 hover:text-red-600 text-center text-sm my-2 font-semibold">kaldır</a>
                <input type="hidden" value="${image_path}" name="images[]" />
            </div>`;

                    $('.adderImages').append(imagesBox);
                }
            });


            $(document).on('click', '.delete_image', function() {
                var th = $(this);
                var id = th.attr('id');

                var delete_image_url = "{{ route('serviceDeleteImage') }}";

                if (!confirm(
                        'Silinen resim geri getirilemez. İşleme devam etmek istediğinize emin misiniz?')) {
                    return false;
                }

                $.ajax({
                    type: 'POST',
                    url: delete_image_url,
                    dataType: 'json',
                    xhrFields: {
                        withCredentials: true
                    },
                    data: {
                        id: id
                    },
                    success: function() {
                        $('div.image-item[data-image-path="' + id + '"]').remove();
                    }
                })
                return false;
            })

            $('.set_first').on('click', function() {
                var th = $(this);
                var id = th.attr('data-id');
                var service_id = th.attr('data-serviceid');

                var cover_route = "{{ route('serviceSetCoverImage') }}";


                $.ajax({
                    type: 'POST',
                    url: cover_route,
                    dataType: 'json',
                    data: {
                        id: id,
                        service_id: service_id
                    },
                    success: function() {
                        $('div.image-item').removeClass('border-green-400');
                        th.parent('div.image-item').addClass('border-green-400');
                    }
                })
                return false;
            })

        });
    </script>
@endpush
