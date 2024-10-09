<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/logo pendarasa.jpg') }}">
    <title>Pendar Rasa - Dalam Perbaikan</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f3f3f3;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            background-color: #000;
            color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        }

        .image-section img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .text-section h1 {
            font-size: 2em;
            margin: 0;
            padding: 10px;
        }

        .text-section p {
            font-size: 1em;
            margin: 10px 0;
        }

        .construction {
            font-size: 1.5em;
            font-weight: bold;
            color: #ffcc00;
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="image-section">
            <img src="https://i.ibb.co.com/F3pm3CZ/IMG-7245-1.jpg" alt="Pendar Rasa">
        </div>
        <div class="text-section">
            <p>Membingkai pendaran rasa yang tak tampak dalam kehidupan sehari-hari melalui seni bertutur</p>
            <p class="construction">⚙️Under Construction⚙️</p>
        </div>
    </div>
    <script>
        function createParticle() {
            const particle = document.createElement('span');
            particle.classList.add('particle');
            particle.style.left = Math.random() * 100 + '%';
            particle.style.top = Math.random() * 100 + '%';
            particle.style.width = particle.style.height = Math.random() * 10 + 5 + 'px';
            particle.style.background = `hsl(${Math.random() * 360}, 70%, 70%)`;
            particle.style.borderRadius = '50%';
            particle.style.opacity = Math.random() * 0.5 + 0.5;
            document.querySelector('.particles').appendChild(particle);
            setTimeout(() => {
                particle.remove();
            }, 15000);
        }
        setInterval(createParticle, 300);
    </script>
</body>

</html>
