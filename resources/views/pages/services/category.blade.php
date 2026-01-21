@extends('layouts.default', ['data' => $data, 'image' => asset('uploads/' . $data->single_path->path)])

@section('content')
    @push('styles')
        <style>
            .wrapper_content * {
                margin: revert;
                font-family: revert;
                font-size: revert;
                list-style: revert;
                padding: revert;
                word-break: initial;
                word-spacing: normal;
                word-wrap: break-word;
            }
        </style>
    @endpush




    @php
        $langId = \App\Models\Languages::where('native', app()->getLocale())->value('id');
    @endphp

    @auth
        <a href="{{ route('servicesUpdateGet', ['id' => $data->id, 'lang' => $langId, 'model_id' => $data->model_id]) }}"
            class="adminbutton">Sayfayı Düzenle</a>
    @endauth


    <!-- Page Banner Area -->
    <div class="page-banner bg-1">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="container">
                    <div class="page-content">
                        <h2>{{ $data->title }}</h2>
                        <ul>
                            <li>
                                <a href="@localizedRoute('homepage')">{{ Helper::translate('homepage') }}</a>
                            </li>
                            <li><a href="@localizedRoute('services')">{{ Helper::translate('services') }}</a></li>
                            <li>{{ $data->title }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Banner Area -->

    <!-- Single Service Area -->
    <section class="single-services-area ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <article class="service-details-text">
                        @isset($data->single_path)
                            <div class="service-image">
                                <img src="{{ asset('uploads/' . $data->single_path->path) }}" alt="{{ $data->title }}">
                            </div>
                        @endisset

                        <div class="relative wrapper_content">
                            <p>{!! Helper::turkishcharacters($data->description) !!}</p>
                        </div>
                    </article>
                </div>


                @if ($others->count())


                    <div class="col-lg-12">

                        <div class="blog-area-two ptb-100">
                            <div class="container">
                                <div class="row">

                                    @foreach ($others as $item)
                                        <div class="col-lg-4 col-md-6">
                                            <div class="blog-card">

                                                <a class="blog-image"
                                                    href="@localizedRoute('serviceShow', ['category' => $data->slug, 'slug' => $item->slug])">
                                                    @if ($item->single_path)
                                                        <img src="{{ asset('uploads/' . $item->single_path->path) }}"
                                                            alt="{{ $item->title }}">
                                                    @else
                                                        <img src="https://placehold.co/360x360/EEE/31343C">
                                                    @endif
                                                </a>

                                                <div class="blog-text">
                                                    <span class="meta-tag">{{ $data->title }}</span>
                                                    <div class="date">{{ $item->created_at->translatedFormat('M d, Y') }}</div>
                                                    <h3>
                                                        <a
                                                            href="@localizedRoute('serviceShow', ['category' => $data->slug, 'slug' => $item->slug])">
                                                            {{ $item->title }}
                                                        </a>
                                                    </h3>
                                                    <p class="mb-20">
                                                        {{ Str::of(Helper::turkishcharacters(strip_tags($item->description)))->limit(100) }}
                                                    </p>

                                                    <a href="@localizedRoute('serviceShow', ['category' => $data->slug, 'slug' => $item->slug])"
                                                        class="default-btn-two">
                                                        {{ Helper::translate('more') }}
                                                    </a>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach



                                    <div class="relative my-10 flex justify-center w-full">
                                        {{ $others->links('vendor.pagination.bootstrap') }}
                                    </div>




                                </div>
                            </div>
                        </div>
                    </div>

                @endif
            </div>
        </div>
    </section>
    <!-- End Single Service Area -->
@endsection