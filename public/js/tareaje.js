<<<<<<< HEAD
// public/js/tareaje.js
=======
document.addEventListener("DOMContentLoaded", function () {
    setupEventListeners();
  });

// Configuración de los event listeners
function setupEventListeners() {
    const userDropdown = document.getElementById("userDropdown");
    const dropdownMenu = document.getElementById("dropdownMenu");

    // Mostrar/ocultar el menú cuando se hace clic en el avatar
    userDropdown.addEventListener("click", function () {
        dropdownMenu.classList.toggle("show"); // Mostrar/ocultar el menú desplegable
    });

    document.addEventListener("click", function (event) {
        if (!userDropdown.contains(event.target)) {
          dropdownMenu.classList.remove("show"); // Ocultar el menú si se hace clic fuera
        }
  });

>>>>>>> 23ba4e6 (Primeros cambios)

// Función para actualizar los días en la tabla según el mes y el año seleccionado
function updateDays() {
    const year = document.getElementById('year').value; // Obtiene el valor seleccionado del año
    const month = document.getElementById('month').value; // Obtiene el valor seleccionado del mes
    const daysContainer = document.querySelector('thead tr'); // Selecciona el contenedor de los días (encabezado de la tabla)
    const days = new Date(year, parseInt(month) + 1, 0).getDate(); // Calcula cuántos días tiene el mes seleccionado
    const daysOfWeek = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb']; // Nombres de los días de la semana
<<<<<<< HEAD
    
=======

>>>>>>> 23ba4e6 (Primeros cambios)
    // Limpiar días existentes en el encabezado de la tabla
    daysContainer.innerHTML = `
        <th>ID</th>
        <th>PERSONAL</th>
        <th>DNI</th>
    `;
<<<<<<< HEAD
    
=======

>>>>>>> 23ba4e6 (Primeros cambios)
    // Agregar los nuevos días del mes seleccionado al encabezado
    for (let i = 1; i <= days; i++) {
        const dayOfWeek = daysOfWeek[new Date(year, month, i).getDay()]; // Determina el día de la semana para cada día del mes
        daysContainer.innerHTML += `<th>${i}<br>${dayOfWeek}</th>`; // Añade una columna por cada día del mes
    }

    // Agregar la columna de observaciones al final
    daysContainer.innerHTML += `<th>Observaciones</th>`;
}

// Función para filtrar los registros por unidad seleccionada
function filterByUnit() {
    const unitId = document.getElementById('units').value; // Obtiene el valor seleccionado del filtro de unidad
    const url = `/bbro/tareaje?unidad_id=${unitId}`; // Construye la URL con el parámetro de la unidad
    window.location.href = url; // Redirigir para mostrar la tabla filtrada por unidad
}

// Función para exportar la tabla visible a un archivo Excel utilizando SheetJS
<<<<<<< HEAD
document.getElementById('exportExcelBtn').addEventListener('click', function() {
=======
document.getElementById('exportExcelBtn').addEventListener('click', function () {
>>>>>>> 23ba4e6 (Primeros cambios)
    // Seleccionar la tabla HTML
    var table = document.querySelector('table');

    // Crear un nuevo libro de trabajo (workbook) en SheetJS
    var workbook = XLSX.utils.book_new();

    // Convertir la tabla a una hoja de cálculo
    var worksheet = XLSX.utils.table_to_sheet(table);

    // Añadir la hoja de cálculo al libro de trabajo
    XLSX.utils.book_append_sheet(workbook, worksheet, 'Tareaje');

    // Generar el archivo Excel y descargarlo
    XLSX.writeFile(workbook, 'tareaje_export.xlsx');
});

// Función para guardar los datos del tareaje (abreviaturas y observaciones)
function guardarTareaje() {
    // Crear un objeto para almacenar los datos del tareaje
    const tareajeData = [];

    // Obtener las filas del cuerpo de la tabla
    const filasPersonales = document.querySelectorAll('#personales-tbody tr');

    // Recorrer cada fila de personal
    filasPersonales.forEach(fila => {
        const personalId = fila.querySelector('td:first-child').innerText; // Obtener el ID del personal
        const observaciones = fila.querySelector('input[name^="observaciones_"]').value; // Obtener las observaciones

        // Crear un objeto para almacenar los datos del personal
        const personalTareaje = {
            personal_id: personalId,
            abreviaturas: [],
            observaciones: observaciones
        };

        // Recorrer los selects (uno por cada día del mes) para obtener las abreviaturas seleccionadas
        const selects = fila.querySelectorAll('select');
        selects.forEach((select, index) => {
            const dia = index + 1; // El día corresponde al índice + 1
            const abreviatura = select.value; // Obtener el valor de la abreviatura seleccionada
            personalTareaje.abreviaturas.push({ dia: dia, abreviatura: abreviatura });
        });

        // Añadir los datos del personal al arreglo tareajeData
        tareajeData.push(personalTareaje);
    });

    // Enviar los datos al servidor mediante una solicitud AJAX
    enviarDatosTareaje(tareajeData);
}

// Función para enviar los datos del tareaje al servidor mediante AJAX
function enviarDatosTareaje(tareajeData) {
    fetch('/bbro/tareaje/guardar', {
        method: 'POST', // Solicitud de tipo POST
        headers: {
            'Content-Type': 'application/json' // Indicar que los datos enviados son JSON
        },
        body: JSON.stringify(tareajeData) // Convertir los datos en una cadena JSON
    })
<<<<<<< HEAD
    .then(response => response.json()) // Procesar la respuesta como JSON
    .then(data => {
        if (data.success) {
            alert('Tareaje guardado exitosamente');
        } else {
            alert('Hubo un error al guardar el tareaje');
        }
    })
    .catch(error => {
        console.error('Error al guardar los datos de tareaje:', error);
    });
}

// Inicializar la tabla con el mes y año actual
window.onload = function() {
    updateDays(); // Actualizar los días del mes según el año y mes actual
};
=======
        .then(response => response.json()) // Procesar la respuesta como JSON
        .then(data => {
            if (data.success) {
                alert('Tareaje guardado exitosamente');
            } else {
                alert('Hubo un error al guardar el tareaje');
            }
        })
        .catch(error => {
            console.error('Error al guardar los datos de tareaje:', error);
        });
}

// Inicializar la tabla con el mes y año actual
window.onload = function () {
    updateDays(); // Actualizar los días del mes según el año y mes actual
};
}
>>>>>>> 23ba4e6 (Primeros cambios)
