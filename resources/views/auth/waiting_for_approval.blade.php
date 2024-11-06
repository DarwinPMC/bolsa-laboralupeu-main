<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-50 to-blue-100">
        <div class="bg-white shadow-lg rounded-xl p-10 max-w-lg mx-auto animate__animated animate__fadeIn">
            <div class="flex flex-col items-center space-y-6">
                <!-- Contenedor para la animación de Lottie en la página -->
                <div id="lottie-cat" class="w-90 h-90"></div>

                <h1 class="text-4xl font-bold text-blue-800 mb-2 relative animate__animated animate__pulse animate__infinite transition-all duration-500 ease-in-out before:absolute before:left-0 before:bottom-0 before:w-full before:h-1 before:bg-blue-800 before:scale-x-0 hover:before:scale-x-100 before:origin-left before:transition-transform before:duration-500 flex items-center">
                    <i class="fas fa-exclamation-triangle text-yellow-500 mr-3"></i> <!-- Icono de alerta -->
                    Esperando Aprobación
                </h1>
                <p class="text-lg md:text-xl font-normal text-gray-800 text-center leading-relaxed max-w-3xl mx-auto animate__animated animate__fadeInUp animate__delay-1s transition-all duration-500 ease-in-out hover:font-bold">
                    <span class="inline-flex items-center bg-blue-50 p-3 rounded-full mr-3 shadow-sm">
                        <i class="fas fa-info-circle text-blue-500 text-2xl"></i>
                    </span>
                    <span class="block mt-4 md:mt-0">Gracias por registrarse. Su cuenta está pendiente de aprobación por un administrador. Recibirá un correo electrónico una vez que su cuenta sea aprobada.</span>
                </p>


                @auth
                <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                    @csrf
                </form>
                @endauth

                <button
    class="relative border-2 border-blue-800 text-blue-800 px-6 py-3 rounded-full font-semibold transition-all duration-500 ease-in-out overflow-hidden group focus:outline-none focus:ring-2 focus:ring-blue-500"
    onclick="
    @auth
        event.preventDefault();
        document.getElementById('logout-form').submit();
    @else
        window.location.href='/';
    @endauth"
    >
    <span class="relative z-10 transition-colors duration-500 ease-in-out group-hover:text-white">
        Volver a la Página Principal
    </span>
    <span class="absolute inset-0 bg-blue-800 transform scale-x-0 origin-left transition-transform duration-500 ease-in-out group-hover:scale-x-100"></span>
</button>

            </div>
        </div>
    </div>

    <!-- Incluir SweetAlert2 desde CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Scripts para Lottie -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.6/lottie.min.js"></script>
    <script>
        // Inicializar la animación Lottie en la página
        var animation = lottie.loadAnimation({
            container: document.getElementById('lottie-cat'), // ID del contenedor donde se reproducirá la animación
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: 'https://lottie.host/90632b3b-ff89-4301-a176-5a3e9fc1d1cb/lACFg6qLwi.json' // Ruta al archivo JSON de la animación proporcionada
        });

        // Mostrar SweetAlert con solo texto una sola vez usando localStorage
        document.addEventListener('DOMContentLoaded', function () {
            if (!localStorage.getItem('alertShown')) {
                Swal.fire({
                    title: '¡Solicitud Enviada con Éxito!',
                    text: 'Tu solicitud ha sido enviada al administrador. Gracias por tu paciencia. Recibirás una notificación cuando sea aprobada.',
                    icon: 'success',
                    confirmButtonText: 'Entendido',
                    customClass: {
                        popup: 'rounded-lg'
                    }
                }).then(() => {
                    localStorage.setItem('alertShown', 'true'); // Marcar la alerta como mostrada
                });
            }
        });
    </script>
</x-guest-layout>
