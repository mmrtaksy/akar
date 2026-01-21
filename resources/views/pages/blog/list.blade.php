@extends('layouts.default', (array) $metaData)
@section('content')




    <!-- Start main-content -->
    <section class="page-title" style="background-image: url({{  asset('assets/images/background/page-title-bg.png')  }});">
        <div class="auto-container">
            <div class="title-outer text-center">
                <h1 class="title">{{ Helper::translate('blog') }}</h1>
                <ul class="page-breadcrumb">
                    <li><a href="@localizedRoute('homepage')">{{ Helper::translate('homepage') }}</a></li>
                    <li><a href="@localizedRoute('blogs')">Blog</a></li>
                </ul>
            </div>
        </div>
    </section>
    <!-- end main-content -->


 

    <!-- news-section -->
    <section class="news-section">
        <div class="auto-container">
            <div class="row">
                <!-- News Block -->


                @foreach ($pageData as $item)

                    <div class="news-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp">
                        <div class="inner-box wow fadeInLeft">
                            <div class="image-box">
                                <figure class="image overlay-anim {{ $item->children->count() > 1 ? 'grid' : '' }}"><a
                                        href="@localizedRoute('blogShow', ['category' => $item->slug])">
                                        @foreach($item->children->take(2) as $child)
                                            <img src="{{ asset('uploads/' . $child->single_path->path) }}"
                                                alt="{{ $item->title  }}">
                                        @endforeach
                                    </a></figure>
                                <span class="date">
                                    {{ strtoupper($item->children->last()->updated_at->translatedFormat('M')) }}<br />
                                    <small>{{ $item->children->last()->updated_at->translatedFormat('d') }}</small>
                                </span>
                            </div>
                            <div class="content-box">
                                <h4 class="title"><a
                                        href="@localizedRoute('blogShow', ['category' => $item->slug])">{{ Helper::turkishcharacters(strip_tags($item->title)) }}</a>
                                </h4>
                                <a href="@localizedRoute('blogShow', ['category' => $item->slug])"
                                    class="read-more">{{ Helper::translate('more') }}<i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>

                @endforeach



                <div class="relative my-10 flex justify-center w-full">
                    {{ $pageData->links('vendor.pagination.bootstrap') }}
                </div><!--load-more-items end-->


            </div>
        </div>
    </section>
    <!-- End news section -->






@endsection