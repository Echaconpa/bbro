<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tareaje</title>
    <link rel="stylesheet" href="/bbro/public/css/tareaje.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
</head>

<body>
        
        <?php include 'view/sidebar.php'; ?><!-- Incluir la barra lateral de navegación -->
    <div class="main-content">
        <div class="top-bar">
            <!-- Barra superior con búsqueda y avatar del usuario -->
            <div class="search-bar">
                <input type="text" placeholder="Buscar...">
            </div>
            <div class="user-info">
                <img src="/bbro/public/img/user-avatar.png" alt="User Avatar" class="user-avatar">
                <?php $username = $username ?? 'Invitado'; ?>
                <span><?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?></span>
            </div>
        </div>

        <div class="content">
            <h1>Sistema de Gestión del Centro de Operaciones y Control (SGCOC)</h1>

            <div class="top-controls">
                <!-- Filtros de selección de unidad, año y mes -->
                <div class="select-filters">
                    <div class="select-unit">
                        <label for="units">Unidad:</label>
                        <select id="units" onchange="filterByUnit()">
                            <option value="">Todas las unidades</option>
                            <?php foreach ($unidades as $unidad): ?>
                                <option value="<?php echo $unidad['id']; ?>" <?php echo isset($_GET['unidad_id']) && $_GET['unidad_id'] == $unidad['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($unidad['razon_social'], ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="select-date">
                        <label for="year">Año:</label>
                        <select id="year" onchange="updateDays()">
                            <option value="2024">2024</option>
                            <option value="2023">2023</option>
                            <option value="2022">2022</option>
                        </select>
                        <label for="month">Mes:</label>
                        <select id="month" onchange="updateDays()">
                            <option value="0">Enero</option>
                            <option value="1">Febrero</option>
                            <option value="2">Marzo</option>
                            <option value="3">Abril</option>
                            <option value="4">Mayo</option>
                            <option value="5">Junio</option>
                            <option value="6">Julio</option>
                            <option value="7">Agosto</option>
                            <option value="8">Septiembre</option>
                            <option value="9">Octubre</option>
                            <option value="10">Noviembre</option>
                            <option value="11">Diciembre</option>
                        </select>
                    </div>
                </div>

                <!-- Botones de tareaje y exportación a Excel -->
                <div class="button-container">
                    <button class="asistencia-button">TAREAJE</button>
                    <button class="asistencia-button" id="exportExcelBtn">
                        <img src="/bbro/public/img/excel-icon.png" alt="Excel Icon" style="width: 20px; margin-right: 5px;">
                        Exportar a Excel
                    </button>
                </div>
            </div>

            <!-- Contenedor de la leyenda -->
            <div class="legend-container">
                <h3>Leyenda</h3>
                <div class="legend-scroll">
                    <table class="legend-table">
                        <?php foreach ($abreviaturas as $abreviatura): ?>
                            <tr>
                                <td class="<?php echo htmlspecialchars($abreviatura['color_class'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <?php echo htmlspecialchars($abreviatura['codigo'], ENT_QUOTES, 'UTF-8'); ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($abreviatura['descripcion'], ENT_QUOTES, 'UTF-8'); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>

            <div class="table-container">
                <!-- Tabla de tareaje donde se mostrará la información del personal y las abreviaturas para cada día -->
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>PERSONAL</th>
                            <th>DNI</th>
                            <!-- Generar las columnas de días dinámicamente -->
                            <?php foreach ($days_in_month as $day): ?>
                                <th><?php echo $day; ?></th>
                            <?php endforeach; ?>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody id="personales-tbody">
                        <!-- Mostrar el personal y las abreviaturas -->
                        <?php foreach ($personales as $personal): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($personal['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($personal['nombres'] . ' ' . $personal['apellidos'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($personal['dni'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <!-- Generar selects para cada día -->
                                <?php foreach ($days_in_month as $day): ?>
                                    <td>
                                        <select name="abreviatura_<?php echo $personal['id']; ?>_<?php echo $day; ?>" class="tareaje-select">
                                            <option>-</option>
                                            <?php foreach ($abreviaturas as $abreviatura): ?>
                                                <option class="<?php echo htmlspecialchars($abreviatura['color_class'], ENT_QUOTES, 'UTF-8'); ?>">
                                                    <?php echo htmlspecialchars($abreviatura['codigo'], ENT_QUOTES, 'UTF-8'); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>

                                <?php endforeach; ?>
                                <td>
                                    <!-- Campo para ingresar observaciones -->
                                    <input type="text" name="observaciones_<?php echo $personal['id']; ?>" placeholder="Observaciones">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Script para exportar a Excel -->
    <script src="/bbro/public/js/tareaje.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.getElementById('exportExcelBtn').addEventListener('click', function() {
            var table = document.querySelector('table');
            var workbook = XLSX.utils.book_new();
            var worksheet = XLSX.utils.table_to_sheet(table);
            XLSX.utils.book_append_sheet(workbook, worksheet, 'Tareaje');
            XLSX.writeFile(workbook, 'tareaje_export.xlsx');
        });

        function filterByUnit() {
            const unitId = document.getElementById('units').value;
            const url = `/bbro/tareaje?unidad_id=${unitId}`;
            window.location.href = url;
        }
    </script>

</body>

</html>