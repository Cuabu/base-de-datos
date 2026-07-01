<?php

header("Content-Type: application/json");

require "../matrix/config/conexion.php";

$json = file_get_contents("php://input");

if (empty($json)) {

    http_response_code(400);

    echo json_encode([
        "estado"=>"error",
        "mensaje"=>"No se recibieron datos"
    ]);

    exit;
}

$datos = json_decode($json,true);

if(!$datos){

    http_response_code(400);

    echo json_encode([
        "estado"=>"error",
        "mensaje"=>"JSON inválido"
    ]);

    exit;
}

$sql = $conexion->prepare("
INSERT INTO dispositivos
(
hostname,
usuario,
sistema,
version,
arquitectura,
ip,
cpu,
ram_total,
ram_usada,
ram_porcentaje,
disco_total,
disco_libre,
disco_porcentaje
)
VALUES
(
?,?,?,?,?,?,?,?,?,?,?,?,?
)
");

$sql->execute([

$datos["hostname"],

$datos["usuario"],

$datos["sistema"],

$datos["version"],

$datos["arquitectura"],

$datos["ip"],

$datos["cpu"],

$datos["ram_total_mb"],

$datos["ram_usada_mb"],

$datos["ram_porcentaje"],

$datos["disco_total_gb"],

$datos["disco_libre_gb"],

$datos["disco_porcentaje"]

]);

echo json_encode([

"estado"=>"ok",

"mensaje"=>"Datos recibidos"

]);