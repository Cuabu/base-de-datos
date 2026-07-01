<?php
require './config/conexion.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre    = trim($_POST['nombre']);
    $apellido  = trim($_POST['apellido']);
    $usuario   = trim($_POST['usuario']);
    $correo    = trim($_POST['correo']);
    $password  = trim($_POST['password']);

    $rol = "Operador";
    $estado = "Activo";

    if (
        !empty($nombre) &&
        !empty($apellido) &&
        !empty($usuario) &&
        !empty($correo) &&
        !empty($password)
    ) {

        // Verificar si el usuario ya existe
        $consulta = $conexion->prepare("SELECT id FROM administrador WHERE usuario = ?");
        $consulta->execute([$usuario]);

        if ($consulta->rowCount() > 0) {

            $mensaje = '<div class="alert alert-danger">
                            El usuario ya existe.
                        </div>';

        } else {

            // Encriptar contraseña
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // Insertar administrador
            $insertar = $conexion->prepare("
                INSERT INTO administrador
                (
                    nombre,
                    apellido,
                    usuario,
                    correo,
                    password,
                    rol,
                    estado
                )
                VALUES
                (
                    ?, ?, ?, ?, ?, ?, ?
                )
            ");

            if ($insertar->execute([
                $nombre,
                $apellido,
                $usuario,
                $correo,
                $passwordHash,
                $rol,
                $estado
            ])) {

                $mensaje = '<div class="alert alert-success">
                                Administrador registrado correctamente.
                            </div>';

            } else {

                $mensaje = '<div class="alert alert-danger">
                                Error al registrar el administrador.
                            </div>';

            }

        }

    } else {

        $mensaje = '<div class="alert alert-warning">
                        Complete todos los campos.
                    </div>';

    }

}
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Registrar Administrador</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<!-- Barra de navegación -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">

    <div class="container">

        <a class="navbar-brand" href="index.php">
            Mi Sistema
        </a>

        <div>

            <a href="login.php" class="btn btn-outline-light me-2">
                Iniciar Sesión
            </a>

            <a href="registro.php" class="btn btn-warning">
                Registrarse
            </a>

        </div>

    </div>

</nav>

<body class="bg-light">

<div class="container">

<div class="row justify-content-center mt-5">

<div class="col-md-5">

<div class="card shadow">

<div class="card-header bg-success text-white text-center">

<h3>Registrar Administrador</h3>

</div>

<div class="card-body">

<?php echo $mensaje; ?>

<form method="POST">

<div class="mb-3">

<label class="form-label">Nombre</label>

<input
type="text"
name="nombre"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">Apellido</label>

<input
type="text"
name="apellido"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">Correo electrónico</label>

<input
type="email"
name="correo"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">Usuario</label>

<input
type="text"
name="usuario"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">Contraseña</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<button
type="submit"
class="btn btn-success w-100">

Registrar Administrador

</button>

</form>

</div>

</div>

</div>

</div>

</div>

</body>

</html>