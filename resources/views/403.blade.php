<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 403 - Akses Ditolak - Pendarrasa</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1a1a1a;
        }

        .container {
            text-align: center;
            padding: 2rem;
            max-width: 600px;
        }

        .lock-icon {
            font-size: 80px;
            margin-bottom: 1rem;
            animation: shake 0.5s ease-in-out infinite;
            display: inline-block;
        }

        .error-code {
            font-size: 120px;
            font-weight: bold;
            color: #696cff;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .error-message {
            font-size: 24px;
            margin-bottom: 1rem;
            color: #34495e;
        }

        .error-description {
            font-size: 16px;
            color: #7f8c8d;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .back-button {
            background: #696cff;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .back-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        @keyframes shake {

            0%,
            100% {
                transform: rotate(0deg);
            }

            25% {
                transform: rotate(-10deg);
            }

            75% {
                transform: rotate(10deg);
            }
        }

        @media (max-width: 480px) {
            .error-code {
                font-size: 80px;
            }

            .error-message {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="lock-icon">🔒</div>
        <div class="error-code">403</div>
        <div class="error-message">Akses Ditolak!</div>
        <div class="error-description">
            Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.
            Silakan hubungi administrator jika Anda merasa ini adalah kesalahan.
        </div>
        <a href="/" class="back-button">Kembali ke Beranda</a>
    </div>
</body>

</html>
