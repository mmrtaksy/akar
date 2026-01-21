@section('content')
@extends('layouts.default', ['data' => $data, 'image' => ''])
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
@section('content')




    <!-- Start main-content -->
    <section class="page-title" style="background-image: url({{  asset('assets/images/background/page-title-bg.png')  }});">
        <div class="auto-container">
            <div class="title-outer text-center">
                <h1 class="title">{{ $data->title }}</h1>
                <ul class="page-breadcrumb">
                    <li><a href="@localizedRoute('homepage')">{{ Helper::translate('homepage') }}</a></li>
                    <li>{{ $data->title }}</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- end main-content -->


    <!--Start Services Details-->
    <section class="services-details pt-120 pb-120">
        <div class="container">
            <div class="row">
                <!--Start Services Details Sidebar-->

                <!--Start Services Details Content-->
                <div class="col-xl-8 col-lg-8 mx-auto">
                    <div class="services-details__content">

                        {!! Helper::turkishcharacters($data->description) !!}

                    </div>

                </div>
            </div>
            <!--End Services Details Content-->
        </div>
        </div>
    </section>
    <!--End Services Details-->





@endsection