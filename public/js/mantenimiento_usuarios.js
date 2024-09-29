document.addEventListener("DOMContentLoaded", function () {
  initializeDataTable();
  setupEventListeners();
});

// Función para inicializar DataTables
function initializeDataTable() {
  $("#tablaUsuarios").DataTable();
}

// Configuración de los event listeners
function setupEventListeners() {
  const nuevoRegistroBtn = document.querySelector("#nuevo-registro-btn");
  const modal = document.querySelector("#usuario-modal");
  const closeModalBtn = document.querySelector("#close-modal");
  const form = document.querySelector("#usuario-form");
  const editButtons = document.querySelectorAll(".edit-button");
  const deleteButtons = document.querySelectorAll(".delete-button");
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

  // Abrir el formulario de "Nuevo Registro"
  nuevoRegistroBtn.addEventListener("click", function () {
    form.reset();
    document.querySelector("#usuario-id").value = "";
    showModal(modal);
  });

  // Cerrar el modal
  closeModalBtn.addEventListener("click", function () {
    closeModal(modal);
  });

  // Cerrar el modal si se hace clic fuera de él
  window.onclick = function (event) {
    if (event.target == modal) {
      closeModal(modal);
    }
  };

  // Manejar la edición de usuarios
  editButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const usuarioId = this.dataset.id;
      fetchUsuarioData(usuarioId, modal, form);
    });
  });

  // Manejar el envío del formulario
  form.addEventListener("submit", function (event) {
    event.preventDefault();
    saveUsuarioData(form, modal);
  });

  // Manejar la eliminación de usuarios
  deleteButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const usuarioId = this.dataset.id;
      deleteUsuario(usuarioId);
    });
  });
}

// Función para mostrar el modal
function showModal(modal) {
  modal.style.display = "block";
}

// Función para cerrar el modal
function closeModal(modal) {
  modal.style.display = "none";
}

// Función para obtener datos de un usuario para edición
function fetchUsuarioData(usuarioId, modal, form) {
  fetch(`/bbro/get_usuario?id=${usuarioId}`)
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        populateFormWithData(data.usuario, form);
        showModal(modal);
      } else {
        alert(data.message || "Error al cargar los datos del usuario");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("Hubo un problema al cargar los datos del usuario.");
    });
}

// Función para llenar el formulario con los datos obtenidos
function populateFormWithData(usuario, form) {
  document.querySelector("#usuario-id").value = usuario.id;
  document.querySelector("#usuario-dni").value = usuario.dni;
  document.querySelector("#usuario-nombre").value = usuario.nombre;
  document.querySelector("#usuario-apellido").value = usuario.apellido;
  document.querySelector("#usuario-nom").value = usuario.nombre_usuario;
  document.querySelector("#usuario-contrasena").value = ""; // No mostrar la contraseña
  document.querySelector("#usuario-correo").value = usuario.correo_electronico;
  document.querySelector("#usuario-telefono").value = usuario.telefono;
  document.querySelector("#usuario-rol").value = usuario.rol_id;
}

// Función para guardar los datos del usuario
function saveUsuarioData(form, modal) {
  const formData = new FormData(form);
  const actionUrl = form.querySelector("#usuario-id").value
    ? "/bbro/updateUsuario"
    : "/bbro/addUsuario";

  fetch(actionUrl, {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        window.location.reload();
      } else {
        alert("Error al guardar el usuario");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("Hubo un problema al enviar los datos.");
    });
}

// Función para eliminar un usuario (desactivarlo)
function deleteUsuario(usuarioId) {
  if (confirm("¿Estás seguro de que deseas eliminar este usuario?")) {
    fetch("/bbro/deleteUsuario", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams({
        id: usuarioId, // Enviar el ID en el cuerpo de la solicitud
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          window.location.reload(); // Recargar la página para ver los cambios
        } else {
          alert(data.message || "Error al eliminar el usuario");
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("Hubo un problema al eliminar el usuario.");
      });
  }
}
