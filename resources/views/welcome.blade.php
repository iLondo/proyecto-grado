<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Parqueadero la 22</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Estilos adicionales -->
    <style>
        :root {
            --primary-color: black; /* Color del texto */
            --secondary-color: black;
            --dark-bg: #121212;
            --light-bg: #f1f1f1;
            --button-hover: #1daae2;
            --shadow-color: rgba(0, 0, 0, 0.2);
            --accent-color: #F0F0F0; /* Color secundario */
        }

        body {
            background-color: #ffffff; /* Fondo blanco */
            font-family: 'Figtree', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: var(--primary-color);
            transition: background-color 0.3s ease; /* Transición para tema oscuro */
        }

        .bg-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://media.istockphoto.com/id/1397038664/es/foto/coches-aparcados-en-garaje-de-varias-plantas.jpg?s=612x612&w=0&k=20&c=FmNNS_Hh_9Nl6Kk33QrbOetP5KE8MuSYqPdTWf_NOY4=') no-repeat center center;
            background-size: cover;
            filter: blur(5px);
            z-index: -1;
        }

        .container {
            text-align: center;
            padding: 40px;
            background-color: rgba(255, 255, 255, 0.8); /* Fondo semi-transparente */
            border-radius: 12px;
            box-shadow: 0 6px 18px var(--shadow-color);
            backdrop-filter: blur(5px); /* Efecto de desenfoque para el fondo */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .container:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 24px var(--shadow-color);
        }

        .header {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 30px;
            font-weight: bold;
            text-transform: uppercase;
            text-shadow: 2px 2px rgba(0, 0, 0, 0.3);
            animation: fadeIn 1s ease-out;
        }

        .date-time {
            font-size: 1.5rem;
            margin-top: 20px;
            color: var(--primary-color);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn {
            font-size: 18px;
            padding: 14px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 15px;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .btn-login {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-login:hover {
            background-color: var(--button-hover);
            transform: scale(1.05);
        }

        .btn-register {
            background-color: var(--secondary-color);
            color: white;
        }

        .btn-register:hover {
            background-color: #1daae2;
            transform: scale(1.05);
        }

        /* Estilos para tema oscuro */
        body.dark-mode {
            background-color: var(--dark-bg);
            color: white;
        }

        body.dark-mode .container {
            background-color: #222;
            box-shadow: 0 6px 18px rgba(255, 255, 255, 0.3);
        }

        body.dark-mode .header {
            color: #FF5722;
        }
    </style>
</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div class="bg-image"></div>
    <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
        <div class="container">
            <header class="header">
                <h1>Parqueadero la 22</h1>
                <div class="date-time" id="date-time"></div>
            </header>

            <div>
                @if (Route::has('login'))
                    <nav class="flex justify-center">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="btn btn-login">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="btn btn-login">
                                ENTRAR
                            </a>
                        @endauth
                    </nav>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Función para actualizar la fecha y hora
        function updateDateTime() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
            const dateTime = now.toLocaleString('es-ES', options);
            document.getElementById("date-time").textContent = dateTime;
        }
        // Actualizar la fecha y hora cada segundo
        setInterval(updateDateTime, 1000);
        updateDateTime(); // Ejecutar una vez al cargar
    </script>
</body>

</html>