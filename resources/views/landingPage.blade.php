<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://t3.ftcdn.net/jpg/07/83/62/04/360_F_783620476_haep6efhqJ0dkYUFG4oH0x3sdcwXsvMR.jpg');
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

        .main-text {
            font-size: 3.5rem;
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
        <div class="welcome">Welcome to Pendar rasa</div>
        <div class="main-text">
            Memintal kebersamaan, merajut sukses keberlanjutan
        </div>
        <div class="buttons">
            <a href="{{ route('beranda') }}" class="btn">Get Started</a>
        </div>
    </div>
</body>

</html>
