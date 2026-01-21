@extends('xadmin.layouts.default') @section('content')

<div class="container mt-5">
    <div class="row justify-content-end mb-3">
    <div class="alert alert-primary d-none" role="alert" id="resultDiv">
        Bilgiler Başarıyla Kaydedildi
    </div>

        <div class="col col-12 col-md-4 text-center text-md-right ml-auto">
            <button class="btn btn-primary" id="saveTree">Kaydet</button>
        </div>
    </div>
    <div class="row">
        <div class="col col-12 col-md-6">
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button
                            class="accordion-button collapsed"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseOne"
                            aria-expanded="false"
                            aria-controls="flush-collapseOne"
                        >
                            Kategoriler
                        </button>
                    </h2>
                    <div
                        id="flush-collapseOne"
                        class="accordion-collapse collapse show"
                        aria-labelledby="flush-headingOne"
                        data-bs-parent="#accordionFlushExample"
                    >
                        <div class="accordion-body">
                            <ul class="list-group">
                                @foreach($cats as $item)
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-start"
                                >
                                    <div>{{ $item->title }}</div>
                                    <button
                                        class="btn btn-primary btn-sm addMenu"
                                        id="{{ $item->id }}"
                                        data-title="{{ $item->title }}"
                                        data-slug="{{ $item->slug }}"
                                        data-url="category"
                                    >
                                        <i data-feather="plus"></i>
                                    </button>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingTwo">
                        <button
                            class="accordion-button collapsed"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseTwo"
                            aria-expanded="false"
                            aria-controls="flush-collapseTwo"
                        >
                            Hizmetler
                        </button>
                    </h2>
                    <div
                        id="flush-collapseTwo"
                        class="accordion-collapse collapse"
                        aria-labelledby="flush-headingTwo"
                        data-bs-parent="#accordionFlushExample"
                    >
                        <div class="accordion-body">
                            <ul class="list-group">
                                @foreach($services as $item)
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-start"
                                >
                                    <div>{{ $item->title }}</div>
                                    <button
                                        class="btn btn-primary btn-sm addMenu"
                                        id="{{ $item->id }}"
                                        data-title="{{ $item->title }}"
                                        data-slug="{{ $item->slug }}"
                                        data-url="services"
                                    >
                                        <i data-feather="plus"></i>
                                    </button>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col col-12 col-md-6">
            <div class="wrapper mt-0">
                <div id="dataNested" class="w-100"></div>
            </div>
        </div>

        @if($data)
        <input type="hidden" id="treeID" value="{{ $data->id }}" />
        <textarea class="d-none" id="treeData">{{ $data->content }}</textarea>
        @endif
    </div>
</div>

@endsection
