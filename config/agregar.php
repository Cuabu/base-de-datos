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

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // =========================
    // INFORMACIÓN PERSONAL
    // =========================
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $tipo_documento = $_POST['tipo_documento'] ?? '';
    $numero_documento = $_POST['numero_documento'] ?? '';
    $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? null;
    $genero = $_POST['genero'] ?? '';
    $nacionalidad = $_POST['nacionalidad'] ?? '';

    // =========================
    // CONTACTO
    // =========================
    $telefono = $_POST['telefono'] ?? '';
    $telefono_secundario = $_POST['telefono_secundario'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $ciudad = $_POST['ciudad'] ?? '';
    $departamento = $_POST['departamento'] ?? '';
    $pais = $_POST['pais'] ?? '';
    $codigo_postal = $_POST['codigo_postal'] ?? '';
    $lugar_residencia = $_POST['lugar_residencia'] ?? '';

    // =========================
    // TRABAJO
    // =========================
    $empresa = $_POST['empresa'] ?? '';
    $cargo = $_POST['cargo'] ?? '';
    $direccion_trabajo = $_POST['direccion_trabajo'] ?? '';
    $telefono_trabajo = $_POST['telefono_trabajo'] ?? '';

    // =========================
    // DISPOSITIVOS
    // =========================
    $marca_celular = $_POST['marca_celular'] ?? '';
    $modelo_celular = $_POST['modelo_celular'] ?? '';
    $imei = $_POST['imei'] ?? '';

    $marca_computadora = $_POST['marca_computadora'] ?? '';
    $modelo_computadora = $_POST['modelo_computadora'] ?? '';
    $numero_serie_pc = $_POST['numero_serie_pc'] ?? '';

    // =========================
    // REDES SOCIALES
    // =========================
    $facebook = $_POST['facebook'] ?? '';
    $instagram = $_POST['instagram'] ?? '';
    $tiktok = $_POST['tiktok'] ?? '';
    $x = $_POST['x'] ?? '';
    $youtube = $_POST['youtube'] ?? '';
    $linkedin = $_POST['linkedin'] ?? '';
    $github = $_POST['github'] ?? '';
    $telegram = $_POST['telegram'] ?? '';
    $whatsapp = $_POST['whatsapp'] ?? '';

    // =========================
    // VEHÍCULO
    // =========================
    $placa_carro = $_POST['placa_carro'] ?? '';
    $modelo_carro = $_POST['modelo_carro'] ?? '';

    // =========================
    // INFORMACIÓN ADICIONAL
    // =========================
    $estado_civil = $_POST['estado_civil'] ?? '';
    $profesion = $_POST['profesion'] ?? '';
    $nivel_estudios = $_POST['nivel_estudios'] ?? '';
    $observaciones = $_POST['observaciones'] ?? '';

    // =========================
    // IMÁGENES
    // =========================
    $dir_perfiles = "uploads/perfiles/";
    $dir_docs = "uploads/documentos/";

    if (!is_dir($dir_perfiles)) mkdir($dir_perfiles, 0777, true);
    if (!is_dir($dir_docs)) mkdir($dir_docs, 0777, true);

    $foto_perfil = null;
    $foto_documento_frontal = null;
    $foto_documento_trasera = null;

    if (!empty($_FILES['foto_perfil']['name'])) {
        $ext = pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);
        $foto_perfil = $dir_perfiles . uniqid("PERFIL_") . "." . $ext;
        move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $foto_perfil);
    }

    if (!empty($_FILES['foto_documento_frontal']['name'])) {
        $ext = pathinfo($_FILES['foto_documento_frontal']['name'], PATHINFO_EXTENSION);
        $foto_documento_frontal = $dir_docs . uniqid("DOC_F_") . "." . $ext;
        move_uploaded_file($_FILES['foto_documento_frontal']['tmp_name'], $foto_documento_frontal);
    }

    if (!empty($_FILES['foto_documento_trasera']['name'])) {
        $ext = pathinfo($_FILES['foto_documento_trasera']['name'], PATHINFO_EXTENSION);
        $foto_documento_trasera = $dir_docs . uniqid("DOC_T_") . "." . $ext;
        move_uploaded_file($_FILES['foto_documento_trasera']['tmp_name'], $foto_documento_trasera);
    }

    // =========================
    // INSERT SQL COMPLETO
    // =========================
    $sql = "INSERT INTO personas (
        nombre, apellido, tipo_documento, numero_documento, fecha_nacimiento, genero, nacionalidad,
        telefono, telefono_secundario, correo, direccion, ciudad, departamento, pais, codigo_postal,
        lugar_residencia, empresa, cargo, direccion_trabajo, telefono_trabajo,
        marca_celular, modelo_celular, imei,
        marca_computadora, modelo_computadora, numero_serie_pc,
        facebook, instagram, tiktok, x, youtube, linkedin, github, telegram, whatsapp,
        foto_perfil, foto_documento_frontal, foto_documento_trasera,
        estado_civil, profesion, nivel_estudios, observaciones,
        placa_carro, modelo_carro
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        str_repeat("s", 44),
        $nombre, $apellido, $tipo_documento, $numero_documento, $fecha_nacimiento, $genero, $nacionalidad,
        $telefono, $telefono_secundario, $correo, $direccion, $ciudad, $departamento, $pais, $codigo_postal,
        $lugar_residencia, $empresa, $cargo, $direccion_trabajo, $telefono_trabajo,
        $marca_celular, $modelo_celular, $imei,
        $marca_computadora, $modelo_computadora, $numero_serie_pc,
        $facebook, $instagram, $tiktok, $x, $youtube, $linkedin, $github, $telegram, $whatsapp,
        $foto_perfil, $foto_documento_frontal, $foto_documento_trasera,
        $estado_civil, $profesion, $nivel_estudios, $observaciones,
        $placa_carro, $modelo_carro
    );

    if ($stmt->execute()) {
        header("Location: ../datos.php?msg=ok");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>