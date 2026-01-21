@extends('xadmin.layouts.default')
@section('content')
    <div class="bg-white p-4 rounded-lg shadow-md w-full lg:max-w-6xl mx-auto">


        <div class="mb-3 relative flex items-center justify-between">
            <h3 class="text-lg font-semibold">Yeni Menü Ekle</h3>
        </div>



        <div class="container mx-auto">

            <form action="{{ route('panel_menus.store') }}" method="post">
                @csrf

                <div class="grid grid-cols-2 gap-6">
                    <div class="form-group mb-3">
                        <label for="title" class="block text-sm font-medium text-gray-900">Başlık*</label>
                        <input id="title" name="title" type="text" required
                            class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                    </div>

                    <div class="form-group mb-3 flex items-center">
                        <input id="statu" name="statu" type="checkbox" class="rounded border-gray-300">
                        <label for="statu" class="ml-2 text-sm font-medium text-gray-900">Aktif</label>
                    </div>

                    <div class="form-group mb-3 flex items-center">
                        <input id="meta" name="meta" type="checkbox" class="rounded border-gray-300">
                        <label for="meta" class="ml-2 text-sm font-medium text-gray-900">Meta Bilgisi</label>
                    </div>

                    <div class="form-group mb-3 flex items-center">
                        <input id="editor" name="editor" type="checkbox" class="rounded border-gray-300">
                        <label for="editor" class="ml-2 text-sm font-medium text-gray-900">Editor Kullanımı</label>
                    </div>

                    <div class="form-group mb-3 flex items-center">
                        <input id="multiple_image" name="multiple_image" type="checkbox" class="rounded border-gray-300">
                        <label for="multiple_image" class="ml-2 text-sm font-medium text-gray-900">Çoklu Resim</label>
                    </div>

                    <div class="form-group mb-3 flex items-center">
                        <input id="image" name="image" type="checkbox" class="rounded border-gray-300">
                        <label for="image" class="ml-2 text-sm font-medium text-gray-900">Resim</label>
                    </div>

                    <div class="form-group mb-3 flex items-center">
                        <input id="categories" name="categories" type="checkbox" class="rounded border-gray-300">
                        <label for="categories" class="ml-2 text-sm font-medium text-gray-900">Kategoriler</label>
                    </div>
                </div>

                <!-- Dinamik Ekstra Alanlar -->
                <div class="form-group mb-3">
                    <label class="block text-sm font-medium text-gray-900">Ekstra Alanlar</label>
                    <div id="extra-fields-container">
                        <!-- JavaScript ile buraya alanlar eklenecek -->
                    </div>
                    <button type="button" id="add-extra-group"
                        class="mt-2 bg-blue-600 text-white px-3 py-1 rounded-md text-sm">
                        + Grup Ekle
                    </button>
                </div>




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
            let extraData = [];
 

            function addField(groupIndex, fieldIndex, label = '', name = '') {
                let $fieldGroup = $("<div>").addClass("mb-2 flex items-center gap-2").attr("data-group", groupIndex)
                    .attr("data-index", fieldIndex);

                let $labelInput = $("<input>").attr({
                        type: "text",
                        placeholder: "Alan Başlığı",
                        name: `extra[${groupIndex}][fields][${fieldIndex}][label]`
                    })
                    .val(label)
                    .addClass("px-2 py-1 border rounded w-1/3")
                    .on("input", function() {
                        extraData[groupIndex].fields[fieldIndex].label = $(this).val();
                    });

                let $nameInput = $("<input>").attr({
                        type: "text",
                        placeholder: "Alan İsmi",
                        name: `extra[${groupIndex}][fields][${fieldIndex}][name]`
                    })
                    .val(name)
                    .addClass("px-2 py-1 border rounded w-1/3")
                    .on("input", function() {
                        extraData[groupIndex].fields[fieldIndex].name = $(this).val();
                    });

                let $removeBtn = $("<button>").attr("type", "button").text("X").addClass(
                        "bg-red-600 text-white px-2 py-1 rounded remove-field")
                    .on("click", function() {
                        $fieldGroup.remove();
                        extraData[groupIndex].fields.splice(fieldIndex, 1);
                    });

                $fieldGroup.append($labelInput, $nameInput, $removeBtn);
                return $fieldGroup;
            }

            function addGroup(title = '', fields = []) {
                let groupIndex = extraData.length;
                let $groupContainer = $("<div>").addClass("p-3 border rounded mb-3").attr("data-group", groupIndex);

                let $titleInput = $("<input>").attr({
                        type: "text",
                        placeholder: "Grup Başlığı",
                        name: `extra[${groupIndex}][field_title]`
                    })
                    .val(title)
                    .addClass("px-2 py-1 border rounded w-full mb-2")
                    .on("input", function() {
                        extraData[groupIndex].field_title = $(this).val();
                    });

                let $fieldsContainer = $("<div>").addClass("fields-container");

                let $addFieldBtn = $("<button>").attr("type", "button").text("+ Alan Ekle")
                    .addClass("bg-green-600 text-white px-2 py-1 rounded-md text-sm")
                    .on("click", function() {
                        let fieldIndex = extraData[groupIndex].fields.length;
                        extraData[groupIndex].fields.push({
                            label: '',
                            name: ''
                        });
                        $fieldsContainer.append(addField(groupIndex, fieldIndex));
                    });

                let $removeGroupBtn = $("<button>").attr("type", "button").text("Grubu Sil")
                    .addClass("bg-red-600 text-white px-2 py-1 rounded-md text-sm ml-2")
                    .on("click", function() {
                        $groupContainer.remove();
                        extraData.splice(groupIndex, 1);
                    });

                $groupContainer.append($titleInput, $fieldsContainer, $addFieldBtn, $removeGroupBtn);
                $container.append($groupContainer);

                extraData.push({
                    field_title: title,
                    fields: []
                });

                fields.forEach((field, index) => {
                    extraData[groupIndex].fields.push(field);
                    $fieldsContainer.append(addField(groupIndex, index, field.label, field.name));
                });

            }

            // Sayfa yüklenirken JSON verisini yükle
            extraData.forEach(group => {
                addGroup(group.field_title, group.fields);
            });

            $addGroupBtn.on("click", function() {
                addGroup();
            });
        });
    </script>
@endpush
