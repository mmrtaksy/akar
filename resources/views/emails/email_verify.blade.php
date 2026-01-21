<!DOCTYPE html>
<html>
<head>
    <title>Yeni Şifre Oluştur</title>
</head>
<body>
    <p>Merhaba,</p>
    <p>Emailinizi doğrulamak için aşağıdaki bağlantıya tıklayınız:</p>
    <a href="{{ $verificationLink }}">{{ $verificationLink }}</a>
    <p>Bu bağlantı 60 dakika geçerlidir.</p>
    <p>Teşekkürler!</p>
</body>
</html>
