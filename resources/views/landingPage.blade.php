<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/logo pendarasa.jpg') }}">
    <title>Pendar rasa</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');

        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            height: 100vh;
            background-color: #0a0a0a;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .leaves {
            position: absolute;
            right: 0;
            top: 0;
            height: 100%;
            width: 100%;
            background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://i.ibb.co.com/Kbp75Xh/photo-6163651440313222115-y.jpg');
            background-size: cover;
            opacity: 0.8;
            pointer-events: none;
        }

        .content {
            max-width: 800px;
            padding: 2rem;
            z-index: 2;
        }

        .welcome {
            text-transform: uppercase;
            font-size: 0.875rem;
            letter-spacing: 2px;
            color: #868686;
            margin-bottom: 1rem;
        }

        #waktu {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            color: rgb(205, 205, 205);
            text-align: center;
            text-transform: uppercase;
        }

        .main-text {
            font-size: 2.5rem;
            font-weight: 600;
            line-height: 1.2;
            margin-bottom: 3rem;
        }

        .buttons {
            display: flex;
            gap: 1rem;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            font-size: 0.875rem;
            color: white;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: 1px solid white;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background-color: white;
            color: black;
        }
    </style>
</head>

<body>
    <div class="leaves"></div>
    <div class="content">
        <div class="clock" id="waktu">
            <p id="date"></p>
            <p id="time"></p>
        </div>
        <div class="welcome">Selamat datang di pendarrasa</div>
        <div class="main-text">
            Pendaran rasa yang tak tampak mata, yang tak tersentuh tangan dan yang terabaikan oleh kepentingan
        </div>
        <div class="buttons">
            <a href="{{ route('beranda') }}" class="btn">Get Started</a>
        </div>
    </div>
    <script>
        const WEEK = ["MINGGU", "SENIN", "SELASA", "RABU", "KAMIS", "JUMAT", "SABTU"];

        function updateTime() {
            var now = new Date();

            document.getElementById("time").innerText =
                zeroPadding(now.getHours(), 2) + ":" +
                zeroPadding(now.getMinutes(), 2) + ":" +
                zeroPadding(now.getSeconds(), 2);

            document.getElementById("date").innerText =
                now.getFullYear() + "/" +
                zeroPadding(now.getMonth() + 1, 2) + "/" +
                zeroPadding(now.getDate(), 2) + " " +
                WEEK[now.getDay()];
        }

        updateTime();
        setInterval(updateTime, 1000);

        function zeroPadding(num, digit) {
            return String(num).padStart(digit, '0');
        }
    </script>
</body>

</html>
