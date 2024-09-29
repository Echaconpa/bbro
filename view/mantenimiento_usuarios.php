<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimiento de Usuarios</title>
    <link rel="stylesheet" href="/bbro/public/css/dashboard.css">
    <link rel="stylesheet" href="/bbro/public/css/mantenimiento_usuario.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Iconos -->
</head>

<body>
    <?php include 'view/sidebar.php'; ?> <!-- Incluir el menú lateral -->
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
            <h1>Mantenimiento de Usuarios</h1>
            <button id="nuevo-registro-btn" class="asistencia-button">Nuevo Registro</button>

            <!-- Contenedor de la tabla con barra de desplazamiento -->
            <div class="table-container">
                <table id="tablaUsuarios" class="display">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>DNI</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Nombre de Usuario</th>
                            <th>Contraseña</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($usuario['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($usuario['dni'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($usuario['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($usuario['apellido'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($usuario['nombre_usuario'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($usuario['contrasena'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($usuario['correo_electronico'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($usuario['telefono'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <?php if ($usuario['rol_id'] == 1): ?>
                                        <span class="badge badge-admin">Administrador</span>
                                    <?php else: ?>
                                        <span class="badge badge-usuario">Usuario</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="action-button edit-button" data-id="<?php echo $usuario['id']; ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="action-button delete-button" data-id="<?php echo $usuario['id']; ?>">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div> <!-- Fin del contenedor de la tabla -->
        </div>
    </div>

    <!-- Modal de nuevo registro -->
    <div id="usuario-modal" class="modal">
        <div class="modal-content">
            <span id="close-modal" class="close">&times;</span>
            <form id="usuario-form" method="post" action="/bbro/addUsuario">
                <h2>Nuevo Registro</h2>
                <input type="hidden" name="id" id="usuario-id">

                <!-- Añadir el campo DNI -->
                <label for="dni">DNI</label>
                <input type="text" name="dni" id="usuario-dni" required>

                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="usuario-nombre" required>

                <label for="apellido">Apellido</label>
                <input type="text" name="apellido" id="usuario-apellido" required>

                <label for="nombre_usuario">Nombre de Usuario</label>
                <input type="text" name="nombre_usuario" id="usuario-nom" required>

                <label for="contrasena">Contraseña</label>
                <input type="password" name="contrasena" id="usuario-contrasena" required>

                <label for="correo_electronico">Correo Electrónico</label>
                <input type="email" name="correo_electronico" id="usuario-correo" required>

                <label for="telefono">Teléfono</label>
                <input type="phone" name="telefono" id="usuario-telefono" required>

                <label for="rol_id">Rol</label>
                <select name="rol_id" id="usuario-rol">
                    <option value="1">Administrador</option>
                    <option value="2">Usuario</option>
                </select>
                <button type="submit" id="guardar-usuario-btn">Guardar</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="/bbro/public/js/mantenimiento_usuarios.js"></script>
</body>

</html>