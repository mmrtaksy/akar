@extends('layouts.default', (array) $metaData)

@section('content')






    <!-- Page Header -->
    <section class="hero" style="padding: 6rem 0;">
        <div class="container text-center">

            <h1 class="hero-title" data-i18n="contact_page.title">Bir Kahve İçelim?</h1>
            <p class="hero-description" style="max-width: 700px; margin: 0 auto;" data-i18n="contact_page.description">
                Yeni bir proje fikriniz mi var? Veya sadece tanışmak mı istiyorsunuz? Bize her zaman ulaşabilirsiniz.
            </p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="section">
        <div class="container">
            <div class="grid grid-cols-2" style="gap: 3rem; align-items: start;">
                <!-- Contact Info -->
                <div>
                    <h2 style="font-size: var(--font-size-3xl); font-weight: 700; margin-bottom: 2rem;"
                        data-i18n="contact_page.form_title">Bize Yazın</h2>

                    <div class="card" style="margin-bottom: 1.5rem;">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div
                                style="width: 48px; height: 48px; background: rgba(37, 99, 235, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <svg width="24" height="24" fill="#2563eb" viewBox="0 0 20 20">
                                    <path
                                        d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                            </div>
                            <div>
                                <div style="font-size: var(--font-size-sm); color: var(--text-secondary); margin-bottom: 0.25rem;"
                                    data-i18n="contact_page.info_phone">Telefon</div>
                                <div style="font-weight: 700; color: var(--text-primary);"
                                    data-i18n="contact_page.phone_value">+90 (544) 152 70 74</div>
                            </div>
                        </div>
                    </div>

                    <div class="card" style="margin-bottom: 1.5rem;">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div
                                style="width: 48px; height: 48px; background: rgba(37, 99, 235, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <svg width="24" height="24" fill="#2563eb" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                            </div>
                            <div>
                                <div style="font-size: var(--font-size-sm); color: var(--text-secondary); margin-bottom: 0.25rem;"
                                    data-i18n="contact_page.info_email">E-Posta</div>
                                <div style="font-weight: 700; color: var(--text-primary);"
                                    data-i18n="contact_page.email_value">info@akardijital.com</div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div
                                style="width: 48px; height: 48px; background: rgba(37, 99, 235, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <svg width="24" height="24" fill="#2563eb" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <div style="font-size: var(--font-size-sm); color: var(--text-secondary); margin-bottom: 0.25rem;"
                                    data-i18n="contact_page.info_address">Ofis</div>
                                <div style="font-weight: 700; color: var(--text-primary);"
                                    data-i18n="contact_page.address_value">İstanbul, Türkiye</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="card">
                    <form id="contactForm" method="post" action="@localizedRoute('formcontact')">
                        @csrf

                        

                    @if (Session::has('success'))
                        <p class="success alert alert-success" id="success">{{ Session::get('success') }}</p>
                    @endif

                    @if (Session::has('error'))
                        <p class="error alert alert-danger" id="error">{{ Session::get('error') }}</p>
                    @endif


                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <p class="error alert alert-danger" id="error">{{ $error }}</p>
                        @endforeach
                    @endif



                        <div class="form-group">
                            <label class="form-label" for="title" data-i18n="contact_page.form_name">Adınız</label>
                            <input type="text" id="title" name="title" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="subject" data-i18n="contact_page.form_company">Konu</label>
                            <input type="text" id="subject" name="subject" class="form-input">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="email" data-i18n="contact_page.form_email">E-Posta
                                Adresiniz</label>
                            <input type="email" id="email" name="email" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="message"
                                data-i18n="contact_page.form_message">Mesajınız</label>
                            <textarea id="message" name="message" class="form-textarea" required></textarea>
                        </div>

                        
                        <div class="form-group">
                            <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}"></div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-large" style="width: 100%;">
                            <span data-i18n="contact_page.form_submit">Mesajı Gönder</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

 


@endsection


@push('scripts')
    @once
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endonce
@endpush