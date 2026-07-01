<?php

function ejecutar($cmd)
{
    return trim(shell_exec($cmd));
}

$datos = [

    "hostname" => gethostname(),

    "usuario" => getenv("USER"),

    "php" => phpversion(),

    "sistema" => php_uname("s"),

    "kernel" => php_uname("r"),

    "arquitectura" => php_uname("m"),

    "fecha" => date("Y-m-d H:i:s"),

    "memoria" => ejecutar("cat /proc/meminfo | head -5"),

    "cpu" => ejecutar("cat /proc/cpuinfo | head -20"),

    "almacenamiento" => ejecutar("df -h"),

    "uptime" => ejecutar("uptime"),

    "ip" => ejecutar("ip addr"),

];

echo json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);