<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ./login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "gestion_personas");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// =====================
// OBTENER REGISTRO
// =====================
if (!isset($_GET['id'])) {
    die("ID no válido");
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM personas WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Registro no encontrado");
}

$data = $result->fetch_assoc();
$stmt->close();

// =====================
// ACTUALIZAR REGISTRO
// =====================
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];

    // ================= IMAGEN =================
    $foto_perfil = $data['foto_perfil'];

    if (!empty($_FILES['foto_perfil']['name'])) {
        $dir = "../matrix/uploads/perfiles/";
        if (!is_dir($dir)) mkdir($dir, 0777, true);

        $ext = pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);
        $foto_perfil = $dir . uniqid("EDIT_") . "." . $ext;

        move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $foto_perfil);
    }

    // ================= IMAGEN FRONTAL=================
    $foto_documento_frontal = $data['foto_documento_frontal'];

    if (!empty($_FILES['foto_documento_frontal']['name'])) {
        $dir = "../matrix/uploads/documentos/";
        if (!is_dir($dir)) mkdir($dir, 0777, true);

        $ext = pathinfo($_FILES['foto_documento_frontal']['name'], PATHINFO_EXTENSION);
        $foto_documento_frontal = $dir . uniqid("EDIT_") . "." . $ext;

        move_uploaded_file($_FILES['foto_documento_frontal']['tmp_name'], $foto_documento_frontal);
    }

    // ================= IMAGEN TRASERA=================
    $foto_documento_trasera = $data['foto_documento_trasera'];

    if (!empty($_FILES['foto_documento_trasera']['name'])) {
        $dir = "../matrix/uploads/documentos/";
        if (!is_dir($dir)) mkdir($dir, 0777, true);

        $ext = pathinfo($_FILES['foto_documento_trasera']['name'], PATHINFO_EXTENSION);
        $foto_documento_trasera = $dir . uniqid("EDIT_") . "." . $ext;

        move_uploaded_file($_FILES['foto_documento_trasera']['tmp_name'], $foto_documento_trasera);
    }

    // ================= UPDATE =================
    $sql = "UPDATE personas SET 
                nombre = ?,
                apellido = ?,
                telefono = ?,
                correo = ?,
                direccion = ?,
                ciudad = ?,
                foto_perfil = ?,
                foto_documento_frontal = ?,
                foto_documento_trasera = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssssssssii",
        $nombre,
        $apellido,
        $telefono,
        $correo,
        $direccion,
        $ciudad,
        $foto_perfil,
        $foto_documento_frontal,
        $foto_documento_trasera,
        $id
    );

    if ($stmt->execute()) {
        header("Location: ../datos.php?msg=actualizado");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-warning">
            <h3>Editar Persona</h3>
        </div>

        <div class="card-body">

            <form method="POST" enctype="multipart/form-data">

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>Nombre</label>
                        <input type="text" name="nombre" class="form-control"
                               value="<?= $data['nombre'] ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Apellido</label>
                        <input type="text" name="apellido" class="form-control"
                               value="<?= $data['apellido'] ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Teléfono</label>
                        <input type="text" name="telefono" class="form-control"
                               value="<?= $data['telefono'] ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Correo</label>
                        <input type="email" name="correo" class="form-control"
                               value="<?= $data['correo'] ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Dirección</label>
                        <input type="text" name="direccion" class="form-control"
                               value="<?= $data['direccion'] ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Ciudad</label>
                        <input type="text" name="ciudad" class="form-control"
                               value="<?= $data['ciudad'] ?>">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Foto Perfil</label>
                        <input type="file" name="foto_perfil" class="form-control">

                        <?php if ($data['foto_perfil']) { ?>
                            <img src="<?= $data['foto_perfil'] ?>" width="100" class="mt-2">
                        <?php } ?>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Foto Documento</label>
                        <input type="file" name="foto_documento_frontal" class="form-control">

                        <?php if ($data['foto_documento_frontal']) { ?>
                            <img src="<?= $data['foto_documento_frontal'] ?>" width="100" class="mt-2">
                        <?php } ?>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Foto Documento Trasera</label>
                        <input type="file" name="foto_documento_trasera" class="form-control">

                        <?php if ($data['foto_documento_trasera']) { ?>
                            <img src="<?= $data['foto_documento_trasera'] ?>" width="100" class="mt-2">
                        <?php } ?>
                    </div>

                </div>

                <button type="submit" class="btn btn-success">
    <i class="bi bi-check-circle me-2"></i> Guardar Cambios
</button>

<a href="../datos.php" class="btn btn-secondary">
    Volver
</a>

<a href="http://localhost/phpmyadmin/index.php?lang=es" class="btn btn-secondary">
    BASE DE DATOS
</a>

            </form>

        </div>
    </div>

</div>

</body>
</html>