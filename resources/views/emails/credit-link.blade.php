<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <h3>عميلنا العزيز،</h3>

    <p>نرسل لك إشعارًا دائنًا برقم: <strong>#{{ $credit->id }}</strong></p>

    <p>
        يمكنك عرض الإشعار الدائن عبر الرابط التالي:
    </p>

    <p>
        <a href="{{ $url }}" target="_blank" style="background-color: #38a169; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
            عرض الإشعار
        </a>
    </p>

    <p>مع تحيات،<br>نظام فواترا</p>
</body>
</html>
