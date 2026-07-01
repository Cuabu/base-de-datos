<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Matrix Core - Descargas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background-color: #050505; color: #00ff41; font-family: 'Courier New', monospace; }
        .matrix-card { background: rgba(10, 20, 10, 0.9); border: 1px solid #00ff41; border-radius: 8px; padding: 20px; transition: 0.3s; }
        .matrix-card:hover { box-shadow: 0 0 15px #00ff41; cursor: pointer; }
        .modal-content { background-color: #050505; border: 1px solid #00ff41; color: #00ff41; }
        .list-group-item { background: #000; color: #00ff41; border: 1px solid #004d11; }
        .list-group-item:hover { background: #004d11; color: #fff; }
    </style>
</head>
<body>
    

<div class="container mt-5"><!-- BOTÓN DE RETORNO AÑADIDO AQUÍ -->
            <div class="text-start mb-3">
                <a href="../dashboard.php" class="btn btn-sm btn-outline-secondary"><i class="bi bi-house-door"></i> VOLVER AL PANEL</a>
            </div>
    <h2 class="text-center mb-5 text-uppercase"><i class="bi bi-folder-symlink"></i> Directorio de Archivos</h2>
    
    <div class="row text-center">
        <!-- Categoría Android -->
        <div class="col-md-4" data-bs-toggle="modal" data-bs-target="#modalAndroid">
            <div class="matrix-card">
                <i class="bi bi-android2 fs-1"></i>
                <h3>ANDROID</h3>
            </div>
        </div>
        <!-- Categoría Windows -->
        <div class="col-md-4" data-bs-toggle="modal" data-bs-target="#modalWindows">
            <div class="matrix-card">
                <i class="bi bi-windows fs-1"></i>
                <h3>WINDOWS</h3>
            </div>
        </div>
        <!-- Categoría Linux -->
        <div class="col-md-4" data-bs-toggle="modal" data-bs-target="#modalLinux">
            <div class="matrix-card">
                <i class="bi bi-ubuntu fs-1"></i>
                <h3>LINUX</h3>
            </div>
        </div>
    </div>
</div>

<!-- Modales -->
<?php 
$categorias = ['Android', 'Windows', 'Linux'];
foreach($categorias as $cat): ?>
<div class="modal fade" id="modal<?php echo $cat; ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-bottom border-success">
                <h5 class="modal-title">ARCHIVOS: <?php echo strtoupper($cat); ?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    <a href="persistencia-android.sh" class="list-group-item"><i class="bi bi-download"></i> persistencia</a>
                    <a href="archivos/data.zip" class="list-group-item"><i class="bi bi-download"></i> Configuración.zip</a>
                    <a href="archivos/manual.pdf" class="list-group-item"><i class="bi bi-file-earmark-pdf"></i> Manual_Usuario.pdf</a>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>