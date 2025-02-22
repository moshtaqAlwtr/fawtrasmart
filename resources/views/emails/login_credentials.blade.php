<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل تسجيل الدخول</title>
</head>
<body>
    <h2>مرحبًا {{ $details['name'] }}</h2>
    <p>تم إنشاء حساب لك بنجاح. إليك تفاصيل تسجيل الدخول:</p>
    <p><strong>البريد الإلكتروني:</strong> {{ $details['email'] }}</p>
    <p><strong>كلمة المرور:</strong> {{ $details['password'] }}</p>
    <p>يرجى تغيير كلمة المرور بعد تسجيل الدخول لأول مرة.</p>
    <br>
    <p>شكرًا لك،</p>
    <p>فريق الدعم</p>
</body>
</html>
