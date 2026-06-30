<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="./css/styles.css">

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

<body>

<div class="container">

<div class="row justify-content-center">

<div class="col-md-4">

<div class="card shadow mt-5">

<div class="card-header text-center bg-primary text-white">

<h3>Iniciar Sesión</h3>

</div>

<div class="card-body">

<form action="./validar.php" method="POST">

<div class="mb-3">

<label>Usuario</label>

<input
type="text"
name="usuario"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Contraseña</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<button class="btn btn-primary w-100">

Ingresar

</button>

</form>

</div>

</div>

</div>

</div>

</div>

</body>

</html>