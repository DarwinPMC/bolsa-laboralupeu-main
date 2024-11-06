<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Detalle de la Oferta Laboral') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-6 lg:p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-4 bg-gray-50 rounded-lg shadow-md">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">
                            <i class="fas fa-briefcase"></i> {{ $oferta->titulo }}
                        </h3>
                        <div class="mb-2">
                            <span class="font-semibold text-gray-700"><i class="fas fa-building"></i> Empresa:</span>
                            {{ $oferta->empresa }}
                        </div>
                        <div class="mb-2">
                            <span class="font-semibold text-gray-700"><i class="fas fa-map-marker-alt"></i>
                                Ubicación:</span> {{ $oferta->ubicacion }}
                        </div>
                        <div class="mb-2">
                            <span class="font-semibold text-gray-700"><i class="fas fa-tags"></i> Rubro:</span>
                            {{ $oferta->rubro->nombre ?? 'No especificado' }}
                        </div>
                        <div class="mb-2">
                            <span class="font-semibold text-gray-700">
                                <i class="fas fa-coins"></i> Salario:
                            </span>
                            {{ $oferta->salario ? 'S/ ' . $oferta->salario : 'A convenir' }}
                        </div>
                        <div class="mb-2">
                            <span class="font-semibold text-gray-700"><i class="fas fa-user"></i> Limite de pustulantes:</span>
                            {{ $oferta->limite_postulantes ?? 'No especificado' }}
                        </div>

                        <div class="mb-2">
                            <span class="font-semibold text-gray-700"><i class="fas fa-calendar-day"></i> Publicado
                                el:</span> {{ $oferta->created_at->format('d F, Y') }}
                        </div>
                        @if ($oferta->updated_at != $oferta->created_at)
                            <div class="mb-2">
                                <span class="font-semibold text-gray-700"><i class="fas fa-sync-alt"></i> Última
                                    Actualización:</span> {{ $oferta->updated_at->format('d F, Y') }}
                            </div>
                        @endif
                    </div>

                    @if ($oferta->imagen)
                        <div class="p-4 bg-gray-50 rounded-lg shadow-md flex justify-center items-center">
                            <img src="{{ asset('storage/' . $oferta->imagen) }}" alt="Imagen de la oferta"
                                class="max-w-full h-48 object-cover rounded-lg shadow-md">
                        </div>
                    @endif
                </div>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-4 bg-white rounded-lg shadow-md">
                        <h4 class="font-semibold text-gray-700 mb-2"><i class="fas fa-align-left"></i> Descripción del
                            Trabajo:</h4>
                        <p class="text-gray-700 leading-relaxed">{{ $oferta->descripcion }}</p>
                    </div>


                    @if ($oferta->requisitos)
                        <div class="p-4 bg-white rounded-lg shadow-md">
                            <h4 class="font-semibold text-gray-700 mb-2"><i class="fas fa-tasks"></i> Requisitos:</h4>
                            <p class="text-gray-700 leading-relaxed">{{ $oferta->requisitos }}</p>
                        </div>
                    @endif

                </div>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-4 bg-white rounded-lg shadow-md">
                        <h4 class="font-semibold text-gray-700 mb-2"><i class="fas fa-clock"></i> Horario de Trabajo:
                        </h4>
                        <p class="text-gray-700 leading-relaxed">
                            <span class="font-semibold">Día de inicio:</span> {{ ucfirst($oferta->dia_inicio) }}<br>
                            <span class="font-semibold">Día de fin:</span> {{ ucfirst($oferta->dia_fin) }}<br>
                            <span class="font-semibold">Hora de inicio:</span> {{ $oferta->hora_inicio }}<br>
                            <span class="font-semibold">Hora de fin:</span> {{ $oferta->hora_fin }}
                        </p>
                    </div>
                </div>

                <div class="flex justify-center space-x-4 mt-8">
                    @role('postulante')
                        <div class="bg-white p-6 rounded-md shadow-md max-w-lg mx-auto">

                            <form id="postulation-form-{{ $oferta->id }}"
                                action="{{ route('ofertas.postular', $oferta->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="flex items-center justify-between">

                                    @if (Auth::user()->archivo_cv)
                                        <a href="{{ asset('storage/' . Auth::user()->archivo_cv) }}" target="_blank"
                                            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md shadow inline-flex items-center">
                                            <i class="fas fa-file-alt mr-2"></i> Ver CV
                                        </a>
                                    @else
                                        <div class="flex-1">
                                            <label for="archivo_cv" class="block text-gray-700 font-medium">Subir CV</label>
                                            <input type="file" name="archivo_cv" id="archivo_cv"
                                                class="border border-gray-300 rounded-md p-2 w-full" required>
                                            <small class="text-gray-500">Formatos: PDF, DOC, DOCX (máx. 2MB)</small>
                                        </div>
                                    @endif

                                    @if (!$haVencido)
                                        <button type="button"
                                            onclick="confirmarPostulacion({{ $oferta->id }}, '{{ $oferta->titulo }}')"
                                            class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded-md shadow ml-4">
                                            <i class="fas fa-paper-plane"></i> Postular
                                        </button>
                                    @else
                                        <button type="button" disabled
                                            class="bg-gray-400 text-white font-bold py-2 px-6 rounded-md shadow ml-4 cursor-not-allowed">
                                            <i class="fas fa-times-circle"></i> Oferta Vencida
                                        </button>
                                    @endif


                                </div>
                            </form>
                        </div>
                    @endrole

                    @role('empresa')
                        <a href="{{ route('ofertas.postulantes', $oferta->id) }}"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-full transition duration-300 ease-in-out transform hover:-translate-y-1">
                            <i class="fas fa-users"></i>
                        </a>
                    @endrole

                    @role('empresa')
                        <a href="{{ route('ofertas.edit', $oferta->id) }}"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-full transition duration-300 ease-in-out transform hover:-translate-y-1">
                            <i class="fas fa-edit"></i>
                        </a>
                    @endrole

                    @role('empresa')
                        <button type="button" data-url="{{ route('ofertas.destroy', $oferta->id) }}"
                            class="delete-button bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-full transition duration-300 ease-in-out transform hover:-translate-y-1">
                            <i class="fas fa-trash"></i>
                        </button>

                        <form id="delete-form-{{ $oferta->id }}" action="{{ route('ofertas.destroy', $oferta->id) }}"
                            method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endrole


                    @role('empresa')
                        <a href="{{ route('ofertas.index') }}"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-full transition duration-300 ease-in-out transform hover:-translate-y-1">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    @endrole

                    @role('postulante')
                        <div class="mt-4">
                            <a href="{{ route('buscar_oferta') }}"
                                class="inline-flex items-center bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-full transition-transform transform hover:-translate-y-1 duration-300">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>
                    @endrole


                </div>

            </div>
        </div>
    </div>
    @vite('resources/js/ofertas.js')

</x-app-layout>
