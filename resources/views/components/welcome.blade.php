<x-app-layout>
    <div class="container mx-auto py-6">
        @hasrole('postulante')
            <header class="hero-bg bg-gray-50 p-6 rounded-lg shadow-md">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="hero-info">
                        <h1 class="text-3xl font-bold mb-4">Encuentra tu Próxima Oportunidad</h1>
                        <p class="text-lg">En <strong>BolsaUPeU</strong>, te conectamos con las mejores empresas que están
                            buscando talento como el tuyo. Cada día miles de vacantes son publicadas en nuestro portal. Aquí
                            tienes lo que te espera:</p>
                        <ul class="list-disc ml-6 mt-4 text-md">
                            <li>Más de 8,958 empresas activamente contratando.</li>
                            <li>Vacantes en diversas áreas como tecnología, ventas, atención al cliente, y más.</li>
                            <li>Empresas reconocidas y líderes del mercado en diferentes industrias.</li>
                        </ul>
                        <p class="mt-4">Explora todas las oportunidades que hemos reunido para ayudarte a avanzar en tu
                            carrera profesional.</p>
                    </div>
                    <div class="hero-image mt-6 md:mt-0">
                        <img src="{{ asset('images/postulate.png') }}" alt="Login Image" class="w-80 h-auto">
                    </div>
                </div>
            </header>

            <main class="py-12">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                    <section id="empresas-destacadas" class="bg-white p-6 rounded-lg shadow-md">
                        <h2 class="text-2xl font-bold mb-6">Empresas Destacadas</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            <div class="company-card p-4 bg-gray-50 shadow-md rounded-lg">
                                <img src="https://images.computrabajo.com/2024/07/02/logosPE/covisian-pe-162x88.png"
                                    alt="covisian-peru" class="mx-auto mb-4">
                                <a href="https://pe.computrabajo.com/covisian-peru" target="_top"
                                    class="text-blue-500 font-semibold text-center block">Covisian Perú</a>
                            </div>
                            <div class="company-card p-4 bg-gray-50 shadow-md rounded-lg">
                                <img src="https://images.computrabajo.com/2024/07/02/logosPE/oca-global-pe-162x88.png"
                                    alt="ocaglobalperu" class="mx-auto mb-4">
                                <a href="https://pe.computrabajo.com/ocaglobalperu" target="_top"
                                    class="text-blue-500 font-semibold text-center block">OCA Global Perú</a>
                            </div>
                            <div class="company-card p-4 bg-gray-50 shadow-md rounded-lg">
                                <img src="https://images.computrabajo.com/2024/07/02/logosPE/boticasysalud-pe-162x88.png"
                                    alt="boticasysalud" class="mx-auto mb-4">
                                <a href="https://pe.computrabajo.com/boticasysalud" target="_top"
                                    class="text-blue-500 font-semibold text-center block">Boticas y Salud</a>
                            </div>
                            <div class="company-card p-4 bg-gray-50 shadow-md rounded-lg">
                                <img src="https://images.computrabajo.com/2024/07/02/logosPE/verisure-pe-162x88.png"
                                    alt="verisure" class="mx-auto mb-4">
                                <a href="https://pe.computrabajo.com/verisure" target="_top"
                                    class="text-blue-500 font-semibold text-center block">Verisure</a>
                            </div>
                        </div>
                    </section>
                </div>
            </main>
        @endhasrole

        @hasrole('empresa')
            <div class="container mx-auto py-16">
                <h2 class="text-4xl font-bold mb-12 text-center">Estadísticas de Empresa</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">

                    <div
                        class="bg-white shadow-xl rounded-xl p-8 transition duration-300 transform hover:scale-105 hover:shadow-2xl">
                        <div class="flex items-center">
                            <div class="bg-green-200 text-green-600 p-6 rounded-full mr-6">
                                <i class="fas fa-briefcase fa-3x"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold">Total de Ofertas Creadas</h3>
                                <p class="text-5xl font-bold mt-4">{{ $totalOfertas ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white shadow-xl rounded-xl p-8 transition duration-300 transform hover:scale-105 hover:shadow-2xl">
                        <div class="flex items-center">
                            <div class="bg-blue-200 text-blue-600 p-6 rounded-full mr-6">
                                <i class="fas fa-user-friends fa-3x"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold">Total de Postulantes</h3>
                                <p class="text-5xl font-bold mt-4">{{ $totalPostulantes ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white shadow-xl rounded-xl p-8 transition duration-300 transform hover:scale-105 hover:shadow-2xl">
                        <div class="flex items-center">
                            <div class="bg-red-200 text-red-600 p-6 rounded-full mr-6">
                                <i class="fas fa-calendar-times fa-3x"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold">Ofertas Vencidas</h3>
                                <p class="text-5xl font-bold mt-4">{{ $totalOfertasVencidas ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white shadow-xl rounded-xl p-8 transition duration-300 transform hover:scale-105 hover:shadow-2xl">
                        <div class="flex items-center">
                            <div class="bg-yellow-200 text-yellow-600 p-6 rounded-full mr-6">
                                <i class="fas fa-clock fa-3x"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold">Ofertas Pendientes</h3>
                                <p class="text-5xl font-bold mt-4">{{ $totalOfertasPendientes ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endhasrole
        @hasrole('admin')
            <div class="container mx-auto py-12">
                <h2 class="text-2xl font-bold mb-6">Panel de Administración</h2>

                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-2">Resumen de la Plataforma</h3>
                    <p>Aquí puedes gestionar usuarios, ofertas, y revisar estadísticas generales de la plataforma.</p>
                </div>
            </div>
        @endhasrole
    </div>
</x-app-layout>
