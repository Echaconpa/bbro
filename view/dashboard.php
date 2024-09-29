<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/bbro/public/css/dashboard.css">
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
            <h1>Dashboard</h1>
            <div class="dashboard-widgets">
                <div class="widget" id="widget-revenue">
                    <h2>Total Revenue</h2>
                    <p>$34,152</p>
                </div>
                <div class="widget" id="widget-orders">
                    <h2>Orders</h2>
                    <p>5,643</p>
                </div>
                <div class="widget" id="widget-customers">
                    <h2>Customers</h2>
                    <p>45,254</p>
                </div>
                <div class="widget" id="widget-growth">
                    <h2>Growth</h2>
                    <p>+12.58%</p>
                </div>
            </div>
        </div>
    </div>
    <script src="/bbro/public/js/dashboard.js"></script>
</body>

</html>