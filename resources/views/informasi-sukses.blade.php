<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Terima Kasih Telah Mendaftar</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo oval mustika.png') }}">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
        }

        .container {
            text-align: center;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .timer {
            font-size: 16px;
            color: #555;
        }
    </style>
    <script>
        let timer = 5;

        function countdown() {
            const timerElement = document.getElementById('timer');
            timerElement.textContent = timer;
            if (timer > 0) {
                timer--;
                setTimeout(countdown, 1000);
            } else {
                window.location.href = '/login';
            }
        }
        window.onload = countdown;
    </script>
</head>

<body>
    <div class="container">
        <h1>Terima Kasih Telah Mendaftar!</h1>
        <p>Kami akan segera menghubungi Anda dengan menginformasikan kata sandi Anda melalui nomor WhatsApp yang
            terdaftar. Harap tunggu.</p>
        <p class="timer">Anda akan diarahkan ke halaman login di <span id="timer">5</span> detik.</p>
    </div>
</body>

</html>
