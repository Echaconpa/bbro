<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimiento de Personal</title>
    <link rel="stylesheet" href="/bbro/public/css/dashboard.css">
    <link rel="stylesheet" href="/bbro/public/css/personal.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <?php include 'view/sidebar.php'; ?>
    <div class="main-content">
        <div class="top-bar">
            <div class="user-info">
                <img src="/bbro/public/img/user-avatar.png" alt="User Avatar" class="user-avatar" id="userDropdown">
                <?php $username = $username ?? 'Invitado'; ?>
                <span id="userDropdown"><?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?></span>
                <div class="dropdown-menu" id="dropdownMenu">
                    <a href="/bbro/logout">Cerrar Sesión</a>
                </div>
            </div>
        </div>
        <div class="content">
            <h1>Mantenimiento de Personal</h1>
            <div class="button-container">
                <button id="nuevo-registro-btn" class="asistencia-button">Nuevo Registro</button>
                <button id="asignar-unidad-btn" class="asignar-unidad-button">Asignar Unidad</button>
                <button id="registro-sucamec-btn" class="sucamec-button">Registro SUCAMEC</button>
            </div>
            <div class="table-container">
                <table id="tablaPersonal" class="display">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>DNI</th>
                            <th>Estado Civil</th>
                            <th>Tel. Personal</th>
                            <th>Dirección</th>
                            <th>Tel. Contacto</th>
                            <th>Hijos</th>
                            <th>Curso SUCAMEC</th>
                            <th>F. de Nacimiento</th>
                            <th>F. de Ingreso BB</th>
                            <th>Cargo</th>
                            <th>Observaciones</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($personales as $personal): ?>
                            <tr data-id="<?php echo htmlspecialchars($personal['id'], ENT_QUOTES, 'UTF-8'); ?>">
                                <td><?php echo htmlspecialchars($personal['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($personal['nombres'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($personal['apellidos'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($personal['dni'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($personal['estado_civil'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($personal['telefono_personal'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($personal['direccion'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($personal['telefono_contacto'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($personal['hijos'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($personal['curso_sucamec'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($personal['fecha_nacimiento'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($personal['fecha_ingreso_bb'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($personal['cargo'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($personal['observaciones'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <button class="action-button edit-button" data-id="<?php echo $personal['id']; ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="action-button delete-button" data-id="<?php echo $personal['id']; ?>">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <button class="action-button view-button" data-id="<?php echo $personal['id']; ?>">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal de nuevo registro -->
        <div id="personal-modal" class="modal">
            <div class="modal-content">
                <span id="close-modal" class="close">&times;</span>
                <form id="personal-form" method="post" enctype="multipart/form-data" action="/bbro/addPersonal">
                    <h2>Nuevo Registro de Personal</h2>
                    <input type="hidden" name="id" id="personal-id">
                    <!-- Formulario -->
                    <label for="nombres">Nombres</label>
                    <input type="text" name="nombres" id="personal-nombres" required>

                    <label for="apellidos">Apellidos</label>
                    <input type="text" name="apellidos" id="personal-apellidos" required>

                    <label for="dni">DNI</label>
                    <input type="text" name="dni" id="personal-dni" required>

                    <label for="estado_civil">Estado Civil</label>
                    <input type="text" name="estado_civil" id="personal-estado_civil" required>

                    <label for="telefono_personal">Teléfono Personal</label>
                    <input type="text" name="telefono_personal" id="personal-telefono_personal" required>

                    <label for="direccion">Dirección</label>
                    <input type="text" name="direccion" id="personal-direccion" required>

                    <label for="telefono_contacto">Teléfono de Contacto</label>
                    <input type="text" name="telefono_contacto" id="personal-telefono_contacto">

                    <label for="hijos">Hijos</label>
                    <input type="text" name="hijos" id="personal-hijos">

                    <label for="curso_sucamec">Curso SUCAMEC</label>
                    <select name="curso_sucamec" id="personal-curso_sucamec">
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>

                    <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                    <input type="date" name="fecha_nacimiento" id="personal-fecha_nacimiento" required>

                    <label for="fecha_ingreso_bb">Fecha de Ingreso BB</label>
                    <input type="date" name="fecha_ingreso_bb" id="personal-fecha_ingreso_bb" required>

                    <label for="cargo">Cargo</label>
                    <input type="text" name="cargo" id="personal-cargo" required>

                    <label for="observaciones">Observaciones</label>
                    <textarea name="observaciones" id="personal-observaciones"></textarea>

                    <label for="foto">Foto</label>
                    <input type="file" name="foto_personal" id="personal-foto">

                    <button type="submit">Guardar</button>
                </form>
            </div>
        </div>

        <!-- Modal para asignar unidad -->
        <div id="asignar-unidad-modal" class="modal">
            <div class="modal-content">
                <span id="close-asignar-modal" class="close">&times;</span>
                <h2>Asignar Unidad</h2>
                <form id="asignar-unidad-form">
                    <input type="hidden" id="personal-id-asignar" name="personal_id"> <!-- Campo oculto para el ID del personal -->
                    <label for="unidad">Seleccionar Unidad:</label>
                    <select id="unidad" name="unidad">
                        <?php foreach ($unidades as $unidad): ?>
                            <option value="<?php echo htmlspecialchars($unidad['id'], ENT_QUOTES, 'UTF-8'); ?>">
                                <?php echo htmlspecialchars($unidad['razon_social'], ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit">Asignar</button>
                </form>
            </div>
        </div>

        <!-- Modal de visualización de personal -->
        <div id="personal-view-modal" class="modal">
            <div class="modal-content">
                <span id="close-view-modal" class="close">&times;</span>
                <div class="card-container">
                    <div class="card">
                        <img src="/bbro/public/img/personal/<?php echo htmlspecialchars($personal['foto'], ENT_QUOTES, 'UTF-8'); ?>" alt="Foto del Personal" class="personal-photo" id="personal-photo-modal">
                        <div class="card-content">
                            <h2 id="personal-name-modal">Nombre del Personal</h2>
                            <p><strong>DNI:</strong> <span id="personal-dni-modal"></span></p>
                            <p><strong>Estado Civil:</strong> <span id="personal-estado-modal"></span></p>
                            <p><strong>Teléfono Personal:</strong> <span id="personal-telefono-modal"></span></p>
                            <p><strong>Dirección:</strong> <span id="personal-direccion-modal"></span></p>
                            <p><strong>Teléfono de Contacto:</strong> <span id="personal-contacto-modal"></span></p>
                            <p><strong>Hijos:</strong> <span id="personal-hijos-modal"></span></p>
                            <p><strong>Curso SUCAMEC:</strong> <span id="personal-sucamec-modal"></span></p>
                            <p><strong>Fecha de Nacimiento:</strong> <span id="personal-nacimiento-modal"></span></p>
                            <p><strong>Fecha de Ingreso Big Bro:</strong> <span id="personal-ingreso-modal"></span></p>
                            <p><strong>Cargo:</strong> <span id="personal-cargo-modal"></span></p>
                            <p><strong>Observaciones:</strong> <span id="personal-observaciones-modal"></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para SUCAMEC -->
        <!-- Modal para registro de SUCAMEC -->
        <div id="registro-sucamec-modal" class="modal">
            <div class="modal-content">
                <span id="close-sucamec-modal" class="close">&times;</span>
                <h2>Registro SUCAMEC</h2>
                <form id="registro-sucamec-form">
                    <input type="hidden" id="personal-id-sucamec" name="personal_id"> <!-- Campo oculto para el ID del personal -->

                    <label for="emi_sucamec">Fecha de Emisión SUCAMEC:</label>
                    <input type="date" id="emi_sucamec" name="emi_sucamec" required>

                    <label for="cad_sucamec">Fecha de Caducidad SUCAMEC:</label>
                    <input type="date" id="cad_sucamec" name="cad_sucamec" required>

                    <button type="submit">Guardar</button>
                </form>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        <script src="/bbro/public/js/personal.js"></script>
</body>
</html>