document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.delete-button');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const url = this.getAttribute('data-url'); // Obtener la URL de eliminación
            const offerId = url.split('/').pop(); // Extraer el ID de la oferta desde la URL

            if (!offerId) {
                console.error('ID de oferta no encontrado');
                return;
            }

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
                    const form = document.getElementById('delete-form-' + offerId);
                    if (form) {
                        form.submit(); // Enviar el formulario de eliminación
                    } else {
                        console.error('Formulario de eliminación no encontrado');
                    }
                }
            });
        });
    });
});


window.abrirCambioFecha = function(ofertaId, fechaActual) {
    Swal.fire({
        title: 'Cambiar fecha de vencimiento',
        html: `
            <label for="oferta_disponible_hasta" class="block text-sm font-medium text-gray-700">Nueva Fecha de Vencimiento</label>
            <input type="date" id="oferta_disponible_hasta" class="swal2-input" value="${fechaActual}">
        `,
        showCancelButton: true,
        confirmButtonText: 'Guardar',
        cancelButtonText: 'Cancelar',
        focusConfirm: false,
        preConfirm: () => {
            const nuevaFecha = document.getElementById('oferta_disponible_hasta').value;
            if (!nuevaFecha) {
                Swal.showValidationMessage('Debes seleccionar una fecha');
            }
            return nuevaFecha;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Deseas actualizar la fecha de vencimiento?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, actualizar',
                cancelButtonText: 'Cancelar'
            }).then((confirmResult) => {
                if (confirmResult.isConfirmed) {
                    window.cambiarFechaOferta(ofertaId, result.value);
                }
            });
        }
    });
};

window.cambiarFechaOferta = function(ofertaId, nuevaFecha) {
    fetch(`/ofertas/${ofertaId}/cambiar-fecha`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            oferta_disponible_hasta: nuevaFecha
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            Swal.fire('Actualizado', 'La fecha de vencimiento ha sido actualizada.', 'success')
            .then(() => {
                location.reload();
            });
        } else {
            Swal.fire('Error', 'Hubo un problema al actualizar la fecha.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'Ocurrió un error al procesar la solicitud.', 'error');
    });
};

window.confirmarPostulacion = function(ofertaId, ofertaTitulo) {
    Swal.fire({
        title: '¿Deseas postularte?',
        text: `Estás a punto de postularte a la oferta "${ofertaTitulo}". ¿Estás seguro de continuar?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, postularme',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('postulation-form-' + ofertaId);

            if (form) {
                form.submit();
            } else {
                console.error('Formulario de postulación no encontrado. Asegúrate de que el formulario tiene el ID correcto.');
            }
        }
    });
};

window.deleteOffer = function(offerId) {
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
            const form = document.getElementById('delete-form-' + offerId);

            if (form) {
                form.submit();
            } else {
                console.error('Formulario de eliminación no encontrado');
            }
        }
    });
};
