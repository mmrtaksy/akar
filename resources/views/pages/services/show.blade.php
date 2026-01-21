@extends('layouts.default', ['metaData' => $data, 'image' => asset('uploads/' . $data->single_path->path)])
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
            style="font-family:arial; padding: 0.5rem 1rem; background-color: #dc2626; color: white; position: fixed; right: 0; top: 0; z-index: 999999; text-decoration: none;"
            onmouseover="this.style.backgroundColor='#b91c1c'; this.style.color='white';"
            onmouseout="this.style.backgroundColor='#dc2626'; this.style.color='white';">
            Sayfayı Düzenle
        </a>
    @endauth




    <!-- Start main-content -->
    <section class="page-title" style="background-image: url({{  asset('assets/images/background/page-title-bg.png')  }});">
        <div class="auto-container">
            <div class="title-outer text-center">
                <h1 class="title">{{ $data->title}}</h1>
                <ul class="page-breadcrumb">
                    <li><a href="@localizedRoute('homepage')">{{ Helper::translate('homepage') }}</a></li>
                    <li>{{ Helper::translate('our_rooms')}}</li>
                    <li>{{ $data->title }}</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- end main-content -->

    <!--Room Details Start-->
    <section class="blog-details pt-120 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-7 product-details rd-page">
                    <div class="bxslider">

                        @foreach ($data->images as $slide)
                            <div class="slider-content">
                                <figure class="image-box"><a href="{{ asset('uploads/' . $slide->path) }}"
                                        class="lightbox-image" data-fancybox="gallery"><img
                                            src="{{ asset('uploads/' . $slide->path) }}" alt="{{ $data->title }}"></a></figure>
                                <div class="slider-pager">
                                    <ul class="thumb-box">
                                        @foreach ($data->images as $key => $item)
                                            <li class="mb-0"><a class="{{ $key == 0 ? 'active' : '' }}"
                                                    data-slide-index="{{ $key }}" href="#">
                                                    <figure><img src="{{ asset('uploads/' . $item->path) }}" alt=""></figure>
                                                </a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endforeach

                    </div>
                    <div class="room-details__left">
                        <div class="wrapper">

                            <div class="wrapper_content">
                                {!! Helper::turkishcharacters($data->description) !!}
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-xl-12">
                                    <div class="room-details__content-right mb-40 mt-20">
                                        <div class="room-details__details-box">
                                            <div class="row">
                                                @foreach (Helper::isArray($data->extra) as $item)
                                                    <div class="col-6 col-md-3">
                                                        <p class="text mb-0">{{ Helper::translate($item['name']) }}</p>
                                                        <h6>{{ $item['value'] }}</h6>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-sm-flex align-items-sm-center justify-content-sm-between pt-40 pb-40 border-top">
                            <h6 class="my-sm-0">{{ Helper::translate('share_room') }}</h6>
                            <div class="blog-details__social-list">
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}"
                                    target="_blank">
                                    <i class="fab fa-x-twitter"></i>
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                    target="_blank">
                                    <i class="fab fa-facebook"></i>
                                </a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}"
                                    target="_blank">
                                    <i class="fab fa-linkedin"></i>
                                </a>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="col-xl-4 col-lg-5">
                    <div class="sidebar">
                        <div class="sidebar__single sidebar__post">
                            <h3 class="sidebar__title">{{ Helper::translate('other_rooms')}}</h3>
                            <ul class="sidebar__post-list list-unstyled">
                                @foreach ($others as $item)

                                    <li>
                                        <a href="@localizedRoute('serviceShow', ['slug' => $item->slug])">
                                            <div class="sidebar__post-image"> <img
                                                    src="{{ asset('uploads/' . $item->single_path->path) }}" alt="">
                                            </div>
                                            <div class="sidebar__post-content">
                                                <h3> <span class="sidebar__post-content-meta"><i class="fas fa-door-open"></i>
                                                        {{ $item->title }}</span>
                                                    {{ Helper::getExtra($item->extra, 'price') }}
                                                </h3>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Room Details End-->


@endsection