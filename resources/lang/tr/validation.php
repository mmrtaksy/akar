<?php

return [
    'name' => [
        'required' => 'Ad alanı zorunludur.',
        'max' => 'Ad maksimum 255 karakter olmalı.',
    ],
    'surname' => [
        'required' => 'Soyad alanı zorunludur.',
        'max' => 'Soyad maksimum 255 karakter olmalı.',
    ],
    'phone' => [
        'required' => 'Telefon alanı zorunludur.',
        'unique' => 'Bu telefon numarası zaten kayıtlı.',
        'max' => 'Telefon numarası maksimum 255 karakter olmalı.',
    ],
    'country_id' => [
        'required' => 'Ülke zorunludur.',
    ],
    'email' => [
        'required' => 'Email alanı zorunludur.',
        'email' => 'Geçerli bir email adresi olmalı.',
        'max' => 'Email adresi maksimum 255 karakter olmalı.',
        'unique' => 'Bu email adresi zaten kayıtlı.',
        'email' => 'Geçerli bir email adresi olmalı.',
    ],
    'captcha' => [
        'required' => 'Captcha doğrulaması zorunludur.',
    ],
    'subject' => [
        'required' => 'Konu zorunludur.',
    ],
    'token' => [
        'required' => 'Token zorunludur.',
    ],
    'agree' => [
        'required' => 'Kullanım şartlarını kabul etmelisiniz.',
    ],
    'company_name' => [
        'required' => 'Firma/Kuruluş Adı zorunludur.',
    ],
    'company_about' => [
        'required' => 'Firma Açıklaması zorunludur.',
        'max' => 'Firma Açıklaması maksimum 1000 karakter olmalı.',
    ],
    'password' => [
        'min' => 'Şifre minimum 6 karakter olmalı.',
        'required' => 'Şifre alanı zorunludur.',
        'confirmed' => 'Şifre tekrarı zorunludur.',
    ],
    'new_password' => [
        'min' => 'Yeni şifre tekrarı minimum 6 karakter olmalı.',
        'required' => 'Yeni şifre tekrarı alanı zorunludur.',
        'confirmed' => 'Yeni şifre tekrarı zorunludur.',
    ],
    'title' => [
        'required' => 'Şirket adı zorunludur.',
        'unique' => 'Bu şirket adı zaten kullanılıyor.',
    ],
    'avatar' => [
        'image' => 'Avatar bir resim dosyası olmalıdır.',
        'mimes' => 'Avatar sadece jpeg, png, jpg, webp formatlarında olabilir.',
        'max' => 'Avatar dosyası maksimum 5048 KB olmalıdır.',
    ],
    'fax' => [
        'max' => 'Faks numarası maksimum 255 karakter olmalı.',
    ],
    'website' => [
        'url' => 'Geçerli bir web sitesi adresi girin.',
        'max' => 'Web sitesi adresi maksimum 255 karakter olmalı.',
    ],
    'links' => [
        '*.type.required' => 'Sosyal medya tipi zorunludur.',
        '*.link.required' => 'Sosyal medya linki zorunludur.',
        '*.link.url' => 'Geçerli bir URL girin.',
    ],
    'language' => [
        'max' => 'Dil maksimum 255 karakter olmalı.',
    ],
    'end_at' => [
        'date' => 'Geçerli bir bitiş tarihi girin.',
        'after_or_equal' => 'Bitiş tarihi başlangıç tarihinden önce olamaz.',
    ],
    'reference_code' => [
        'max' => 'Referans kodu maksimum 255 karakter olmalı.',
    ],
    'job_type_id' => [
        'exists' => 'Geçerli bir iş türü ID girin.',
    ],
    'job_sector_id' => [
        'exists' => 'Geçerli bir iş sektörü ID girin.',
    ],
    'job_position_id' => [
        'exists' => 'Geçerli bir iş pozisyonu ID girin.',
    ],
    'job_position_level' => [
        'exists' => 'Geçerli bir iş pozisyon seviyesi ID girin.',
    ],
    'job_experience_level' => [
        'exists' => 'Geçerli bir iş deneyim seviyesi ID girin.',
    ],
    'user_phone' => [
        'max' => 'Telefon numarası maksimum 255 karakter olmalı.',
    ],
    'approve_statu' => [
        'boolean' => 'Onay durumu doğru bir değer olmalı.',
    ],
    'approve_type' => [
        'max' => 'Onay türü maksimum 255 karakter olmalı.',
    ],
    'approve_link' => [
        'max' => 'Onay linki maksimum 255 karakter olmalı.',
    ],
    'approve_email' => [
        'email' => 'Geçerli bir e-posta adresi girin.',
        'max' => 'E-posta adresi maksimum 255 karakter olmalı.',
    ],
    'message' => [
        'required' => 'Mesaj alanı zorunludur.',
        'max' => 'Maksimum 1000 karakter olmalıdır.',
    ],
];