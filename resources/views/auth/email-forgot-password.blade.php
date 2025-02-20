<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <p>Halo,</p>
    <p>Kami menerima permintaan untuk mengatur ulang kata sandi Anda. Klik tautan di bawah ini untuk mengatur ulang kata sandi Anda:</p>
    <p><a href="{{ $resetUrl }}">Reset Sandi</a></p>
    <p>Jika Anda tidak meminta pengaturan ulang kata sandi, abaikan email ini.</p>
    <br>
    <p>Terima kasih,</p>
    <p>Tim {{ config('app.name') }}</p>
</body>
</html>
