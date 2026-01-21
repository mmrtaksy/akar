@extends('layouts.default', ['metaData' => $data, 'image' => asset('uploads/' . $data->single_path->path)])
@section('content')
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
            .wrapper_content a,
            .wrapper_content a strong {
                font-weight: bold;
                font-family: monospace;
                color: #2e2eff;
            }
        </style>





    <!-- Start main-content -->
    <section class="page-title" style="background-image: url({{  asset('assets/images/background/page-title-bg.png')  }});">
        <div class="auto-container">
            <div class="title-outer text-center">
                <h1 class="title">{{ $data->title }}</h1>
                <ul class="page-breadcrumb">
                    <li><a href="@localizedRoute('homepage')">{{ Helper::translate('homepage') }}</a></li>
                    <li><a href="@localizedRoute('blogs')">Blog</a></li>
                    <li><a
                            href="@localizedRoute('blogShow', ['category' => $data->parent->slug])">{{ $data->parent->title }}</a>
                    </li>
                    <li>{{ $data->title }}</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- end main-content -->




    <!--Blog Details Start-->
    <section class="blog-details pt-120 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-7">
                    <div class="blog-details__left">
                        <div class="blog-details__img">
                            @isset($data->single_path)
                                <img src="{{ asset('uploads/' . $data->single_path->path) }}" alt="{{ $data->title }}">
                            @endisset
                        </div>
                        <div class="blog-details__content">
                            <ul class="list-unstyled blog-details__meta">
                                <li><a href="@localizedRoute('blogShow', ['category' => $data->parent->slug])"><i
                                            class="fas fa-user-circle"></i> {{ $data->parent->title }}</a> </li>
                                <li><i class="fas fa-user-circle"></i> {{ $data->created_at->translatedFormat('M d, Y') }}
                                </li>
                            </ul>
                            <h2 class="blog-details__title">{{ $data->title }}</h2>
                            <div class="wrapper_content">
                                {!! Helper::turkishcharacters($data->description) !!}
                            </div>


                        </div>
                        <div class="blog-details__bottom">
                            <p class="blog-details__tags"> <span>{{ Helper::translate('share_content') }}</span> </p>
                            <div class="blog-details__social-list">
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($data->title) }}"
                                    target="_blank"><i class="fab fa-x-twitter"></i></a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                    target="_blank"><i class="fab fa-facebook"></i></a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}"
                                    target="_blank"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div> 
                        <div class="nav-links">

                            @if ($prevData)
                                <div class="prev">
                                    <a href="@localizedRoute('blogShow', ['category' => $prevData->parent->slug, 'slug' => $prevData->slug])"
                                        rel="prev">{{ $prevData->title }}</a>
                                </div>
                            @endif
                            @if ($nextData)
                                <div class="next">
                                    <a href="@localizedRoute('blogShow', ['category' => $nextData->parent->slug, 'slug' => $nextData->slug])"
                                        rel="next">{{ $nextData->title }}</a>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
                <div class="col-xl-4 col-lg-5">
                    <div class="sidebar">

                        <div class="sidebar__single sidebar__post">
                            <h3 class="sidebar__title">{{ Helper::translate('other_blog') }}</h3>
                            <ul class="sidebar__post-list list-unstyled">


                                @foreach ($others as $item)

                                    <li>
                                    <a href="@localizedRoute('blogShow', ['category' => $item->parent->slug, 'slug' => $item->slug])">
                                        <div class="sidebar__post-image"> <img
                                                src="{{ $item->single_path ? asset('uploads/' . $item->single_path->path) : '' }}"
                                                alt="{{ $item->title }}"> </div>
                                        <div class="sidebar__post-content">
                                            <h3> <span class="sidebar__post-content-meta">
                                                <i
                                                        class="fas fa-user-circle"></i>{{ $item->parent->title }}</span>
                                                        <p>{{ $item->title }}</p>
                                            </h3>
                                        </div>
                                        </a>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                        <div class="sidebar__single sidebar__category">
                            <h3 class="sidebar__title">{{ Helper::translate('categories') }}</h3>
                            <ul class="sidebar__category-list list-unstyled">


                                @foreach ($cats as $item)
                                    <li><a href="@localizedRoute('blogShow', ['category' => $item->slug])">{{ $item->title }}<span
                                                class="icon-right-arrow"></span></a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Blog Details End-->




 
@endsection