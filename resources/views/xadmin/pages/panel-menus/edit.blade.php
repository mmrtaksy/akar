@extends('xadmin.layouts.default')
@section('content')
    <div class="bg-white p-4 rounded-lg shadow-md w-full lg:max-w-6xl mx-auto">


        <div class="mb-3 relative flex items-center justify-between">
            <h3 class="text-lg font-semibold">Yeni Menü Ekle</h3>
        </div>



        <div class="container mx-auto">

            <form action="{{ route('panel_menus.update') }}" method="post">
                @csrf

                <div class="grid grid-cols-2 gap-6">
                    <div class="form-group mb-3">
                        <label for="title" class="block text-sm font-medium text-gray-900">Başlık*</label>
                        <input id="title" name="title" type="text" required
                            value="{{ old('title', $data->title ?? '') }}"
                            class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                    </div>




                    <div class="form-group mb-3 flex items-center">
                        <input id="statu" name="statu" {{ $data->statu ? 'checked' : '' }} type="checkbox"
                            class="rounded border-gray-300">
                        <label for="statu" class="ml-2 text-sm font-medium text-gray-900">Aktif</label>
                    </div>

                    <div class="form-group mb-3 flex items-center">
                        <input id="meta" name="meta" type="checkbox" {{ $data->meta ? 'checked' : '' }}
                            class="rounded border-gray-300">
                        <label for="meta" class="ml-2 text-sm font-medium text-gray-900">Meta Bilgisi</label>
                    </div>

                    <div class="form-group mb-3 flex items-center">
                        <input id="editor" name="editor" type="checkbox" {{ $data->editor ? 'checked' : '' }}
                            class="rounded border-gray-300">
                        <label for="editor" class="ml-2 text-sm font-medium text-gray-900">Editor Kullanımı</label>
                    </div>

                    <div class="form-group mb-3 flex items-center">
                        <input id="multiple_image" name="multiple_image" {{ $data->multiple_image ? 'checked' : '' }}
                            type="checkbox" class="rounded border-gray-300">
                        <label for="multiple_image" class="ml-2 text-sm font-medium text-gray-900">Çoklu Resim</label>
                    </div>

                    <div class="form-group mb-3 flex items-center">
                        <input id="image" name="image" type="checkbox" {{ $data->image ? 'checked' : '' }}
                            class="rounded border-gray-300">
                        <label for="image" class="ml-2 text-sm font-medium text-gray-900">Resim</label>
                    </div>

                    <div class="form-group mb-3 flex items-center">
                        <input id="categories" name="categories" {{ $data->categories ? 'checked' : '' }} type="checkbox"
                            class="rounded border-gray-300">
                        <label for="categories" class="ml-2 text-sm font-medium text-gray-900">Kategoriler</label>
                    </div>
                </div>

                <!-- Dinamik Ekstra Alanlar -->
                <div class="form-group mb-3">
                    <label class="block text-sm font-medium text-gray-900">Ekstra Alanlar</label>
                    <div id="extra-fields-container">
                        @isset($data->extra)
                            @foreach (Helper::isArray($data->extra) as $groupIndex => $group)
                                @isset($group['field_title'])
                                    <div class="extra_itemm p-3 border rounded mb-3" data-group="{{ $groupIndex }}"><input
                                            type="text" placeholder="Grup Başlığı" value="{{ $group['field_title'] }}"
                                            name="extra[0][field_title]" class="px-2 py-1 border rounded w-full mb-2">
                                        <div class="fields-container">
                                            @isset($group['fields'])
                                                @foreach ($group['fields'] as $fieldIndex => $field)
                                                    <div class="mb-2 flex items-center gap-2 field_item"
                                                        data-group="{{ $fieldIndex }}" data-index="{{ $fieldIndex }}"><input
                                                            type="text" placeholder="Alan Başlığı" value="{{ $field['label'] }}"
                                                            name="extra[{{ $groupIndex }}][fields][{{ $fieldIndex }}][label]"
                                                            class="px-2 py-1 border rounded w-1/3"><input type="text"
                                                            placeholder="Alan İsmi" value="{{ $field['name'] }}"
                                                            name="extra[{{ $groupIndex }}][fields][{{ $fieldIndex }}][name]"
                                                            class="px-2 py-1 border rounded w-1/3"><button type="button"
                                                            class="bg-red-600 text-white px-2 py-1 rounded remove-field">X</button>
                                                    </div>
                                                @endforeach
                                            @endisset
                                        </div><button type="button"
                                            class="bg-green-600 text-white px-2 py-1 rounded-md text-sm add-field-btn">+
                                            Alan Ekle</button><button type="button"
                                            class="bg-red-600 text-white px-2 py-1 rounded-md text-sm ml-2 delete-group">Grubu
                                            Sil</button>
                                    </div>
                                @endisset
                            @endforeach
                        @endisset
                    </div>
                    <button type="button" id="add-extra-group"
                        class="mt-2 bg-blue-600 text-white px-3 py-1 rounded-md text-sm">
                        + Grup Ekle
                    </button>
                </div>




                <input type="hidden" name="id" id="id" value="{{ $data->id }}">

                <div class="flex justify-end">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md">Kaydet</button>
                </div>
            </form>


        </div>

    </div>



