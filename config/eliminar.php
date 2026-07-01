<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ./login.php");
    exit;
}

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "gestion_personas");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Validar ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID no válido");
}

$id = intval($_GET['id']);

// Preparar eliminación
$sql = "DELETE FROM personas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: ../datos.php?msg=eliminado");
    exit;
} else {
    echo "Error al eliminar: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>