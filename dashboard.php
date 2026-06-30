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
    <title>Panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <h3>Panel Principal</h3>
        </div>

        <div class="card-body">

            <h2>
                Bienvenido
                <strong><?php echo $_SESSION['nombre']; ?></strong>
            </h2>

            <hr>

            <a href="./logout.php" class="btn btn-danger">
                Cerrar sesión
            </a>

        </div>

    </div>

</div>

</body>
</html>