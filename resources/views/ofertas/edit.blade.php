<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Oferta Laboral') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md sm:rounded-lg p-6 lg:p-8 space-y-6">
                <form action="{{ route('ofertas.update', $oferta->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <h3 class="text-xl font-semibold text-gray-700 border-b pb-2 mb-4">Información Básica</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="titulo" class="block text-gray-700 font-bold mb-2">Título de la Oferta</label>
                            <input type="text" name="titulo" value="{{ old('titulo', $oferta->titulo) }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <div>
                            <label for="empresa" class="block text-gray-700 font-bold mb-2">Empresa</label>
                            <input type="text" name="empresa" value="{{ old('empresa', $oferta->empresa) }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <div>
                            <label for="ubicacion" class="block text-gray-700 font-bold mb-2">Ubicación</label>
                            <input type="text" name="ubicacion" value="{{ old('ubicacion', $oferta->ubicacion) }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <div>
                            <label for="salario" class="block text-gray-700 font-bold mb-2">Salario</label>
                            <input type="text" name="salario" value="{{ old('salario', $oferta->salario) }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold text-gray-700 border-b pb-2 mb-4 mt-6">Descripción y Requisitos</h3>

                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="descripcion" class="block text-gray-700 font-bold mb-2">Descripción del Trabajo</label>
                            <textarea name="descripcion" rows="5" class="w-full border-gray-300 rounded-md shadow-sm" required>
                                {{ old('descripcion', $oferta->descripcion) }}
                            </textarea>
                        </div>

                        <div>
                            <label for="requisitos" class="block text-gray-700 font-bold mb-2">Requisitos</label>
                            <textarea name="requisitos" rows="5" class="w-full border-gray-300 rounded-md shadow-sm">
                                {{ old('requisitos', $oferta->requisitos) }}
                            </textarea>
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold text-gray-700 border-b pb-2 mb-4 mt-6">Rubro e Imagen</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="rubro_id" class="block text-gray-700 font-bold mb-2">Rubro</label>
                            <select name="rubro_id" class="w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">Seleccione un rubro</option>
                                @foreach ($rubros as $rubro)
                                    <option value="{{ $rubro->id }}"
                                        {{ old('rubro_id', $oferta->rubro_id) == $rubro->id ? 'selected' : '' }}>
                                        {{ $rubro->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="nuevo_rubro" class="block text-gray-700 font-bold mb-2">Crear Nuevo Rubro</label>
                            <input type="text" name="nuevo_rubro" value="{{ old('nuevo_rubro') }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label for="imagen" class="block text-gray-700 font-bold mb-2">Imagen de la Oferta</label>
                            <input type="file" name="imagen" class="w-full border-gray-300 rounded-md shadow-sm">
                            @if ($oferta->imagen)
                                <img src="{{ asset('storage/' . $oferta->imagen) }}" alt="Imagen de la oferta" class="mt-2 w-16 h-16">
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="limite_postulantes">Límite de Postulantes</label>
                            <input type="number" name="limite_postulantes" id="limite_postulantes" class="form-control" value="{{ old('limite_postulantes', $oferta->limite_postulantes ?? '') }}" placeholder="Especifica el límite de postulantes">
                        </div>

                    </div>

                    <h3 class="text-xl font-semibold text-gray-700 border-b pb-2 mb-4 mt-6">Horario de Trabajo</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="dia_inicio" class="block text-gray-700 font-bold mb-2">Día de Inicio</label>
                            <select name="dia_inicio" class="w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="lunes" {{ old('dia_inicio', $oferta->dia_inicio) == 'lunes' ? 'selected' : '' }}>Lunes</option>
                            </select>
                        </div>

                        <div>
                            <label for="dia_fin" class="block text-gray-700 font-bold mb-2">Día de Fin</label>
                            <select name="dia_fin" class="w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="lunes" {{ old('dia_fin', $oferta->dia_fin) == 'lunes' ? 'selected' : '' }}>Lunes</option>
                            </select>
                        </div>

                        <div>
                            <label for="hora_inicio" class="block text-gray-700 font-bold mb-2">Hora de Inicio</label>
                            <input type="text" name="hora_inicio" id="hora_inicio" value="{{ old('hora_inicio', $oferta->hora_inicio) }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <div>
                            <label for="hora_fin" class="block text-gray-700 font-bold mb-2">Hora de Fin</label>
                            <input type="text" name="hora_fin" id="hora_fin" value="{{ old('hora_fin', $oferta->hora_fin) }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                    </div>
                    <div class="mt-6">
                        <label for="fecha_inicio" class="block text-gray-700 font-bold mb-2">fecha de inicio</label>
                        <input type="text" name="fecha_inicio" id="fecha_inicio" value="{{ old('fecha_inicio', $oferta->fecha_inicio) }}"
                               class="w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mt-6">
                        <label for="oferta_disponible_hasta" class="block text-gray-700 font-bold mb-2">Fecha Límite de la Oferta</label>
                        <input type="text" name="oferta_disponible_hasta" id="oferta_disponible_hasta" value="{{ old('oferta_disponible_hasta', $oferta->oferta_disponible_hasta) }}"
                               class="w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded shadow-lg hover:shadow-xl">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
                locale: "es",
                enableTime: false,
                allowInput: true
            });
            flatpickr("#fecha_inicio", {
                dateFormat: "Y-m-d",
                locale: "es",
                enableTime: false,
                allowInput: true
            });
        });
    </script>


</x-app-layout>
