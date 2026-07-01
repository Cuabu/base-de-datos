<?php
session_start();

// 1. CONEXIÓN GLOBAL A LA BASE DE DATOS (Debe ir siempre al inicio)
$conn = new mysqli("localhost", "root", "", "gestion_personas");
if ($conn->connect_error) { 
    die("Error de conexión: " . $conn->connect_error); 
}

$mensaje = "";

// 2. LÓGICA DE ELIMINACIÓN
if (isset($_GET['eliminar'])) {
    $id_del = intval($_GET['eliminar']);
    $stmt_del = $conn->prepare("DELETE FROM personas WHERE id = ?");
    $stmt_del->bind_param("i", $id_del);
    if($stmt_del->execute()) {
        header("Location: ../matrix/config/eliminar.php");
        exit;
    }
    $stmt_del->close();
}

// 3. LÓGICA DE INSERCIÓN
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $tipo_documento = $_POST['tipo_documento'] ?? '';
    $numero_documento = $_POST['numero_documento'] ?? '';
    $fecha_nacimiento = !empty($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : null;
    $genero = $_POST['genero'] ?? '';
    $nacionalidad = $_POST['nacionalidad'] ?? '';
    
    $telefono = $_POST['telefono'] ?? '';
    $telefono_secundario = $_POST['telefono_secundario'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $ciudad = $_POST['ciudad'] ?? '';
    $departamento = $_POST['departamento'] ?? '';
    $pais = $_POST['pais'] ?? '';
    $codigo_postal = $_POST['codigo_postal'] ?? '';
    
    $lugar_residencia = $_POST['lugar_residencia'] ?? '';
    
    $empresa = $_POST['empresa'] ?? '';
    $cargo = $_POST['cargo'] ?? '';
    $direccion_trabajo = $_POST['direccion_trabajo'] ?? '';
    $telefono_trabajo = $_POST['telefono_trabajo'] ?? '';
    
    $marca_celular = $_POST['marca_celular'] ?? '';
    $modelo_celular = $_POST['modelo_celular'] ?? '';
    $imei = $_POST['imei'] ?? '';
    $marca_computadora = $_POST['marca_computadora'] ?? '';
    $modelo_computadora = $_POST['modelo_computadora'] ?? '';
    $numero_serie_pc = $_POST['numero_serie_pc'] ?? '';
    
    $facebook = $_POST['facebook'] ?? '';
    $instagram = $_POST['instagram'] ?? '';
    $tiktok = $_POST['tiktok'] ?? '';
    $x = $_POST['x'] ?? '';
    $youtube = $_POST['youtube'] ?? '';
    $linkedin = $_POST['linkedin'] ?? '';
    $github = $_POST['github'] ?? '';
    $telegram = $_POST['telegram'] ?? '';
    $whatsapp = $_POST['whatsapp'] ?? '';
    
    $estado_civil = $_POST['estado_civil'] ?? '';
    $profesion = $_POST['profesion'] ?? '';
    $nivel_estudios = $_POST['nivel_estudios'] ?? '';
    $observaciones = $_POST['observaciones'] ?? '';

    $foto_perfil = "uploads/perfiles/default.png";
    $foto_doc_frontal = "";
    $foto_doc_trasera = "";

    // Insertar en la BD (Simplificado para evitar que sea muy largo, asume directorios creados)
    $sql = "INSERT INTO personas (
                nombre, apellido, tipo_documento, numero_documento, fecha_nacimiento, genero, nacionalidad,
                telefono, telefono_secundario, correo, direccion, ciudad, departamento, pais, codigo_postal,
                lugar_residencia, empresa, cargo, direccion_trabajo, telefono_trabajo,
                marca_celular, modelo_celular, imei, marca_computadora, modelo_computadora, numero_serie_pc,
                facebook, instagram, tiktok, x, youtube, linkedin, github, telegram, whatsapp,
                foto_perfil, foto_documento_frontal, foto_documento_trasera,
                estado_civil, profesion, nivel_estudios, observaciones
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssssssssssssssssssssssssssssssssssssssssss",
        $nombre, $apellido, $tipo_documento, $numero_documento, $fecha_nacimiento, $genero, $nacionalidad,
        $telefono, $telefono_secundario, $correo, $direccion, $ciudad, $departamento, $pais, $codigo_postal,
        $lugar_residencia, $empresa, $cargo, $direccion_trabajo, $telefono_trabajo,
        $marca_celular, $modelo_celular, $imei, $marca_computadora, $modelo_computadora, $numero_serie_pc,
        $facebook, $instagram, $tiktok, $x, $youtube, $linkedin, $github, $telegram, $whatsapp,
        $foto_perfil, $foto_doc_frontal, $foto_doc_trasera,
        $estado_civil, $profesion, $nivel_estudios, $observaciones
    );

    if ($stmt->execute()) {
        $mensaje = "<div class='alert alert-matrix-success'>[SISTEMA]: Registro inyectado con éxito.</div>";
    } else {
        $mensaje = "<div class='alert alert-matrix-danger'>[ERROR]: " . $stmt->error . "</div>";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matrix Core - Gestión</title>
    <!-- CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #050505;
            color: #00ff41;
            font-family: 'Courier New', Courier, monospace;
        }
        .matrix-card {
            background: rgba(10, 20, 10, 0.9);
            border: 1px solid #00ff41;
            box-shadow: 0 0 20px rgba(0, 255, 65, 0.3);
            border-radius: 8px;
        }
        .matrix-header {
            border-bottom: 2px dashed #00ff41;
        }
        .form-label {
            color: #00ff41;
            font-weight: bold;
            font-size: 0.8rem;
        }
        .form-control, .form-select {
            background-color: #000 !important;
            border: 1px solid #008f11 !important;
            color: #33ff33 !important;
        }
        .form-control:focus, .form-select:focus {
            border-color: #00ff41 !important;
            box-shadow: 0 0 8px rgba(0, 255, 65, 0.6) !important;
        }
        .nav-tabs .nav-link { color: #008f11; font-weight: bold; }
        .nav-tabs .nav-link.active {
            background-color: #008f11 !important;
            color: #000 !important;
        }
        .btn-matrix-primary { background: #000; color: #00ff41; border: 1px solid #00ff41; }
        .btn-matrix-primary:hover { background: #00ff41; color: #000; }
        .alert-matrix-success { background: #012201; border: 1px solid #00ff41; color: #00ff41; }
    </style>
</head>
<body>

<div class="container mt-5 mb-5">
    <div class="card matrix-card">
        <div class="card-header matrix-header p-4">
            <h2 class="mb-0 text-center text-uppercase"><i class="bi bi-terminal-fill me-3"></i>Inyección de Identidades</h2>
            <!-- BOTÓN DE RETORNO AÑADIDO AQUÍ -->
            <div class="text-start mb-3">
                <a href="dashboard.php" class="btn btn-sm btn-outline-secondary"><i class="bi bi-house-door"></i> VOLVER AL PANEL</a>
            </div>
        </div>
        <div class="card-body p-4">
            
            <?php echo $mensaje; ?>

            <form action="../matrix/config/agregar.php" method="POST" enctype="multipart/form-data">
                
                <ul class="nav nav-tabs mb-4 justify-content-center" id="matrixTabs" role="tablist">
                    <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#personal" type="button" role="tab">1. Personal</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#contacto" type="button" role="tab">2. Localización</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#laboral" type="button" role="tab">3. Corporativo</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#hardware" type="button" role="tab">4. Hardware</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#redes" type="button" role="tab">5. Redes</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#media" type="button" role="tab">6. Archivos</button></li>
                </ul>

                <div class="tab-content">
                    
                    <!-- PESTAÑA 1: Personal -->
                    <div class="tab-pane fade show active" id="personal" role="tabpanel">
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label">Nombre *</label><input type="text" name="nombre" class="form-control" required></div>
                            <div class="col-md-6"><label class="form-label">Apellido *</label><input type="text" name="apellido" class="form-control" required></div>
                            <div class="col-md-4"><label class="form-label">Tipo de Documento</label><input type="text" name="tipo_documento" class="form-control"></div>
                            <div class="col-md-4"><label class="form-label">Número Documento</label><input type="text" name="numero_documento" class="form-control"></div>
                            <div class="col-md-4"><label class="form-label">Fecha de Nacimiento</label><input type="date" name="fecha_nacimiento" class="form-control"></div>
                            <div class="col-md-4">
                                <label class="form-label">Género</label>
                                <select name="genero" class="form-select">
                                    <option value="">[SELECCIONAR]</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                            <div class="col-md-4"><label class="form-label">Nacionalidad</label><input type="text" name="nacionalidad" class="form-control"></div>
                            <div class="col-md-4"><label class="form-label">Estado Civil</label><input type="text" name="estado_civil" class="form-control"></div>
                            <div class="col-md-6"><label class="form-label">Profesión</label><input type="text" name="profesion" class="form-control"></div>
                            <div class="col-md-6"><label class="form-label">Nivel de Estudios</label><input type="text" name="nivel_estudios" class="form-control"></div>
                        </div>
                    </div>
                    
                    <!-- PESTAÑA 2: Localización -->
                    <div class="tab-pane fade" id="contacto" role="tabpanel">
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label">Teléfono Principal</label><input type="text" name="telefono" class="form-control"></div>
                            <div class="col-md-6"><label class="form-label">Teléfono Secundario</label><input type="text" name="telefono_secundario" class="form-control"></div>
                            <div class="col-md-9"><label class="form-label">Correo Electrónico</label><input type="email" name="correo" class="form-control"></div>
                            <div class="col-md-3"><label class="form-label">Código Postal</label><input type="text" name="codigo_postal" class="form-control"></div>
                            <div class="col-12"><label class="form-label">Dirección</label><input type="text" name="direccion" class="form-control"></div>
                            <div class="col-md-4"><label class="form-label">Ciudad</label><input type="text" name="ciudad" class="form-control"></div>
                            <div class="col-md-4"><label class="form-label">Departamento</label><input type="text" name="departamento" class="form-control"></div>
                            <div class="col-md-4"><label class="form-label">País</label><input type="text" name="pais" class="form-control"></div>
                        </div>
                    </div>
                    
                    <!-- PESTAÑA 3: Corporativo -->
                    <div class="tab-pane fade" id="laboral" role="tabpanel">
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label">Empresa</label><input type="text" name="empresa" class="form-control"></div>
                            <div class="col-md-6"><label class="form-label">Cargo</label><input type="text" name="cargo" class="form-control"></div>
                            <div class="col-md-8"><label class="form-label">Dirección de Trabajo</label><input type="text" name="direccion_trabajo" class="form-control"></div>
                            <div class="col-md-4"><label class="form-label">Teléfono de Trabajo</label><input type="text" name="telefono_trabajo" class="form-control"></div>
                        </div>
                    </div>
                    
                    <!-- PESTAÑA 4: Hardware -->
                    <div class="tab-pane fade" id="hardware" role="tabpanel">
                        <div class="row g-3">
                            <div class="col-md-4"><label class="form-label">Marca Celular</label><input type="text" name="marca_celular" class="form-control"></div>
                            <div class="col-md-4"><label class="form-label">Modelo Celular</label><input type="text" name="modelo_celular" class="form-control"></div>
                            <div class="col-md-4"><label class="form-label">IMEI Celular</label><input type="text" name="imei" class="form-control"></div>
                            <div class="col-md-4"><label class="form-label">Marca Computadora</label><input type="text" name="marca_computadora" class="form-control"></div>
                            <div class="col-md-4"><label class="form-label">Modelo Computadora</label><input type="text" name="modelo_computadora" class="form-control"></div>
                            <div class="col-md-4"><label class="form-label">Número de Serie PC</label><input type="text" name="numero_serie_pc" class="form-control"></div>
                        </div>
                    </div>
                    
                    <!-- PESTAÑA 5: Redes Sociales -->
                    <div class="tab-pane fade" id="redes" role="tabpanel">
                        <div class="row g-3">
                            <div class="col-md-4"><label class="form-label">Facebook (URL)</label><input type="url" name="facebook" class="form-control"></div>
                            <div class="col-md-4"><label class="form-label">Instagram (URL)</label><input type="url" name="instagram" class="form-control"></div>
                            <div class="col-md-4"><label class="form-label">TikTok (@usuario)</label><input type="text" name="tiktok" class="form-control"></div>
                            <div class="col-md-4"><label class="form-label">X / Twitter (URL)</label><input type="url" name="x" class="form-control"></div>
                            <div class="col-md-4"><label class="form-label">YouTube (URL)</label><input type="url" name="youtube" class="form-control"></div>
                            <div class="col-md-4"><label class="form-label">LinkedIn (URL)</label><input type="url" name="linkedin" class="form-control"></div>
                            <div class="col-md-4"><label class="form-label">GitHub (URL)</label><input type="url" name="github" class="form-control"></div>
                            <div class="col-md-4"><label class="form-label">Telegram (@usuario)</label><input type="text" name="telegram" class="form-control"></div>
                            <div class="col-md-4"><label class="form-label">WhatsApp</label><input type="text" name="whatsapp" class="form-control"></div>
                        </div>
                    </div>
                    
                    <!-- PESTAÑA 6: Archivos -->
                    <div class="tab-pane fade" id="media" role="tabpanel">
                        <div class="row g-3">
                            <div class="col-md-4"><label class="form-label">Foto Perfil</label><input type="file" name="foto_perfil" class="form-control" accept="image/*"></div>
                            <div class="col-md-4"><label class="form-label">Documento Frontal</label><input type="file" name="foto_documento_frontal" class="form-control" accept="image/*"></div>
                            <div class="col-md-4"><label class="form-label">Documento Reverso</label><input type="file" name="foto_documento_trasera" class="form-control" accept="image/*"></div>
                            <div class="col-12"><label class="form-label">Observaciones</label><textarea name="observaciones" class="form-control" rows="3"></textarea></div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top border-secondary">
    <button type="reset" class="btn btn-outline-danger btn-sm">
        <i class="bi bi-arrow-counterclockwise"></i> Limpiar
    </button>

    <button type="submit" class="btn btn-matrix-primary px-4 fw-bold">
        <i class="bi bi-shield-lock-fill me-2"></i> Inyectar Registro
    </button>
</div>
            </form>
        </div>
    </div>

    <!-- SECCIÓN DE VISUALIZACIÓN CONTINUA -->
    <div class="card matrix-card mt-5">
        <div class="card-header matrix-header p-3">
            <h4 class="mb-0 text-uppercase"><i class="bi bi-eye-fill me-2"></i>Registros Actuales</h4>
        </div>
        <div class="card-body p-0 table-responsive">
            <table class="table table-dark table-hover align-middle mb-0 text-center" style="--bs-table-bg: transparent; color: #33ff33;">
                <thead style="border-bottom: 2px solid #00ff41;">
                    <tr>
                        <th>CORE ID</th>
                        <th>SUJETO</th>
                        <th>DOCUMENTO</th>
                        <th>LOCALIZACIÓN</th>
                        <th>TERMINAL MÓVIL</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // SE MODIFICÓ LA CONSULTA PARA TRAER TODOS LOS CAMPOS (SELECT *)
                    $registros = $conn->query("SELECT * FROM personas ORDER BY id DESC");
                    
                    if($registros && $registros->num_rows > 0):
                        while($row = $registros->fetch_assoc()):
                    ?>
                        <tr style="border-bottom: 1px solid #004d11;">
                            <td class="text-white fw-bold">#<?php echo sprintf("%04d", $row['id']); ?></td>
                            <td class="text-start" style="color: #00ff41;"><?php echo htmlspecialchars($row['nombre']." ".$row['apellido']); ?></td>
                            <td><span class="badge bg-black text-warning border border-warning"><?php echo htmlspecialchars($row['tipo_documento'].": ".$row['numero_documento']); ?></span></td>
                            <td><i class="bi bi-geo-alt me-1 text-danger"></i><?php echo htmlspecialchars($row['ciudad'].", ".$row['pais']); ?></td>
                            <td><i class="bi bi-cpu text-muted me-1"></i><?php echo htmlspecialchars($row['modelo_celular']); ?></td>
                            <td>
                                <!-- SE AÑADIÓ EL BOTÓN "VER" QUE ACTIVA EL MODAL -->
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#viewModal<?php echo $row['id']; ?>"><i class="bi bi-eye"></i> VER</button>
                                    <a href="../matrix/config/editar.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-warning">MOD</a>
                                    <a href="../matrix/config/eliminar.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Confirmar purga permanente del registro?');">REJ</a>
                                </div>
                            </td>
                        </tr>

                        <!-- VENTANA EMERGENTE (MODAL) PARA VER TODOS LOS DATOS -->
                        <div class="modal fade" id="viewModal<?php echo $row['id']; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content matrix-card" style="background-color: #050505;">
                                    <div class="modal-header matrix-header">
                                        <h5 class="modal-title" style="color: #00ff41;"><i class="bi bi-person-bounding-box me-2"></i>Expediente Core ID: #<?php echo sprintf("%04d", $row['id']); ?></h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-start" style="color: #33ff33; font-family: monospace;">
                                        <div class="row g-3">
                                            <div class="col-md-4 text-center">
                                                <?php $avatar_modal = !empty($row['foto_perfil']) && file_exists($row['foto_perfil']) ? $row['foto_perfil'] : 'uploads/perfiles/default.png'; ?>
                                                <img src="<?php echo htmlspecialchars($avatar_modal); ?>" class="img-fluid border border-success rounded mb-3" style="max-height: 250px; object-fit: cover; box-shadow: 0 0 10px #00ff41;">
                                            </div>
                                            <div class="col-md-8">
                                                <h5 class="text-white border-bottom border-success pb-1">Datos Personales</h5>
                                                <p class="mb-1"><strong>Sujeto:</strong> <?php echo htmlspecialchars($row['nombre'].' '.$row['apellido']); ?></p>
                                                <p class="mb-1"><strong>Documento:</strong> <?php echo htmlspecialchars($row['tipo_documento'].': '.$row['numero_documento']); ?></p>
                                                <p class="mb-1"><strong>Nacimiento:</strong> <?php echo htmlspecialchars($row['fecha_nacimiento'].' ('.$row['genero'].')'); ?></p>
                                                <p class="mb-3"><strong>Nacionalidad:</strong> <?php echo htmlspecialchars($row['nacionalidad'].' - '.$row['estado_civil']); ?></p>
                                                
                                                <h5 class="text-white border-bottom border-success pb-1">Contacto & Ubicación</h5>
                                                <p class="mb-1"><strong>Teléfono:</strong> <?php echo htmlspecialchars($row['telefono'].' / '.$row['telefono_secundario']); ?></p>
                                                <p class="mb-1"><strong>Correo:</strong> <?php echo htmlspecialchars($row['correo']); ?></p>
                                                <p class="mb-3"><strong>Dirección:</strong> <?php echo htmlspecialchars($row['direccion'].', '.$row['ciudad'].', '.$row['pais']); ?></p>
                                                
                                                <h5 class="text-white border-bottom border-success pb-1">Laboral & Hardware</h5>
                                                <p class="mb-1"><strong>Empresa:</strong> <?php echo htmlspecialchars($row['empresa'].' - '.$row['cargo']); ?></p>
                                                <p class="mb-1"><strong>Teléfono Laboral:</strong> <?php echo htmlspecialchars($row['telefono_trabajo']); ?></p>
                                                <p class="mb-1"><strong>Móvil:</strong> <?php echo htmlspecialchars($row['marca_celular'].' '.$row['modelo_celular'].' (IMEI: '.$row['imei'].')'); ?></p>
                                                <p class="mb-1"><strong>PC:</strong> <?php echo htmlspecialchars($row['marca_computadora'].' '.$row['modelo_computadora']); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-secondary">
                                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal"><i class="bi bi-x-circle me-1"></i> Cerrar Conexión</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- FIN DEL MODAL -->

                    <?php 
                        endwhile;
                    else: 
                    ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">[SISTEMA VACÍO]</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- SCRIPT DE BOOTSTRAP OBLIGATORIO PARA EL MODAL -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>