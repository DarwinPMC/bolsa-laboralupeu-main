<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Bolsa Laboral')</title>
    <link rel="preload" href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">
    </noscript>
    @vite(['resources/css/app.css', 'resources/css/custom.css', 'resources/js/app.js'])
</head>

<body class="font-sans bg-gray-100">
    <header class="bg-white shadow-md">
        <div class="container mx-auto flex justify-between items-center py-4 px-2">
            <!-- Logo y enlace principal -->
            <h1 class="text-2xl font-bold text-blue-900 animated-text">
                <a href="{{ url('/') }}" class="hover:text-blue-700 transition-colors duration-200">
                    <span>B</span>
                    <span>o</span>
                    <span>l</span>
                    <span>s</span>
                    <span>a</span>
                    <span>U</span>
                    <span>P</span>
                    <span>e</span>
                    <span>U</span>
                </a>
            </h1>

           <!-- Navegación Principal -->
<nav aria-label="Main navigation" class="space-x-6 text-black font-medium hidden md:flex">
    <!-- Enlace a Sobre Nosotros -->
    <a href="{{ url('/about') }}" class="hover:text-blue-900 transition duration-300 ease-in-out text-lg">
        Sobre Nosotros
    </a>
    <!-- Enlace a la sección de Contacto -->
    <a href="{{ url('/contact') }}" class="hover:text-blue-900 transition duration-300 ease-in-out text-lg">
        Contáctenos
    </a>
    <!-- Enlace a Ofertas de Empleo -->
    <a href="{{ url('/jobs') }}" class="hover:text-blue-900 transition duration-300 ease-in-out text-lg">
        Ofertas de Empleo
    </a>
    <!-- Enlace a Empresas -->
    <a href="{{ url('/companies') }}" class="hover:text-blue-900 transition duration-300 ease-in-out text-lg">
        Empresas
    </a>
</nav>

            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-gray-700 hover:text-blue-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>
            <!-- Menú desplegable para móviles -->
            <div id="mobile-menu" class="hidden md:hidden flex flex-col space-y-4 text-center mt-4">
                <a href="{{ url('/about') }}" class="text-gray-700 hover:text-blue-900 text-lg">Sobre Nosotros</a>
                <a href="{{ url('/contact') }}" class="text-gray-700 hover:text-blue-900 text-lg">Contáctenos</a>
                <a href="{{ url('/jobs') }}" class="text-gray-700 hover:text-blue-900 text-lg">Ofertas de Empleo</a>
                <a href="{{ url('/companies') }}" class="text-gray-700 hover:text-blue-900 text-lg">Empresas</a>
            </div>

            <!-- Autenticación (Iniciar Sesión / Registrar / Cerrar Sesión) -->
            <div class="space-x-2">
                @guest
                    <!-- Botón para iniciar sesión -->
                    <a href="{{ route('login') }}"
                        class="btn border border-blue-900 text-blue-900 px-4 py-2 rounded-lg hover:bg-blue-900 hover:text-white transition-colors duration-200">
                        Inicia Sesión
                    </a>
                    <!-- Botón para registrarse -->
                    <a href="{{ route('register') }}"
                        class="btn bg-blue-900 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition-colors duration-200">
                        Registrar
                    </a>
                @endguest

                @auth
                    <!-- Botón para cerrar sesión -->
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf
                        <button type="submit"
                            class="btn border border-red-600 text-red-600 px-4 py-2 rounded-lg hover:bg-red-600 hover:text-white transition-colors duration-200">
                            Cerrar Sesión
                        </button>
                    </form>
                @endauth
            </div>
        </div>

    </header>
    <style>
      .animated-text {
    display: inline-block;
    position: relative;
}

/* Animación para las letras */
.animated-text span {
    display: inline-block;
    animation: bounceUp 0.8s ease-in-out forwards, explode 1s ease-in-out 3s forwards, reappear 1s ease-in-out 4s forwards;
}

