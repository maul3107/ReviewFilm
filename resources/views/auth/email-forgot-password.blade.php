<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            text-align: center;
            padding: 20px;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
        }

        a {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            text-decoration: none;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
        }

        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Halo,</h2>
        <p>Kami menerima permintaan untuk mengatur ulang kata sandi Anda. Klik tombol di bawah ini untuk mengatur ulang
            kata sandi Anda:</p>
        <p><a href="{{ $resetUrl }}">Reset Kata Sandi</a></p>
        <p>Jika Anda tidak meminta pengaturan ulang kata sandi, abaikan email ini.</p>
        <br>
        <p>Terima kasih,</p>
        <p>Tim {{ config('app.name') }}</p>
    </div>
</body>

</html>
