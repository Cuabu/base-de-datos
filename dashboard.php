<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ./login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control</title>
    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Iconos de Bootstrap (Opcional, pero recomendados para un look pro) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar-custom {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,.04);
        }
        .main-card {
            border: none;
            border-radius: 16px;
            transition: transform 0.2s;
        }
    </style>
</head>
<body>

    <!-- barra de navegación superior -->
    <nav class="navbar navbar-expand-lg navbar-custom mb-5">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="#">
                <i class="bi bi-speedometer2 me-2"></i>Panel Principal
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- Dropdown del Menú integrado limpiamente -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active fw-semibold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-list me-1"></i> Menú de Opciones
                        </a>
                        <ul class="dropdown-menu shadow-sm border-0 mt-2">
                            <li><a class="dropdown-item py-2" href="datos.php"><i class="bi bi-layers me-2"></i>Base de Datos</a></li>
                            <li><a class="dropdown-item py-2" href="../matrix/scripts/scripts.php"><i class="bi bi-gear me-2"></i>Scripts</a></li>
                            <li><a class="dropdown-item py-2" href="#"><i class="bi bi-graph-up me-2"></i></a></li>
                            <li><hr class="dropdown-divider"></li>
                        </ul>
                    </li>
                </ul>
                
                <!-- Botón de salir directo a la derecha -->
                <div class="d-flex align-items-center">
                    <span class="text-muted me-3 d-none d-md-inline">
                        <i class="bi bi-person-circle me-1"></i> <?php echo htmlspecialchars($_SESSION['nombre']); ?>
                    </span>
                    <a href="./logout.php" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                        <i class="bi bi-box-arrow-right me-1"></i> Cerrar sesión
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                
                <div class="card main-card shadow-sm p-4 text-center bg-white">
                    <div class="card-body">
                        <!-- Icono de bienvenida -->
                        <div class="display-4 text-primary mb-3">
                            <i class="bi bi-emoji-smile-fill"></i>
                        </div>
                        
                        <h2 class="card-title fw-normal mb-3">
                            ¡Bienvenido de nuevo, <br>
                            <span class="fw-bold text-dark"><?php echo htmlspecialchars($_SESSION['nombre']); ?></span>!
                        </h2>
                        
                        <p class="text-muted mb-4">Has iniciado sesión correctamente en el sistema. Selecciona una opción del menú superior para comenzar a trabajar.</p>
                        
                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                            <button class="btn btn-primary btn-lg px-4 gap-3 rounded-pill fs-6 shadow-sm">
                                <i class="bi bi-lightning-charge-fill me-1"></i> Empezar ahora
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3.3 Bundle JS (Al final del cuerpo) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>