/* Control de los tiempos de inicio para cada letra en secuencia */
.animated-text span:nth-child(1) { animation-delay: 0s, 3s, 4s; }
.animated-text span:nth-child(2) { animation-delay: 0.3s, 3s, 4s; }
.animated-text span:nth-child(3) { animation-delay: 0.6s, 3s, 4s; }
.animated-text span:nth-child(4) { animation-delay: 0.9s, 3s, 4s; }
.animated-text span:nth-child(5) { animation-delay: 1.2s, 3s, 4s; }
.animated-text span:nth-child(6) { animation-delay: 1.5s, 3s, 4s; }
.animated-text span:nth-child(7) { animation-delay: 1.8s, 3s, 4s; }
.animated-text span:nth-child(8) { animation-delay: 2.1s, 3s, 4s; }
.animated-text span:nth-child(9) { animation-delay: 2.4s, 3s, 4s; }

/* Animación de salto y cambio de color */
@keyframes bounceUp {
    0% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-20px); /* Las letras saltan hacia arriba */
        color: #3B82F6; /* Cambian de color mientras están en el aire */
    }
    100% {
        transform: translateY(0); /* Vuelven a su posición original */
        color: #1E3A8A; /* Vuelven a su color original */
    }
}

/* Animación de explosión al final */
@keyframes explode {
    0% {
        transform: scale(1);
        opacity: 1;
    }
    100% {
        transform: scale(3); /* Las letras se agrandan */
        opacity: 0; /* Desaparecen */
    }
}

