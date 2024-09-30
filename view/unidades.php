<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimiento de Unidades</title>
    <link rel="stylesheet" href="/bbro/public/css/dashboard.css">
    <link rel="stylesheet" href="/bbro/public/css/unidades.css">
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
            <h1>Mantenimiento de Unidades</h1>
            <button id="nuevo-registro-btn" class="unidades-button">Nueva Unidad</button>

            <div class="table-container">
                <table id="tablaUnidades" class="display">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Razón Social</th>
                            <th>RUC/DNI</th>
                            <th>Dirección</th>
                            <th>Rubro</th>
                            <th>Encargado de Seguridad</th>
                            <th>Tel. Encargado</th>
                            <th>Fijo Encargado</th>
                            <th>Segundo Contacto</th>
                            <th>Tel. S. Contacto</th>
                            <th>Fijo S. Contacto</th>
                            <th>Puesto Vigilancia</th>
                            <th>Comisaria</th>
                            <th>Serenazgo</th>
                            <th>Bomberos</th>
                            <th>SAMU</th>
                            <th>Observaciones</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($unidades as $unidad): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($unidad['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($unidad['razon_social'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($unidad['ruc_dni'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($unidad['direccion'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($unidad['rubro'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($unidad['encargado_seguridad'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($unidad['telf_encargado'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($unidad['fijo_encargado'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($unidad['segundo_contacto'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($unidad['telf_scontacto'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($unidad['fijo_scontacto'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($unidad['puesto_vigilancia'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($unidad['comisaria'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($unidad['serenazgo'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($unidad['bomberos'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($unidad['samu'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($unidad['observaciones'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <button class="action-button edit-button" data-id="<?php echo $unidad['id']; ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="action-button delete-button" data-id="<?php echo $unidad['id']; ?>">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <button class="action-button view-button" data-id="<?php echo $unidad['id']; ?>">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal de nueva unidad -->
        <div id="unidades-modal" class="modal">
            <div class="modal-content">
                <span id="close-modal" class="close">&times;</span>
                <form id="unidades-form" method="post" enctype="multipart/form-data" action="/bbro/addUnidad">
                    <h2>Nueva Unidad</h2>
                    <input type="hidden" name="id" id="unidad-id">
                    <!-- Formulario -->
                    <label for="razon_social">Razón Social</label>
                    <input type="text" name="razon_social" id="unidad-razon_social" required>

                    <label for="ruc_dni">RUC/DNI</label>
                    <input type="text" name="ruc_dni" id="unidad-ruc_dni" required>

                    <label for="direccion">Dirección</label>
                    <input type="text" name="direccion" id="unidad-direccion" required>

                    <label for="rubro">Rubro</label>
                    <input type="text" name="rubro" id="unidad-rubro" required>

                    <label for="encargado_seguridad">Encargado de Seguridad</label>
                    <input type="text" name="encargado_seguridad" id="unidad-encargado_seguridad" required>

                    <label for="telf_encargado">Teléfono Encargado</label>
                    <input type="text" name="telf_encargado" id="unidad-telf_encargado" required>

                    <label for="fijo_encargado">Teléfono Fijo Encargado</label>
                    <input type="text" name="fijo_encargado" id="unidad-fijo_encargado">

                    <label for="segundo_contacto">Segundo Contacto</label>
                    <input type="text" name="segundo_contacto" id="unidad-segundo_contacto">

                    <label for="telf_scontacto">Teléfono Segundo Contacto</label>
                    <input type="text" name="telf_scontacto" id="unidad-telf_scontacto">

                    <label for="fijo_scontacto">Teléfono Fijo Segundo Contacto</label>
                    <input type="text" name="fijo_scontacto" id="unidad-fijo_scontacto">

                    <label for="puesto_vigilancia">Puesto de Vigilancia</label>
                    <input type="text" name="puesto_vigilancia" id="unidad-puesto_vigilancia">

                    <label for="comisaria">Comisaria</label>
                    <input type="text" name="comisaria" id="unidad-comisaria">

                    <label for="serenazgo">Serenazgo</label>
                    <input type="text" name="serenazgo" id="unidad-serenazgo">

                    <label for="bomberos">Bomberos</label>
                    <input type="text" name="bomberos" id="unidad-bomberos">

                    <label for="samu">SAMU</label>
                    <input type="text" name="samu" id="unidad-samu">

                    <label for="observaciones">Observaciones</label>
                    <textarea name="observaciones" id="unidad-observaciones"></textarea>

                    <label for="foto">Foto</label>
                    <input type="file" name="foto_unidad" id="unidad-foto">

                    <button type="submit">Guardar</button>
                </form>
            </div>
        </div>

        <!-- Modal de visualización de unidad -->
        <div id="unidad-view-modal" class="modal">
            <div class="modal-content">
                <span id="close-view-modal" class="close">&times;</span>
                <div class="card-container">
                    <div class="card">
                    <img src="/bbro/public/img/unidades/<?php echo htmlspecialchars($unidad['foto'], ENT_QUOTES, 'UTF-8'); ?>" alt="Foto de la Unidad" class="unidad-photo" id="unidad-photo-modal">
                        <div class="card-content">
                            <h2 id="unidad-name-modal">Nombre de la Unidad</h2>
                            <p><strong>RUC/DNI:</strong> <span id="unidad-ruc-modal"></span></p>
                            <p><strong>Dirección:</strong> <span id="unidad-direccion-modal"></span></p>
                            <p><strong>Rubro:</strong> <span id="unidad-rubro-modal"></span></p>
                            <p><strong>Encargado de Seguridad:</strong> <span id="unidad-encargado-modal"></span></p>
                            <p><strong>Teléfono Encargado:</strong> <span id="unidad-telf-encargado-modal"></span></p>
                            <p><strong>Segundo Contacto:</strong> <span id="unidad-contacto-modal"></span></p>
                            <p><strong>Puesto de Vigilancia:</strong> <span id="unidad-puesto-modal"></span></p>
                            <p><strong>Comisaria:</strong> <span id="unidad-comisaria-modal"></span></p>
                            <p><strong>Serenazgo:</strong> <span id="unidad-serenazgo-modal"></span></p>
                            <p><strong>Bomberos:</strong> <span id="unidad-bomberos-modal"></span></p>
                            <p><strong>SAMU:</strong> <span id="unidad-samu-modal"></span></p>
                            <p><strong>Observaciones:</strong> <span id="unidad-observaciones-modal"></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        <script src="/bbro/public/js/unidades.js"></script>
</body>

</html>
