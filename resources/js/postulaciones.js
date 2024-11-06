// Función para confirmar la aceptación del postulante
function confirmarAceptar(postulacionId) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Aceptarás a este postulante. Esta acción no se puede deshacer.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, aceptar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('aceptar-form-' + postulacionId).submit();
        }
    });
}

function confirmarRechazar(postulacionId) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Rechazarás a este postulante. Esta acción no se puede deshacer.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, rechazar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('rechazar-form-' + postulacionId).submit();
        }
    });
}


function confirmDelete(postulacionId) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esta acción!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + postulacionId).submit();
        }
    });
}