@keyframes reappear {
    0% {
        opacity: 0;
        transform: scale(0.5);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}
        .btn {
            appearance: none;
            display: inline-block;
            text-align: center;
            text-decoration: none;
            font-size: 1rem;
            line-height: 1.5;
            padding: 0.5rem 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .btn:hover,
        .btn:focus {
            outline: none;
        }

        @media (max-width: 640px) {
            .btn {
                width: 100%;
                padding: 0.75rem;
            }
        }
    </style>

<script>
    const letters = document.querySelectorAll('.animated-text span');

    function restartAnimations() {
      letters.forEach(letter => {
        letter.style.animation = 'none';
        letter.offsetHeight;
        letter.style.animation = '';
      });
    }

    setInterval(restartAnimations, 7000);
  </script>

    <section class="hero-bg text-white relative">
        <video autoplay muted loop playsinline preload="auto" poster="" id="heroVideo"
            style="object-fit: cover; width: 100%; height: 100%;">
            <source src="https://cp.ct-stc.com/web/v02.02.00.20/c/video/video_public_landing.mp4" type="video/mp4">
            Your browser does not support HTML5 video.
        </video>
        <div class="hero-overlay absolute inset-0 bg-black opacity-50"></div>
        <div class="flex items-center justify-center h-full relative z-10 px-4">
            <div class="text-center">
                <h2 class="text-5xl font-bold">¡Encuentra tu próximo empleo!</h2>
                <p class="mt-4 text-2xl">
                    Explora más de <strong>{{ $numOfertas }}</strong> ofertas disponibles,
                    con <strong>{{ $numPostulantes }}</strong> postulantes y <strong>{{ $numEmpresas }}</strong> empresas registradas.
                </p>

                <form action="" method="GET" class="mt-8 flex justify-center space-x-4">
                    <!-- Aquí puedes añadir campos para la búsqueda de empleos -->
                </form>
            </div>

        </div>
    </section>

    <section class="relative py-6 bg-blue-900 text-white">
        <div class="container mx-auto text-center">
            <h3 class="text-3xl font-bold mb-4">Nuestras Estadísticas</h3>
            <div class="flex justify-around items-center space-x-8">

                <!-- Postulantes -->
                <div class="bg-blue-800 p-4 rounded-xl shadow-md hover:shadow-lg transform transition duration-300 hover:scale-105 flex-1">
                    <div class="flex flex-col items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-yellow-400 mb-2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 11c2.761 0 5-2.239 5-5s-2.239-5-5-5-5 2.239-5 5 2.239 5 5 5zm0 2c-4.418 0-8 2.686-8 6v3h16v-3c0-3.314-3.582-6-8-6z" />
                        </svg>
                        <span class="block text-4xl font-extrabold text-yellow-400 counter"
                            data-target="{{ $numPostulantes }}">0</span>
                        <p class="mt-1 text-lg">Postulantes</p>
                    </div>
                </div>

                <!-- Empresas -->
                <div class="bg-blue-800 p-4 rounded-xl shadow-md hover:shadow-lg transform transition duration-300 hover:scale-105 flex-1">
                    <div class="flex flex-col items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-yellow-400 mb-2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 10h18M3 6h18M9 14h6M9 18h6M3 14h6v4H3v-4zm18 0h-6v4h6v-4z" />
                        </svg>
                        <span class="block text-4xl font-extrabold text-yellow-400 counter"
                            data-target="{{ $numEmpresas }}">0</span>
                        <p class="mt-1 text-lg">Empresas</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-gray-100">
        <div class="w-full px-4">
            <h3 class="text-4xl font-bold text-center text-gray-800 mb-12">Conéctate con Nosotros</h3>

            <div class="flex flex-col md:flex-row justify-center items-center bg-white shadow-lg rounded-lg p-8">
                <div class="w-full md:w-1/3 flex justify-center mb-8 md:mb-0">
                    <picture>
                        <source class="lazy" srcset="//cp.ct-stc.com/web/v02.02.00.20/c/img/encontrar_empleo.webp"
                            type="image/webp">
                        <img class="lazy w-72 h-auto rounded-lg shadow-md"
                            src="//cp.ct-stc.com/web/v02.02.00.20/c/img/encontrar_empleo.png" alt="Encontrar empleo">
                    </picture>
                </div>

                <div class="w-full md:w-2/3 flex flex-col justify-center items-center space-y-8">
                    <div class="flex space-x-8">
                        <a href="https://twitter.com/gafer.up/" target="_blank"
                            class="text-blue-600 hover:text-blue-800 transition duration-300">
                            <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.954 4.569c-.885.392-1.83.656-2.825.775a4.932 4.932 0 0 0 2.163-2.724 9.837 9.837 0 0 1-3.127 1.196 4.92 4.92 0 0 0-8.384 4.482A13.978 13.978 0 0 1 1.671 3.149a4.902 4.902 0 0 0-.666 2.475c0 1.706.87 3.213 2.188 4.099a4.904 4.904 0 0 1-2.229-.616v.062a4.918 4.918 0 0 0 3.946 4.827 4.94 4.94 0 0 1-2.224.085 4.937 4.937 0 0 0 4.604 3.419 9.868 9.868 0 0 1-6.102 2.105c-.39 0-.779-.023-1.17-.068a13.94 13.94 0 0 0 7.548 2.213c9.057 0 14.01-7.512 14.01-14.01 0-.213 0-.426-.015-.637A10.025 10.025 0 0 0 24 4.59a9.834 9.834 0 0 1-2.872.787z" />
                            </svg>
                        </a>

                        <a href="https://www.instagram.com/gafer.up/" target="_blank"
                            class="text-blue-600 hover:text-blue-800 transition duration-300">
                            <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 1.18.054 1.968.24 2.437.401a4.92 4.92 0 0 1 1.777 1.153 4.92 4.92 0 0 1 1.153 1.777c.161.469.347 1.257.401 2.437.058 1.267.07 1.647.07 4.85s-.012 3.584-.07 4.85c-.054 1.18-.24 1.968-.401 2.437a4.92 4.92 0 0 1-1.153 1.777 4.92 4.92 0 0 1-1.777 1.153c-.469.161-1.257.347-2.437.401-1.267.058-1.647.07-4.85.07s-3.584-.012-4.85-.07c-1.18-.054-1.968-.24-2.437-.401a4.92 4.92 0 0 1-1.777-1.153 4.92 4.92 0 0 1-1.153-1.777c-.161-.469-.347-1.257-.401-2.437-.058-1.267-.07-1.647-.07-4.85s.012-3.584.07-4.85c.054-1.18.24-1.968.401-2.437a4.92 4.92 0 0 1 1.153-1.777 4.92 4.92 0 0 1 1.777-1.153c.469-.161 1.257-.347 2.437-.401C8.416 2.175 8.796 2.163 12 2.163zm0-2.163C8.691 0 8.267.014 7.052.072 5.828.13 4.834.314 3.953.653a6.884 6.884 0 0 0-2.633 1.719A6.884 6.884 0 0 0 .653 5.005c-.339.881-.523 1.875-.581 3.099C.014 8.733 0 9.157 0 12s.014 3.267.072 4.482c.058 1.224.242 2.218.581 3.099a6.884 6.884 0 0 0 1.719 2.633 6.884 6.884 0 0 0 2.633 1.719c.881.339 1.875.523 3.099.581C8.733 23.986 9.157 24 12 24s3.267-.014 4.482-.072c1.224-.058 2.218-.242 3.099-.581a6.884 6.884 0 0 0 2.633-1.719 6.884 6.884 0 0 0 1.719-2.633c.339-.881.523-1.875.581-3.099.058-1.215.072-1.639.072-4.482s-.014-3.267-.072-4.482c-.058-1.224-.242-2.218-.581-3.099a6.884 6.884 0 0 0-1.719-2.633A6.884 6.884 0 0 0 19.005.653c-.881-.339-1.875-.523-3.099-.581C15.267.014 14.843 0 12 0z" />
                                <path
                                    d="M12 5.838A6.162 6.162 0 0 0 5.838 12 6.162 6.162 0 0 0 12 18.162 6.162 6.162 0 0 0 18.162 12 6.162 6.162 0 0 0 12 5.838zm0 10.162A3.838 3.838 0 0 1 8.162 12 3.838 3.838 0 0 1 12 8.162 3.838 3.838 0 0 1 15.838 12 3.838 3.838 0 0 1 12 16zm4.406-10.845a1.44 1.44 0 1 1 0-2.88 1.44 1.44 0 0 1 0 2.88z" />
                            </svg>
                        </a>

                    </div>

                    <div class="flex space-x-4 justify-center">
                        <a href="https://play.google.com/store/apps/details?id=com.redarbor.computrabajo&amp;hl=es&amp;referrer=cts%3D1%26ctp%3D3%26ctz%3D3"
                            target="_blank" rel="noopener noreferrer nofollow">
                            <img class="w-36 h-auto"
                                src="//cp.ct-stc.com/web/v02.02.00.20/c/img/es-419_generic_rgb_wo_45.svg"
                                alt="Disponible en Google Play">
                        </a>
                        <a href="https://itunes.apple.com/es/app/computrabajo-ofertas-empleo/id1093787284?mt=8"
                            target="_blank" rel="noopener noreferrer nofollow">
                            <img class="w-36 h-auto" src="//cp.ct-stc.com/web/v02.02.00.20/c/img/ios_app.svg"
                                alt="Consíguela en AppStore">
                        </a>
                        <a href="https://appgallery.huawei.com/#/app/C102560361" target="_blank"
                            rel="noopener noreferrer nofollow">
                            <img class="w-36 h-auto" src="//cp.ct-stc.com/web/v02.02.00.20/c/img/huawei_app.svg"
                                alt="Disponible en Huawei AppGallery">
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <footer class="bg-blue-900 text-white py-8">
        <div class="container mx-auto text-center">
            <p>BolsaUPeU &copy; 2024 - Todos los derechos reservados</p>
            <p>Contacto: Darwin Mamani | Tel: +51 927 999 598 | Email: info@bolsaupeu.com</p>
        </div>
    </footer>

</body>

</html>
<script>
    function animateCounters() {
        const counters = document.querySelectorAll('.counter');
        counters.forEach(counter => {
            const updateCounter = () => {
                const target = +counter.getAttribute('data-target');
                const current = +counter.innerText;

                let increment;
                let speed;

                if (target <= 10) {
                    increment = 0.1;
                    speed = 200;
                } else if (target <= 100) {
                    increment = target / 200;
                    speed = 50;
                } else {
                    increment = target / 200;
                    speed = 10;
                }

                if (current < target) {
                    counter.innerText = Math.ceil(current + increment);
                    setTimeout(updateCounter, speed);
                } else {
                    counter.innerText = target;
                }
            };
            updateCounter();
        });
    }

    window.onload = animateCounters;
    document.getElementById('mobile-menu-button').addEventListener('click', function () {
    const menu = document.getElementById('mobile-menu');
    menu.classList.toggle('hidden');
});

</script>
