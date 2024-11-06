<div id="invitarModal" class="fixed inset-0 hidden bg-gray-600 bg-opacity-75 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-1/2">
        <h3 id="modal-title" class="text-lg font-semibold mb-4">Invitar Postulantes</h3>

        <form id="form-invitar" action="{{ route('ofertas.invitar.postulantes', $oferta->id) }}" method="POST">
            @csrf

            <div id="search-section">
                <div class="mb-4">
                    <label for="search" class="block text-sm font-medium text-gray-700">Buscar postulantes por correo o nombre</label>
                    <input type="text" name="search" id="search" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Ingrese nombre o correo" oninput="buscarPostulantes()">
                </div>

                <div id="postulantes-dropdown" class="hidden bg-white border border-gray-300 rounded-md shadow-lg mt-2 w-full max-h-60 overflow-auto">
                </div>
            </div>

            <div id="confirmacion-section" class="hidden">
                <p class="text-md">¿Estás seguro de que deseas enviar las invitaciones a los postulantes seleccionados?</p>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="button" class="bg-gray-300 text-gray-700 font-bold px-4 py-2 rounded-md hover:bg-gray-400 mr-2" onclick="cerrarInvitarModal()">
                    Cancelar
                </button>
                <button type="button" id="confirmarButton" class="bg-indigo-600 text-white font-bold px-4 py-2 rounded-md hover:bg-indigo-700" onclick="mostrarConfirmacion()">
                    Enviar Invitaciones
                </button>
                <button type="submit" id="enviarFormularioButton" class="bg-red-600 text-white font-bold px-4 py-2 rounded-md hover:bg-red-700 hidden">
                    Confirmar Envío
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function abrirInvitarModal(ofertaId) {
    document.getElementById('invitarModal').classList.remove('hidden');
    document.getElementById('search-section').classList.remove('hidden');
    document.getElementById('confirmacion-section').classList.add('hidden');
    document.getElementById('confirmarButton').classList.remove('hidden');
    document.getElementById('enviarFormularioButton').classList.add('hidden');
    document.getElementById('modal-title').textContent = "Invitar Postulantes";
}

function cerrarInvitarModal() {
    document.getElementById('invitarModal').classList.add('hidden');
}

function mostrarConfirmacion() {
    document.getElementById('search-section').classList.add('hidden');
    document.getElementById('confirmacion-section').classList.remove('hidden');
    document.getElementById('confirmarButton').classList.add('hidden');
    document.getElementById('enviarFormularioButton').classList.remove('hidden');
    document.getElementById('modal-title').textContent = "Confirmación de Envío";
}

function buscarPostulantes() {
    let searchQuery = document.getElementById('search').value;

    if (searchQuery.length < 1) {
        document.getElementById('postulantes-dropdown').classList.add('hidden');
        return;
    }

    fetch(`/buscar-postulantes?search=${searchQuery}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        },
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la respuesta de la red');
        }
        return response.json();
    })
    .then(data => {
        let dropdown = document.getElementById('postulantes-dropdown');
        dropdown.innerHTML = '';

        if (data.length > 0) {
            data.forEach(postulante => {
                let div = document.createElement('div');
                div.classList.add('p-2', 'cursor-pointer', 'hover:bg-gray-200');
                div.textContent = `${postulante.name} (${postulante.email})`;
                div.onclick = function() {
                    seleccionarPostulante(postulante);
                };
                dropdown.appendChild(div);
            });
            dropdown.classList.remove('hidden');
        } else {
            dropdown.classList.add('hidden');
        }
    })
    .catch(error => console.error('Error:', error));
}

function seleccionarPostulante(postulante) {
    mostrarNotificacion(`Postulante seleccionado: ${postulante.name} (${postulante.email})`);

    const campoBusqueda = document.getElementById('search');
    campoBusqueda.value = postulante.name;


    const dropdown = document.getElementById('postulantes-dropdown');
    dropdown.classList.add('fade-out');
    setTimeout(() => {
        dropdown.classList.add('hidden');
        dropdown.classList.remove('fade-out');
    }, 300);
}

function mostrarNotificacion(mensaje) {
    const notificacion = document.createElement('div');
    notificacion.className = 'notificacion-exito';
    notificacion.innerText = mensaje;

    document.body.appendChild(notificacion);

    setTimeout(() => {
        notificacion.classList.add('fade-out');
        setTimeout(() => notificacion.remove(), 300);
    }, 3000);
}
</script>
