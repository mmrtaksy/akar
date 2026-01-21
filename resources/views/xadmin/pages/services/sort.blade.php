@extends('xadmin.layouts.default')
@section('content')
    @php
        $panelMenu = Helper::panelMenu($modelId);
        $tdClass = 'px-2 border border-gray-300';
    @endphp

    <div class="bg-white p-4 rounded-lg shadow-md w-full lg:max-w-6xl mx-auto">


        <div class="mb-3 relative flex items-center justify-between">
            <h3 class="text-lg font-semibold">{{ $panelMenu['title'] }} - Sıralama</h3>
            
            <div class="mb-4 flex items-center gap-4">
                <button type="button" id="sortAlphabetical"
                class="text-md text-blue-600 font-medium inline-block">
                    Alfabetik Sırala
                </button>

                <button type="button" id="sortNumeric"
                class="text-md text-blue-600 font-medium inline-block">
                    Numerik Sırala
                </button>
                
                <a class="text-md text-blue-600 font-medium inline-block"
                            href="{{ route('servicesList', ['model_id' => $modelId, 'lang' => $listlang]) }}">Listeyi gör</a>
            </div>

        </div>

        <div style="position:fixed; right:0; bottom:0;margin:1em; z-index: 2;">
            <div class="bg-green-600 text-white px-3 py-1 rounded-sm text-sm my-3" id="successAlert" style="display:none;">
                Sıralama Güncellendi!
            </div>
        </div>


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



        <div class="mb-3 relative flex items-center gap-3">
            @foreach (Helper::langs() as $lang)
                <a href="{{ route('servicesSortGet', ['lang' => $lang->id, 'model_id' => $modelId]) }}"
                    class="{{ $lang->id == $listlang ? 'bg-green-600' : 'bg-gray-500' }} text-white px-4 rounded-full sm:py-1 hover:bg-green-600 focus:outline-none focus:bg-green-700 inline-block">
                    {{ strtoupper($lang->native) }}
                </a>
            @endforeach
        </div>


        <div class="dd" id="nestable">
            <ol class="dd-list">
                @foreach ($data as $item)
                    @include('xadmin.pages.services.partials.nestable-item', [
                        'item' => $item,
                        'modelId' => $modelId,
                    ])
                @endforeach
            </ol>
        </div>



    </div>


@endsection

@push('scripts')
    <script>
        $(function() {


            const sortRoute = "{{ route('serviceSetSort') }}";
            
            const depth =  {{ $panelMenu['categories'] ? 3 : 1 }};

            $('#nestable').nestable({
                maxDepth: depth
            }).on('change', function() {
                let order = $(this).nestable('serialize');
                updateSortOrder(order);
            });



            $('#sortAlphabetical').click(function () {
                let items = $('#nestable > .dd-list > .dd-item').get();
                items.sort(function (a, b) {
                    let aText = $(a).find('.item-title').first().text().toLowerCase();
                    let bText = $(b).find('.item-title').first().text().toLowerCase();
                    return aText.localeCompare(bText);
                });
                $('#nestable > .dd-list').empty().append(items);
                updateSortOrder($('#nestable').nestable('serialize'));
            });

            // Numerik sıralama (ID'ye göre)
            $('#sortNumeric').click(function () {
                let items = $('#nestable > .dd-list > .dd-item').get();
                items.sort(function (a, b) {
                    let aId = parseInt($(a).data('id'));
                    let bId = parseInt($(b).data('id'));
                    return aId - bId;
                });
                $('#nestable > .dd-list').empty().append(items);
                updateSortOrder($('#nestable').nestable('serialize'));
            });
            

            function updateSortOrder(order) {
                $.ajax({
                    url: sortRoute,
                    method: 'POST',
                    data: {
                        order: order
                    },
                    success: function(response) {
                        $('#successAlert').fadeIn();
                        setTimeout(function() {
                            $('#successAlert').fadeOut();
                        }, 3000);
                    },
                    error: function() {
                        alert('Sıralama güncellenirken bir hata oluştu.');
                    }
                });
            }




        })
    </script>
@endpush
