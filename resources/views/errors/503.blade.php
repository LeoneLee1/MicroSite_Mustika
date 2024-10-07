<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pendar Rasa - Dalam Perbaikan</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@300;400&display=swap');

        body,
        html {
            height: 100%;
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            overflow: hidden;
        }

        .container {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
            box-sizing: border-box;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3.5em;
            color: #2c3e50;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .image-container {
            width: 90%;
            max-width: 800px;
            height: 60vh;
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.3) 30%, rgba(0, 0, 0, 0.3) 70%, rgba(0, 0, 0, 0.7) 100%);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 20px;
            color: white;
            text-align: center;
        }

        .description {
            font-size: 1.2em;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .maintenance-text {
            font-size: 1em;
            line-height: 1.4;
        }

        .glow {
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from {
                text-shadow: 0 0 5px #fff, 0 0 10px #fff, 0 0 15px #e60073, 0 0 20px #e60073, 0 0 35px #e60073;
            }

            to {
                text-shadow: 0 0 10px #fff, 0 0 20px #ff4da6, 0 0 30px #ff4da6, 0 0 40px #ff4da6, 0 0 50px #ff4da6;
            }
        }

        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            display: block;
            pointer-events: none;
            animation: float 15s infinite ease-in-out;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="particles"></div>
        <h1 class="glow">PENDAR RASA</h1>
        <div class="image-container">
            <img src="https://i.ibb.co.com/72wxWRs/image.jpg" alt="Wanita tersenyum di ladang" />
            <div class="image-overlay">
                <div class="description">
                    Membingkai pendaran rasa yang tak tampak dalam kehidupan sehari-hari melalui seni bertutur
                </div>
                <div class="maintenance-text">
                    <p>Mohon maaf, saat ini kami sedang melakukan perbaikan untuk meningkatkan pengalaman Anda.</p>
                    <p>Silakan kembali dalam beberapa saat untuk menikmati cerita-cerita penuh makna dari kami.</p>
                </div>
            </div>
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
