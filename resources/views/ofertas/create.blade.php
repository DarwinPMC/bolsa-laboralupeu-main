<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            <i class="fas fa-briefcase"></i> {{ __('Crear Nueva Oferta Laboral') }}
        </h2>
    </x-slot>
    <div x-data="ofertaForm()" class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md sm:rounded-lg p-6 lg:p-8 space-y-6">
                <form action="{{ route('ofertas.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h3 class="text-xl font-semibold text-gray-700 border-b pb-2 mb-4">Información Básica</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="titulo" class="block text-gray-700 font-bold mb-2">
                                <i class="fas fa-pen"></i> Título de la Oferta
                            </label>
                            <x-input-field name="titulo" placeholder="Ej: Asistente de Ventas" required />
                        </div>
                        <div>
                            <label for="empresa" class="block text-gray-700 font-bold mb-2">
                                <i class="fas fa-building"></i> Empresa
                            </label>
                            <x-input-field name="empresa" value="{{ auth()->user()->name }}" readonly required />
                        </div>
                        <div>
                            <label for="ubicacion" class="block text-gray-700 font-bold mb-2">
                                <i class="fas fa-map-marker-alt"></i> Ubicación
                            </label>
                            <x-input-field name="ubicacion" placeholder="Ciudad, País" required />
                        </div>
                        <div>
                            <label for="salario" class="block text-gray-700 font-bold mb-2">
                                <i class="fas fa-coins"></i> Salario
                            </label>
                            <x-input-field name="salario" placeholder="Ej: 1200" />
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700 border-b pb-2 mb-4 mt-6">Descripción y Requisitos
                    </h3>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="descripcion" class="block text-gray-700 font-bold mb-2">
                                <i class="fas fa-align-left"></i> Descripción del Trabajo
                            </label>
                            <x-textarea-field name="descripcion" placeholder="Describe la oferta laboral..."
                                rows="5" required />
                        </div>
                        <div>
                            <label for="requisitos" class="block text-gray-700 font-bold mb-2">
                                <i class="fas fa-tasks"></i> Requisitos
                            </label>
                            <x-textarea-field name="requisitos" placeholder="Ej: Experiencia mínima de 2 años..." />
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700 border-b pb-2 mb-4 mt-6">Rubro y Imagen</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="rubro_id" class="block text-gray-700 font-bold mb-2">
                                <i class="fas fa-tags"></i> Rubro
                            </label>
                            <x-select-field name="rubro_id" required>
                                <option value="">Seleccione un rubro</option>
                                @foreach ($rubros as $rubro)
                                    <option value="{{ $rubro->id }}"
                                        {{ old('rubro_id') == $rubro->id ? 'selected' : '' }}>
                                        {{ $rubro->nombre }}
                                    </option>
                                @endforeach
                            </x-select-field>
                        </div>
                        <div>
                            <label for="nuevo_rubro" class="block text-gray-700 font-bold mb-2">
                                <i class="fas fa-plus-circle"></i> Crear Nuevo Rubro
                            </label>
                            <x-input-field id="nuevo_rubro" name="nuevo_rubro" placeholder="Ingrese un nuevo rubro" />
                            <button type="button" @click="addNewRubro"
                                class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded shadow-md hover:shadow-lg mt-2">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <div>
                            <label for="imagen" class="block text-gray-700 font-bold mb-2 flex items-center">
                                <i class="fas fa-image mr-2"></i> Imagen de la Oferta
                            </label>
                            <div class="flex items-center space-x-4">
                                <input id="imagen" name="imagen" type="file" accept="image/*"
                                       class="form-input rounded-md shadow-sm block w-full py-2 px-3 text-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
                                       onchange="previewImage(event)" />
                                <!-- Imagen de vista previa -->
                                <img id="preview" src="#" alt="Vista previa" class="hidden w-20 h-20 rounded-md object-cover border border-gray-300" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="limite_postulantes">Límite de Postulantes</label>
                            <input type="number" name="limite_postulantes" id="limite_postulantes" class="form-control" value="{{ old('limite_postulantes', $oferta->limite_postulantes ?? '') }}" placeholder="Especifica el límite de postulantes">
                        </div>

                    </div>
                    <h3 class="text-xl font-semibold text-gray-700 border-b pb-2 mb-4 mt-6">Horario de Trabajo</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="dia_inicio" class="block text-gray-700 font-bold mb-2">
                                <i class="fas fa-calendar-day"></i> Día de Inicio
                            </label>
                            <x-select-field name="dia_inicio" required>
                                <option value="">Seleccione el día de inicio</option>
                                <option value="lunes">Lunes</option>
                                <option value="martes">Martes</option>
                                <option value="miércoles">Miércoles</option>
                                <option value="jueves">Jueves</option>
                                <option value="viernes">Viernes</option>
                                <option value="sábado">Sábado</option>
                                <option value="domingo">Domingo</option>
                            </x-select-field>
                        </div>
                        <div>
                            <label for="dia_fin" class="block text-gray-700 font-bold mb-2">
                                <i class="fas fa-calendar-check"></i> Día de Fin
                            </label>
                            <x-select-field name="dia_fin" required>
                                <option value="">Seleccione el día de fin</option>
                                <option value="lunes">Lunes</option>
                                <option value="martes">Martes</option>
                                <option value="miércoles">Miércoles</option>
                                <option value="jueves">Jueves</option>
                                <option value="viernes">Viernes</option>
                                <option value="sábado">Sábado</option>
                                <option value="domingo">Domingo</option>
                            </x-select-field>
                        </div>
                        <div class="mb-4">
                            <label for="hora_inicio" class="block text-gray-700 font-bold mb-2 flex items-center">
                                <i class="fas fa-clock mr-2"></i> Hora de Inicio
                            </label>
                            <div class="relative">
                                <input id="hora_inicio" name="hora_inicio" type="text"
                                    class="form-input rounded-md shadow-sm w-full py-2 px-3 pl-10 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
                                    placeholder="Seleccione la hora de inicio" required />
                                <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                    <i class="fas fa-clock text-gray-400"></i>
                                </span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="hora_fin" class="block text-gray-700 font-bold mb-2 flex items-center">
                                <i class="fas fa-clock mr-2"></i> Hora de Fin
                            </label>
                            <div class="relative">
                                <input id="hora_fin" name="hora_fin" type="text"
                                    class="form-input rounded-md shadow-sm w-full py-2 px-3 pl-10 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
                                    placeholder="Seleccione la hora de fin" required />
                                <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                    <i class="fas fa-clock text-gray-400"></i>
                                </span>
                            </div>
                        </div>

                    </div>
                    <div class="flex space-x-4">
                        <!-- Fecha de Inicio -->
                        <div class="w-1/2">
                            <label for="fecha_inicio" class="block text-gray-700 font-bold mb-2 flex items-center">
                                <i class="fas fa-calendar-alt mr-2"></i> Fecha de Inicio de la Oferta
                            </label>
                            <div class="relative">
                                <input id="fecha_inicio" name="fecha_inicio" type="text"
                                    class="form-input rounded-md shadow-sm w-full py-2 px-3 pl-10 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
                                    placeholder="Seleccione la fecha de inicio" required />
                                <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar-alt text-gray-400"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Fecha Límite -->
                        <div class="w-1/2">
                            <label for="oferta_disponible_hasta" class="block text-gray-700 font-bold mb-2 flex items-center">
                                <i class="fas fa-calendar-alt mr-2"></i> Fecha Límite de la Oferta
                            </label>
                            <div class="relative">
                                <input id="oferta_disponible_hasta" name="oferta_disponible_hasta" type="text"
                                    class="form-input rounded-md shadow-sm w-full py-2 px-3 pl-10 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
                                    placeholder="Seleccione la fecha límite" required />
                                <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar-alt text-gray-400"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded shadow-lg hover:shadow-xl w-full md:w-auto">
                            <i class="fas fa-save"></i> Guardar Oferta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
       <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

       <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#hora_inicio", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true
            });


            flatpickr("#hora_fin", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true
            });

            flatpickr("#oferta_disponible_hasta", {
                dateFormat: "Y-m-d",
                locale: "es"
            });
            flatpickr("#fecha_inicio", {
                dateFormat: "Y-m-d",
                locale: "es"
            });

        });
        function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function () {
            const output = document.getElementById('preview');
            output.src = reader.result;
            output.classList.remove('hidden');  // Muestra la imagen de vista previa
        };
        reader.readAsDataURL(event.target.files[0]);  // Lee el archivo seleccionado
    }

        function ofertaForm() {
            return {
                addNewRubro() {
                    const nuevoRubroInput = document.getElementById('nuevo_rubro').value.trim();
                    if (nuevoRubroInput !== '') {
                        fetch('{{ route('rubros.store') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    nombre: nuevoRubroInput
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    const rubroSelect = document.getElementById('rubro_id');
                                    const option = document.createElement('option');
                                    option.value = data.rubro.id;
                                    option.text = data.rubro.nombre;
                                    rubroSelect.add(option);
                                    rubroSelect.value = data.rubro.id;
                                    document.getElementById('nuevo_rubro').value = '';

                                    Swal.fire({
                                        title: '¡Rubro creado!',
                                        text: `El rubro "${data.rubro.nombre}" ha sido agregado exitosamente.`,
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'No se pudo agregar el rubro. Inténtelo de nuevo.',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire({
                                    title: 'Error de conexión',
                                    text: 'Hubo un problema con la conexión. Inténtelo de nuevo más tarde.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            });
                    } else {
                        Swal.fire({
                            title: 'Campo vacío',
                            text: 'Por favor, ingrese un nombre para el nuevo rubro.',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            };
        }
    </script>

</x-app-layout>
