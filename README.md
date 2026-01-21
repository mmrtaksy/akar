# 🌐 Akar Digital - Web Template

Modern, responsive ve çok dilli HTML/CSS/JavaScript web template'i.

## 📁 Proje Yapısı

```
akardigital/
├── index.html              # Ana sayfa
├── services.html           # Hizmetler sayfası
├── works.html             # Projeler sayfası
├── contact.html           # İletişim sayfası
├── css/
│   ├── main.css           # Ana stil dosyası (Google Fonts: Playfair Display + Inter)
│   ├── animations.css     # Animasyon tanımları
│   └── responsive.css     # Responsive kurallar
├── js/
│   ├── main.js            # Ana JavaScript (dark mode default)
│   └── translations.js    # Çeviri sistemi (TR/EN)
├── assets/
│   └── images/            # Görseller
├── react-native-backup/   # 🔒 React Native projesinin yedeği
└── README.md              # Bu dosya
```

## ✨ Özellikler

### 🎨 Tasarım
- ✅ **Dark Mode Varsayılan** - Sayfa dark mode ile açılır
- ✅ **Modern Tipografi** - Playfair Display (başlıklar) + Inter (metin)
- ✅ **Glassmorphism** ve gradient efektler
- ✅ **Cinematic Logo Animasyonu**
- ✅ **Sticky WhatsApp Butonu** (pulse animasyonlu)

### 📱 Responsive Design
- ✅ Mobile-first yaklaşım
- ✅ Tablet ve desktop uyumlu
- ✅ Hamburger menü (mobil)

### 🌍 Dil Desteği
- ✅ Türkçe (TR) - Varsayılan
- ✅ İngilizce (EN)
- ✅ LocalStorage ile dil tercihi

### 🚀 Özellikler
- ✅ Smooth scroll animasyonlar
- ✅ Form validasyonu
- ✅ Intersection Observer API
- ✅ Sosyal medya entegrasyonu (Instagram, WhatsApp)

## 🎯 İçerik

### Ana Sayfa (index.html)
- **Hero Bölümü:** "Dijitalde Sadece Görünür Değil, Rakiplerinizden Bir Adım Önde Olun"
- **Hizmetler:** 6 hizmet kartı (Meta Ads, Prodüksiyon, Web, Eğitim, Sosyal Medya, E-Ticaret)
- **Neden Biz:** ⚡ Yüksek Performans, 🛡️ Güvenlik, 🎯 Kullanıcı Odaklı
- **Ekibimiz:** Yaratıcı ekip tanıtımı
- **CTA:** "👉 Teklif Al" butonu (scroll to contact)

### Hizmetler (services.html)
6 detaylı hizmet kartı

### Projeler (works.html)
Portfolyo galerisi

### İletişim (contact.html)
İletişim formu ve bilgileri

## 🚀 Kullanım

### Basit Başlatma
```bash
# index.html'i tarayıcınızda açın
open index.html
```

### Local Server (Önerilen)
```bash
# Python 3
python3 -m http.server 8000

# veya Node.js
npx serve

# Tarayıcıda: http://localhost:8000
```

## 🎨 Özelleştirme

### Renkleri Değiştirme
```css
/* css/main.css */
:root {
    --color-primary: #2563eb;
    --font-heading: 'Playfair Display', serif;
    --font-body: 'Inter', sans-serif;
}
```

### Çevirileri Düzenleme
```javascript
// js/translations.js
const translations = {
    tr: { /* Türkçe çeviriler */ },
    en: { /* İngilizce çeviriler */ }
};
```

### WhatsApp Numarası
```html
<!-- index.html ve footer -->
<a href="https://wa.me/905441527074" class="whatsapp-sticky">
```

## 📦 React Native Yedek

Orijinal React Native/Expo projesi `react-native-backup/` klasöründe saklanmıştır.

**Geri yüklemek için:**
```bash
# Mevcut web dosyalarını yedekle
mkdir web-backup
mv *.html css js assets web-backup/

# React Native projesini geri yükle
mv react-native-backup/* .
mv react-native-backup/.* .
rmdir react-native-backup
```

## 🌐 Tarayıcı Desteği
- Chrome, Firefox, Safari, Edge (modern versiyonlar)
- Mobile browsers (iOS Safari, Chrome Mobile)

## 📝 Copyright
© 2021 Akar Digital. Tüm hakları saklıdır.

---

**Proje Durumu:** ✅ Production Ready (Web Only)  
**Versiyon:** 2.0.0 (Web Only)  
**Son Güncelleme:** 17 Ocak 2026
