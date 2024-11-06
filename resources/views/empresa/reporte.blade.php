<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-4xl font-extrabold text-gray-800 leading-tight">
                {{ __('Reporte de Postulaciones por Oferta Laboral') }}
            </h2>

            {{-- Botones para descargar PDF o Excel --}}
            <div class="flex space-x-4">
                <form method="POST" id="form-pdf">
                    @csrf
                    <input type="hidden" id="pdf_oferta_id" name="oferta_id">
                    <button type="submit" formaction="{{ route('empresa.reporte.pdf') }}" class="inline-flex items-center px-4 py-2 bg-indigo-500 text-white font-bold rounded-md shadow-md">
                        <i class="fas fa-download mr-2"></i>{{ __('PDF') }}
                    </button>
                </form>

                <form method="POST" id="form-excel">
                    @csrf
                    <input type="hidden" id="excel_oferta_id" name="oferta_id">
                    {{--<button type="submit" formaction="{{ route('empresa.reporte.excel') }}" class="inline-flex items-center px-4 py-2 bg-green-500 text-white font-bold rounded-md shadow-md">
                        <i class="fas fa-file-excel mr-2"></i>{{ __('Excel') }}
                    </button>--}}
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="p-8">
                    {{-- Filtro de ofertas laborales --}}
                    <h3 class="text-2xl font-extrabold text-gray-800 mb-4">Selecciona una Oferta</h3>

                    <div class="flex items-center space-x-4 mb-8">
                        <div class="flex-grow">
                            {{-- Input para buscar ofertas --}}
                            <input type="text" id="buscador-ofertas" class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Buscar oferta laboral...">
                        </div>

                        <div class="flex-grow">
                            {{-- Dropdown para seleccionar ofertas laborales --}}
                            <label for="oferta_id" class="block text-sm font-medium text-gray-700">Oferta Laboral</label>
                            <select id="oferta_id" class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                <option value="">Selecciona una oferta</option>
                                @foreach($ofertas as $oferta)
                                    <option value="{{ $oferta->id }}">{{ $oferta->titulo }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-6">
                            {{-- Botón de filtrar --}}
                            <button type="button" id="btn-filtrar" class="inline-flex items-center px-4 py-2 bg-indigo-500 text-white font-bold rounded-md shadow-md">
                                <i class="fas fa-filter mr-2"></i>{{ __('Filtrar') }}
                            </button>
                        </div>
                    </div>

                    {{-- Tabla de resultados --}}
                    <div id="tabla-postulantes" class="overflow-x-auto">
                        <!-- Aquí se llenarán los resultados de los postulantes usando AJAX -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Filtrar ofertas por título
        document.getElementById('buscador-ofertas').addEventListener('input', function() {
            const query = this.value.toLowerCase();
            const opciones = document.querySelectorAll('#oferta_id option');

            opciones.forEach(opcion => {
                const texto = opcion.textContent.toLowerCase();
                if (texto.includes(query)) {
                    opcion.style.display = '';
                } else {
                    opcion.style.display = 'none';
                }
            });
        });

        // Al hacer clic en el botón de "Filtrar"
        document.getElementById('btn-filtrar').addEventListener('click', function() {
            const ofertaId = document.getElementById('oferta_id').value;
            document.getElementById('pdf_oferta_id').value = ofertaId;
            document.getElementById('excel_oferta_id').value = ofertaId;
            cargarPostulantes(ofertaId);
        });

        // Función para cargar postulantes mediante AJAX
        function cargarPostulantes(ofertaId) {
    if (ofertaId) {
        fetch(`/empresa/reporte/postulantes/${ofertaId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                let tabla = `
                    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                        <thead class="bg-gray-100 border-b">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">#</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Nombre</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Correo</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Fecha de Postulación</th>
                            </tr>
                        </thead>
                        <tbody>
                `;
                if (data.length > 0) {
                    data.forEach((postulacion, index) => {
                        tabla += `
                            <tr>
                                <td class="px-6 py-4">${index + 1}</td>
                                <td class="px-6 py-4">${postulacion.user.name}</td>
                                <td class="px-6 py-4">${postulacion.user.email}</td>
                                <td class="px-6 py-4">${new Date(postulacion.created_at).toLocaleDateString()}</td>
                            </tr>
                        `;
                    });
                } else {
                    tabla += `<tr><td colspan="4" class="px-6 py-4 text-center">No se encontraron postulantes</td></tr>`;
                }
                tabla += '</tbody></table>';
                document.getElementById('tabla-postulantes').innerHTML = tabla;
            })
            .catch(error => {
                console.error('Hubo un problema con la petición:', error);
                document.getElementById('tabla-postulantes').innerHTML = 'Error al cargar los postulantes.';
            });
    } else {
        document.getElementById('tabla-postulantes').innerHTML = '';
    }
}

    </script>
</x-app-layout>
