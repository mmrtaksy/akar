@extends('layouts.default', ['data' => $category, 'image' => null])
@section('content')




    <!-- Start main-content -->
    <section class="page-title" style="background-image: url({{  asset('assets/images/background/page-title-bg.png')  }});">
        <div class="auto-container">
            <div class="title-outer text-center">
                <h1 class="title">{{ $category->title }}</h1>
                <ul class="page-breadcrumb">
                    <li><a href="@localizedRoute('homepage')">{{ Helper::translate('homepage') }}</a></li>
                    <li><a href="@localizedRoute('blogs')">Blog</a></li>
                    <li>{{ $category->title }}</li>
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

                <div class="relative text-center">
                        {!! Helper::turkishcharacters($category->description) !!}
                </div>


                @foreach ($data as $item)

                    <div class="news-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp">
                        <div class="inner-box wow fadeInLeft">
                            <div class="image-box">
                                <figure class="image overlay-anim">
                                    <a
                                        href="@localizedRoute('blogShow', ['category' => $item->parent->slug, 'slug' => $item->slug])">
                                        <img src="{{ $item->single_path ? asset('uploads/' . $item->single_path->path) : '' }}"
                                            alt="{{ $item->title  }}">
                                    </a>
                                </figure>
                                <span class="date">
                                    {{ strtoupper($item->created_at->translatedFormat('M')) }}<br />
                                    <small>{{ $item->created_at->translatedFormat('d') }}</small>
                                </span>
                            </div>
                            <div class="content-box">
                                <ul class="post-info">
                                    <li><i class="fa fa-user"></i>{{ $item->parent->title }}</li>
                                    <li><i class="fa fa-comments"></i> {{ $item->created_at->translatedFormat('M d, Y') }}</li>
                                </ul>
                                <h4 class="title"><a
                                        href="@localizedRoute('blogShow', ['category' => $item->parent->slug, 'slug' => $item->slug])">{{ Helper::turkishcharacters(strip_tags($item->title)) }}</a>
                                </h4>
                                <a href="@localizedRoute('blogShow', ['category' => $item->parent->slug, 'slug' => $item->slug])"
                                    class="read-more">{{ Helper::translate('more') }}<i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>

                @endforeach



                <div class="relative my-10 flex justify-center w-full">
                    {{ $data->links('vendor.pagination.bootstrap') }}
                </div><!--load-more-items end-->


            </div>
        </div>
    </section>
    <!-- End news section -->







@endsection