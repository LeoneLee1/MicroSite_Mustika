<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/logo pendarasa.jpg') }}">
    <title>Pendar rasa</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap');

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
            background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.85)), url('https://i.ibb.co.com/Kbp75Xh/photo-6163651440313222115-y.jpg');
            background-size: cover;
            background-position: center;
            opacity: 1;
            pointer-events: none;
        }

        .content {
            max-width: 1200px;
            padding: 2rem;
            z-index: 2;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .welcome {
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 2px;
            color: #868686;
            margin-bottom: 0.5rem;
        }

        #waktu {
            position: absolute;
            top: 20px;
            right: 20px;
            color: rgb(205, 205, 205);
            text-align: right;
            text-transform: uppercase;
            font-size: 0.7rem;
        }

        .main-text {
            font-size: 2.5rem;
            font-weight: 600;
            line-height: 1.2;
            margin-bottom: 1rem;
            max-width: 800px;
        }

        .content-wrapper {
            display: flex;
            gap: 2rem;
            align-items: flex-start;
        }

        .left-content {
            flex: 0 0 auto;
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
            margin-top: 1rem;
        }

        .btn:hover {
            background-color: white;
            color: black;
        }

        .sub-text {
            flex: 1;
            max-width: 500px;
            font-size: 0.7rem;
            line-height: 1.5;
            color: rgba(255, 255, 255, 0.7);
            text-align: justify;
            font-style: italic;
        }

        .sub-text p {
            margin: 0 0 0.75rem 0;
        }

        .sub-text p:last-child {
            margin-bottom: 0;
        }

        @media (max-width: 768px) {
            .content-wrapper {
                flex-direction: column;
                gap: 1.5rem;
            }

            .main-text {
                font-size: 2rem;
            }

            .sub-text {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="leaves"></div>
    <div class="content">
        {{-- <div class="clock" id="waktu">
            <p id="date"></p>
            <p id="time"></p>
        </div> --}}
        <div class="welcome">Selamat datang di pendarrasa</div>
        <div class="content-wrapper">
            <div class="left-content">
                <div class="main-text">
                    Pendaran rasa yang tak tampak mata, yang tak tersentuh tangan dan yang terabaikan oleh kepentingan
                </div>
                <a href="{{ route('beranda') }}" class="btn">Get Started</a>
            </div>
            <div class="sub-text">
                <p>Selamat datang di pendarrasa, sebuah platform yang mewadahi 'pendaran rasa' setiap insan manusia yang
                    saling bersentuhan dalam kebersamaan organisasi Mustika...</p>
                <p>Seperti yang tertuang di dalam namanya. 'Pendar' secara harafiah berarti 'pancaran cahaya lembut'
                    dari benda yang tidak mengeluarkan panas. Berbeda dengan 'pijar', yang mengandung pengertian
                    'panas'. Sedangkan 'rasa' itu sendiri secara harafiah adalah 'perasaan' yang diterima oleh panca
                    indera secara fisik dan juga oleh perasaan hati. Namun, ketika kedua kata ini digabungkan, ia
                    memiliki makna yang sangat khusus menjelaskan tentang 'perasaan hati' yang dipancarkan dari setiap
                    insan dan menyentuh insan lainnya...</p>
                <p>Platform pendarrasa ini mewadahi seluruh 'perasaan hati insan manusia' yang diharapkan bisa menyentuh
                    'nurani' yang paling dalam dan membuka kesadaran akan dirinya sebagai manusia yang bersentuhan
                    'rasa' dengan manusia lainnya...</p>
                <p>Platform pendarrasa ini akan berisikan obrolan ringan, diskusi dan postingan bebas berbasis 'rasa
                    sebagai manusia'. Platform ini sama sekali tidak akan membahas hal-hal teknis pekerjaan, melainkan
                    hanya akan berfokus pada 'rasa sebagai manusia' dan 'hubungan antar manusia' serta bagaimana
                    memperbaiki sebuah hubungan kebersamaan...</p>
                <p>Sekali lagi, selamat bergabung dan berdiskusi...</p>
            </div>
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