@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let $container = $("#extra-fields-container");
            let $addGroupBtn = $("#add-extra-group");
            let groupIndex = $(".extra_itemm").length; // Sayfadaki mevcut grup sayısına göre başla

            function addField(groupIndex, fieldIndex, label = '', name = '') {
                let $fieldGroup = $("<div>")
                    .addClass("mb-2 flex items-center gap-2 field_item")
                    .attr("data-group", groupIndex)
                    .attr("data-index", fieldIndex);

                let $labelInput = $("<input>").attr({
                    type: "text",
                    placeholder: "Alan Başlığı",
                    name: `extra[${groupIndex}][fields][${fieldIndex}][label]`
                }).val(label).addClass("px-2 py-1 border rounded w-1/3");

                let $nameInput = $("<input>").attr({
                    type: "text",
                    placeholder: "Alan İsmi",
                    name: `extra[${groupIndex}][fields][${fieldIndex}][name]`
                }).val(name).addClass("px-2 py-1 border rounded w-1/3");

           

                $fieldGroup.append($labelInput, $nameInput);
                return $fieldGroup;
            }

            function addGroup(title = '', fields = []) {
                let currentGroupIndex = groupIndex; // Grup indexini koru
                let $groupContainer = $("<div>")
                    .addClass("extra_itemm p-3 border rounded mb-3")
                    .attr("data-group", currentGroupIndex);

                let $titleInput = $("<input>").attr({
                    type: "text",
                    placeholder: "Grup Başlığı",
                    name: `extra[${currentGroupIndex}][field_title]`
                }).val(title).addClass("px-2 py-1 border rounded w-full mb-2");

                let $fieldsContainer = $("<div>").addClass("fields-container");

                let $addFieldBtn = $("<button>").attr("type", "button").text("+ Alan Ekle")
                    .addClass("bg-green-600 text-white px-2 py-1 rounded-md text-sm add-field-btn")
                    .on("click", function() {
                        let fieldIndex = $fieldsContainer.children().length;
                        $fieldsContainer.append(addField(currentGroupIndex, fieldIndex));
                    });

                let $removeGroupBtn = $("<button>").attr("type", "button").text("Grubu Sil")
                    .addClass("bg-red-600 text-white px-2 py-1 rounded-md text-sm ml-2")
                    .on("click", function() {
                        $groupContainer.remove();
                    });

                $groupContainer.append($titleInput, $fieldsContainer, $addFieldBtn, $removeGroupBtn);
                $container.append($groupContainer);

                // Önceki alanları yükle
                fields.forEach((field, index) => {
                    $fieldsContainer.append(addField(currentGroupIndex, index, field.label, field.name));
                });

                groupIndex++; // Yeni grup eklendiğinde indexi artır
            }

            $addGroupBtn.on("click", function() {
                addGroup();
            });

            $(document).on("click", ".add-field-btn", function() {
                let $fieldsContainer = $(this).siblings(".fields-container");
                let groupIndex = $(this).closest(".extra_itemm").attr("data-group");
                let fieldIndex = $fieldsContainer.children().length;
                $fieldsContainer.append(addField(groupIndex, fieldIndex));
            });

            $(document).on("click", ".delete-group", function() {
                $(this).closest(".extra_itemm").remove();
            });

            $(document).on("click", ".remove-field", function() {
                $(this).closest(".field_item").remove();
            });



        });
    </script>
@endpush
