<?php
require './config/conexion.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = trim($_POST['nombre']);
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);

    if (!empty($nombre) && !empty($usuario) && !empty($password)) {

        // Verificar si el usuario ya existe
        $consulta = $conexion->prepare("SELECT id FROM usuarios WHERE usuario = ?");
        $consulta->execute([$usuario]);

        if ($consulta->rowCount() > 0) {

            $mensaje = '<div class="alert alert-danger">
                            El usuario ya existe.
                        </div>';

        } else {

            // Encriptar contraseña
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // Insertar usuario
            $insertar = $conexion->prepare("INSERT INTO usuarios(nombre, usuario, password)
                                           VALUES(?,?,?)");

            if ($insertar->execute([$nombre, $usuario, $passwordHash])) {

                $mensaje = '<div class="alert alert-success">
                                Usuario registrado correctamente.
                            </div>';

            } else {

                $mensaje = '<div class="alert alert-danger">
                                Error al registrar el usuario.
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

<title>Registrar Usuario</title>

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

<h3>Registrar Usuario</h3>

</div>

<div class="card-body">

<?php echo $mensaje; ?>

<form method="POST">

<div class="mb-3">

<label class="form-label">Nombre Completo</label>

<input
type="text"
name="nombre"
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

Registrar Usuario

</button>

</form>

</div>

</div>

</div>

</div>

</div>

</body>

</html>