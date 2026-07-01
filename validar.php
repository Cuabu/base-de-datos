<?php

session_start();

require './config/conexion.php';

$usuario = trim($_POST['usuario']);
$password = trim($_POST['password']);

$sql = "SELECT * FROM administrador
        WHERE usuario = :usuario
        AND estado = 'Activo'";

$stmt = $conexion->prepare($sql);

$stmt->bindParam(":usuario", $usuario);

$stmt->execute();

if ($stmt->rowCount() == 1) {

    $datos = $stmt->fetch(PDO::FETCH_ASSOC);

    if (password_verify($password, $datos['password'])) {

        // Actualizar último acceso
        $actualizar = $conexion->prepare("
            UPDATE administrador
            SET ultimo_acceso = NOW()
            WHERE id = :id
        ");

        $actualizar->bindParam(":id", $datos['id']);
        $actualizar->execute();

        session_regenerate_id(true);

        $_SESSION['id'] = $datos['id'];
        $_SESSION['nombre'] = $datos['nombre'];
        $_SESSION['apellido'] = $datos['apellido'];
        $_SESSION['usuario'] = $datos['usuario'];
        $_SESSION['correo'] = $datos['correo'];
        $_SESSION['rol'] = $datos['rol'];

        header("Location: ./dashboard.php");
        exit;

    } else {

        header("Location: ./login.php");
        exit;

    }

} else {

    header("Location: ./login.php");
    exit;

}