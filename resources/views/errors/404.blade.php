 


@extends('layouts.default', ['title' => '', 'image' => ''])
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
                <h1 class="title">{{ Helper::translate('page_not_found')}}</h1>
                <ul class="page-breadcrumb">
                    <li><a href="@localizedRoute('homepage')">{{ Helper::translate('homepage') }}</a></li>
                    <li>{{ Helper::translate('page_not_found')}}</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- end main-content -->


	<!-- 404 Section -->
	<section class="">
		<div class="auto-container pt-120 pb-70">
			<div class="row">
				<div class="col-xl-12">
					<div class="error-page__inner">
						<div class="error-page__title-box">
							<h3 class="error-page__sub-title">{{ Helper::translate('page_not_found') }}</h3>
						</div>
						<p class="error-page__text">{{ Helper::translate('page_not_found_text') }}</p>
						<a href="@localizedRoute('homepage')" class="theme-btn btn-style-one shop-now"><span class="btn-title">{{ Helper::translate('back_to_home') }}</span></a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--End 404 Section -->

 
@endsection

