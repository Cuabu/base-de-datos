<?php

session_start();

require './config/conexion.php';

$usuario = trim($_POST['usuario']);
$password = trim($_POST['password']);

$sql = "SELECT * FROM usuarios WHERE usuario = :usuario";

$stmt = $conexion->prepare($sql);

$stmt->bindParam(":usuario",$usuario);

$stmt->execute();

if($stmt->rowCount()==1){

$datos = $stmt->fetch(PDO::FETCH_ASSOC);

if(password_verify($password,$datos['password'])){

session_regenerate_id(true);

$_SESSION['id']=$datos['id'];
$_SESSION['nombre']=$datos['nombre'];
$_SESSION['usuario']=$datos['usuario'];

header("Location: ./dashboard.php");
exit;

}else{

header("Location: ./login.php");

}

}else{

header("Location: ./login.php");

}