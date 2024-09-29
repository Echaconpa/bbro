document.addEventListener('DOMContentLoaded', function () {
    initializeDataTable();
    setupEventListeners();
});

// Inicializar DataTables para manejar la tabla de unidades
function initializeDataTable() {
    $('#tablaUnidades').DataTable();
}

// Configurar eventos para manejar acciones en los botones y formularios
function setupEventListeners() {
    const nuevoRegistroBtn = document.querySelector('#nuevo-registro-btn');
    const modal = document.querySelector('#unidades-modal');
    const closeModalBtn = document.querySelector('#close-modal');
    const form = document.querySelector('#unidades-form');
    const editButtons = document.querySelectorAll('.edit-button');
    const deleteButtons = document.querySelectorAll('.delete-button');
    const viewButtons = document.querySelectorAll('.view-button');
    const viewModal = document.getElementById('unidad-view-modal');
    const closeViewModalBtn = document.getElementById('close-view-modal');
<<<<<<< HEAD

=======
    const userDropdown = document.getElementById("userDropdown");
    const dropdownMenu = document.getElementById("dropdownMenu");


    userDropdown.addEventListener("click", function () {
        dropdownMenu.classList.toggle("show"); // Mostrar/ocultar el menú desplegable
    });

    document.addEventListener("click", function (event) {
        if (!userDropdown.contains(event.target)) {
            dropdownMenu.classList.remove("show"); // Ocultar el menú si se hace clic fuera
        }
    });
>>>>>>> 23ba4e6 (Primeros cambios)
    // Abrir modal para nuevo registro
    if (nuevoRegistroBtn) {
        nuevoRegistroBtn.addEventListener('click', function () {
            form.reset();
            document.querySelector('#unidad-id').value = '';
            showModal(modal);
        });
    }

    // Cerrar modal de registro
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', function () {
            closeModal(modal);
        });
    }

    // Cerrar modal de visualización
    if (closeViewModalBtn) {
        closeViewModalBtn.addEventListener('click', function () {
            closeModal(viewModal);
        });
    }

    // Cerrar modal si se hace clic fuera de él
    window.onclick = function (event) {
        if (event.target === modal) {
            closeModal(modal);
        } else if (event.target === viewModal) {
            closeModal(viewModal);
        }
    };

    // Manejar la edición de una unidad
    editButtons.forEach(button => {
<<<<<<< HEAD
        button.addEventListener('click', function() {
=======
        button.addEventListener('click', function () {
>>>>>>> 23ba4e6 (Primeros cambios)
            const unidadId = this.dataset.id;
            fetchUnidadData(unidadId, modal, form);
        });
    });

    // Manejar la visualización de una unidad
    viewButtons.forEach(button => {
<<<<<<< HEAD
        button.addEventListener('click', function() {
=======
        button.addEventListener('click', function () {
>>>>>>> 23ba4e6 (Primeros cambios)
            const unidadId = this.dataset.id;
            fetchUnidadDataForView(unidadId, viewModal);
        });
    });

    // Manejar el envío del formulario para guardar o actualizar unidad
<<<<<<< HEAD
    form.addEventListener('submit', function(event) {
=======
    form.addEventListener('submit', function (event) {
>>>>>>> 23ba4e6 (Primeros cambios)
        event.preventDefault();
        saveUnidadData(form, modal);
    });

    // Manejar la eliminación de una unidad
    deleteButtons.forEach(button => {
<<<<<<< HEAD
        button.addEventListener('click', function() {
=======
        button.addEventListener('click', function () {
>>>>>>> 23ba4e6 (Primeros cambios)
            const unidadId = this.dataset.id;
            deleteUnidad(unidadId);
        });
    });
}

// Mostrar el modal
function showModal(modal) {
    modal.style.display = 'block';
}

// Cerrar el modal
function closeModal(modal) {
    modal.style.display = 'none';
}

// Obtener datos de una unidad para edición
function fetchUnidadData(unidadId, modal, form) {
    fetch(`/bbro/get_unidad?id=${unidadId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateFormWithData(data.unidad, form);
                showModal(modal);
            } else {
                alert(data.message || 'Error al cargar los datos de la unidad');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un problema al cargar los datos de la unidad.');
        });
}

// Obtener los datos de la unidad para visualización
function fetchUnidadDataForView(unidadId, modal) {
    fetch(`/bbro/get_unidad?id=${unidadId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateViewWithData(data.unidad);
                showModal(modal);
            } else {
                alert(data.message || 'Error al cargar los datos de la unidad');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un problema al cargar los datos de la unidad.');
        });
}

// Llenar el formulario con los datos de la unidad
function populateFormWithData(unidad, form) {
    document.querySelector('#unidad-id').value = unidad.id;
    document.querySelector('#unidad-razon_social').value = unidad.razon_social;
    document.querySelector('#unidad-ruc_dni').value = unidad.ruc_dni;
    document.querySelector('#unidad-direccion').value = unidad.direccion;
    document.querySelector('#unidad-rubro').value = unidad.rubro;
    document.querySelector('#unidad-encargado_seguridad').value = unidad.encargado_seguridad;
    document.querySelector('#unidad-telf_encargado').value = unidad.telf_encargado;
    document.querySelector('#unidad-fijo_encargado').value = unidad.fijo_encargado;
    document.querySelector('#unidad-segundo_contacto').value = unidad.segundo_contacto;
    document.querySelector('#unidad-telf_scontacto').value = unidad.telf_scontacto;
    document.querySelector('#unidad-fijo_scontacto').value = unidad.fijo_scontacto;
    document.querySelector('#unidad-puesto_vigilancia').value = unidad.puesto_vigilancia;
    document.querySelector('#unidad-comisaria').value = unidad.comisaria;
    document.querySelector('#unidad-serenazgo').value = unidad.serenazgo;
    document.querySelector('#unidad-bomberos').value = unidad.bomberos;
    document.querySelector('#unidad-samu').value = unidad.samu;
    document.querySelector('#unidad-observaciones').value = unidad.observaciones;
}

// Llenar el modal de visualización con los datos de la unidad
function populateViewWithData(unidad) {
    document.getElementById('unidad-photo-modal').src = "/bbro/public/img/unidades/" + unidad.foto;
    document.getElementById('unidad-name-modal').innerText = unidad.razon_social;
    document.getElementById('unidad-ruc-modal').innerText = unidad.ruc_dni;
    document.getElementById('unidad-direccion-modal').innerText = unidad.direccion;
    document.getElementById('unidad-rubro-modal').innerText = unidad.rubro;
    document.getElementById('unidad-encargado-modal').innerText = unidad.encargado_seguridad;
    document.getElementById('unidad-telf-encargado-modal').innerText = unidad.telf_encargado;
    document.getElementById('unidad-contacto-modal').innerText = unidad.segundo_contacto;
    document.getElementById('unidad-puesto-modal').innerText = unidad.puesto_vigilancia;
    document.getElementById('unidad-comisaria-modal').innerText = unidad.comisaria;
    document.getElementById('unidad-serenazgo-modal').innerText = unidad.serenazgo;
    document.getElementById('unidad-bomberos-modal').innerText = unidad.bomberos;
    document.getElementById('unidad-samu-modal').innerText = unidad.samu;
    document.getElementById('unidad-observaciones-modal').innerText = unidad.observaciones;
}

// Guardar los datos de la unidad (crear o actualizar)
function saveUnidadData(form, modal) {
    const formData = new FormData(form);
    const actionUrl = form.querySelector('#unidad-id').value ? '/bbro/updateUnidad' : '/bbro/addUnidad';

    fetch(actionUrl, {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeModal(modal);
                location.reload();
            } else {
                alert('Error al guardar los datos de la unidad');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un problema al guardar los datos de la unidad.');
        });
}

// Eliminar una unidad
function deleteUnidad(unidadId) {
    if (confirm('¿Estás seguro de que deseas eliminar esta unidad?')) {
        fetch(`/bbro/deleteUnidad`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                id: unidadId
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message || 'Error al eliminar la unidad');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Hubo un problema al eliminar la unidad.');
            });
    }
}
