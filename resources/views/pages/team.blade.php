@extends('layouts.default', (array) $metaData)

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


  <!-- #region 
    <!-- Page Header -->
    <section class="hero" style="padding: 6rem 0;">
        <div class="container text-center">

            <h1 class="hero-title" style="margin-bottom: 1rem;">
                <span data-i18n="team_page.title">Profesyonel Kadromuz</span>
            </h1>
            <p class="hero-description" style="max-width: 700px; margin: 0 auto;" data-i18n="team_page.description">
                Dijital dünyada fark yaratmak için tutkuyla çalışan profesyonel ekibimizle tanışın.
            </p>
        </div>
    </section>

    <!-- Why Us Section (Moved from Home) -->
    <section class="section" id="team">
        <div class="container">

            <div class="grid grid-cols-3">
                <!-- Team Card 1 -->

                   @foreach ($data as $item)
 

                        <div class="card scroll-animate team text-center">
                            <img src="{{ asset('uploads/' . $item->single_path->path) }}" alt="{{ $item->title }}">
                            <h3 class="card-title">{{ $item->title }}</h3>
                            <p class="card-description">{{ $item->description }}</p>
                        </div>

                        
                @endforeach


            
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    
    @include('includes.cta')
 



@endsection