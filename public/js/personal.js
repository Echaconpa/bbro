document.addEventListener('DOMContentLoaded', function () {
    initializeDataTable();
    setupEventListeners();
});

// Inicializar DataTables para manejar la tabla de personal
function initializeDataTable() {
    $('#tablaPersonal').DataTable();
}

// Configurar eventos para manejar acciones en los botones y formularios
function setupEventListeners() {
    const nuevoRegistroBtn = document.querySelector('#nuevo-registro-btn');
    const modal = document.querySelector('#personal-modal');
    const closeModalBtn = document.querySelector('#close-modal');
    const form = document.querySelector('#personal-form');
    const editButtons = document.querySelectorAll('.edit-button');
    const deleteButtons = document.querySelectorAll('.delete-button');
    const viewButtons = document.querySelectorAll('.view-button');
    const viewModal = document.getElementById('personal-view-modal');
    const closeViewModalBtn = document.getElementById('close-view-modal');
    const userDropdown = document.getElementById("userDropdown");
    const dropdownMenu = document.getElementById("dropdownMenu");
    const asignarUnidadBtn = document.querySelector('#asignar-unidad-btn'); // Nuevo botón Asignar Unidad
    const asignarModal = document.querySelector('#asignar-unidad-modal');  // Modal de Asignar Unidad
    const closeAsignarModalBtn = document.querySelector('#close-asignar-modal');
    const asignarForm = document.querySelector('#asignar-unidad-form'); // Formulario de Asignar Unidad
    let selectedPersonalId = null; // Variable para almacenar el ID del personal seleccionado
    let selectedRow = null; // Variable para almacenar la fila seleccionada

    userDropdown.addEventListener("click", function () {
        dropdownMenu.classList.toggle("show"); // Mostrar/ocultar el menú desplegable
      });
    
      document.addEventListener("click", function (event) {
        if (!userDropdown.contains(event.target)) {
          dropdownMenu.classList.remove("show"); // Ocultar el menú si se hace clic fuera
        }
      });

    // Abrir modal para nuevo registro
    if (nuevoRegistroBtn) {
        nuevoRegistroBtn.addEventListener('click', function () {
            form.reset();
            document.querySelector('#personal-id').value = '';
            showModal(modal);
        });
    }

    // Manejar la selección de filas en la tabla
    const rows = document.querySelectorAll('#tablaPersonal tbody tr');
    rows.forEach(row => {
        row.addEventListener('click', function() {
            // Remover la clase 'selected' de la fila previamente seleccionada, si existe
            if (selectedRow) {
                selectedRow.classList.remove('selected');
            }

            // Agregar la clase 'selected' a la fila actual
            this.classList.add('selected');
            selectedRow = this;
        });
    });

    // Abrir modal para asignar unidad
    if (asignarUnidadBtn) {
        asignarUnidadBtn.addEventListener('click', function () {
            const selectedRow = document.querySelector('tr.selected'); // Obtener la fila seleccionada
            if (selectedRow) {
                selectedPersonalId = selectedRow.getAttribute('data-id'); // Obtener el ID del personal
                if (!selectedPersonalId) {
                    alert('ID del personal no encontrado. Seleccione una fila válida.');
                    return;
                }
                document.querySelector('#personal-id-asignar').value = selectedPersonalId; // Asignar el ID oculto
                showModal(asignarModal); // Mostrar el modal de asignación
            } else {
                alert('Seleccione un personal para asignar una unidad.');
            }
        });
    }

    // Cerrar modal de asignación
    if (closeAsignarModalBtn) {
        closeAsignarModalBtn.addEventListener('click', function () {
            closeModal(asignarModal);
        });
    }

// Enviar el formulario para asignar la unidad al personal
asignarForm.addEventListener('submit', function (event) {
    event.preventDefault();
    const formData = new FormData(asignarForm);
    formData.append('personal_id', selectedPersonalId);

    fetch('/bbro/asignarUnidad', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: '¡Éxito!',
                text: data.message || 'Unidad asignada correctamente.',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                closeModal(asignarModal);
                location.reload();
            });
        } else {
            Swal.fire({
                title: 'Error',
                text: data.message || 'No se pudo asignar la unidad.',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: 'Error',
            text: 'Hubo un problema al asignar la unidad.',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    });
});



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

    // Manejar la edición de personal
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const personalId = this.dataset.id;
            fetchPersonalData(personalId, modal, form);
        });
    });

    // Manejar la visualización de personal
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const personalId = this.dataset.id;
            fetchPersonalDataForView(personalId, viewModal);
        });
    });

    // Manejar el envío del formulario para guardar o actualizar personal
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        savePersonalData(form, modal);
    });

    // Manejar la eliminación de personal
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const personalId = this.dataset.id;
            deletePersonal(personalId);
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

// Obtener datos de un personal para edición
function fetchPersonalData(personalId, modal, form) {
    fetch(`/bbro/get_personal?id=${personalId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateFormWithData(data.personal, form);
                showModal(modal);
            } else {
                alert(data.message || 'Error al cargar los datos del personal');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un problema al cargar los datos del personal.');
        });
}

// Obtener los datos del personal para visualización
function fetchPersonalDataForView(personalId, modal) {
    fetch(`/bbro/get_personal?id=${personalId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateViewWithData(data.personal);
                showModal(modal);
            } else {
                alert(data.message || 'Error al cargar los datos del personal');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un problema al cargar los datos del personal.');
        });
}

// Llenar el formulario con los datos del personal
function populateFormWithData(personal, form) {
    document.querySelector('#personal-id').value = personal.id;
    document.querySelector('#personal-nombres').value = personal.nombres;
    document.querySelector('#personal-apellidos').value = personal.apellidos;
    document.querySelector('#personal-dni').value = personal.dni;
    document.querySelector('#personal-estado_civil').value = personal.estado_civil;
    document.querySelector('#personal-telefono_personal').value = personal.telefono_personal;
    document.querySelector('#personal-direccion').value = personal.direccion;
    document.querySelector('#personal-telefono_contacto').value = personal.telefono_contacto;
    document.querySelector('#personal-hijos').value = personal.hijos;
    document.querySelector('#personal-curso_sucamec').value = personal.curso_sucamec;
    document.querySelector('#personal-fecha_nacimiento').value = personal.fecha_nacimiento;
    document.querySelector('#personal-fecha_ingreso_bb').value = personal.fecha_ingreso_bb;
    document.querySelector('#personal-cargo').value = personal.cargo;
    document.querySelector('#personal-observaciones').value = personal.observaciones;
}

// Llenar el modal de visualización con los datos del personal
function populateViewWithData(personal) {
    document.getElementById('personal-photo-modal').src = "/bbro/public/img/personal/" + personal.foto;
    document.getElementById('personal-name-modal').innerText = personal.nombres + " " + personal.apellidos;
    document.getElementById('personal-dni-modal').innerText = personal.dni;
    document.getElementById('personal-estado-modal').innerText = personal.estado_civil;
    document.getElementById('personal-telefono-modal').innerText = personal.telefono_personal;
    document.getElementById('personal-direccion-modal').innerText = personal.direccion;
    document.getElementById('personal-contacto-modal').innerText = personal.telefono_contacto;
    document.getElementById('personal-hijos-modal').innerText = personal.hijos;
    document.getElementById('personal-sucamec-modal').innerText = personal.curso_sucamec;
    document.getElementById('personal-nacimiento-modal').innerText = personal.fecha_nacimiento;
    document.getElementById('personal-ingreso-modal').innerText = personal.fecha_ingreso_bb;
    document.getElementById('personal-cargo-modal').innerText = personal.cargo;
    document.getElementById('personal-observaciones-modal').innerText = personal.observaciones;
}

// Guardar los datos del personal (crear o actualizar)
function savePersonalData(form, modal) {
    const formData = new FormData(form);
    const actionUrl = form.querySelector('#personal-id').value ? '/bbro/updatePersonal' : '/bbro/addPersonal';

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
            alert('Error al guardar los datos del personal');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Hubo un problema al guardar los datos del personal.');
    });
}

// Asignar una unidad al personal
function assignUnitToPersonal(form) {
    const formData = new FormData(form);

    fetch('/bbro/asignarUnidad', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Unidad asignada correctamente');
            location.reload();
        } else {
            alert(data.message || 'Error al asignar la unidad');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Hubo un problema al asignar la unidad.');
    });
}

// Eliminar un personal
function deletePersonal(personalId) {
    if (confirm('¿Estás seguro de que deseas eliminar este registro?')) {
        fetch(`/bbro/deletePersonal`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                id: personalId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Error al eliminar el personal');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un problema al eliminar el personal.');
        });
    }
}
