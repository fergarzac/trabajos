<?php
session_start();
require 'funciones\comunes.php';

if(!isset($_POST['usuario']) && !isset($_POST['password'])){
    die(':(');
}
//Establecer conexion
$con = getConnection();
if($con !== null) {
    //Limpiar los datos que sean string
    $data = clearData($_POST);
    $usuario = $data['usuario'];
    $pass = $data['password'];
    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND password = '$pass'";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        $res = $result->fetch_assoc();
        $_SESSION['idusuario'] = $res['idusuarios'];
        $_SESSION['nombre'] = $res['nombre'];
        $_SESSION['tipo'] = $res['tipo'];
        unset($_SESSION['error']);
        header('location:dashboard.php');
    }else{
        $_SESSION['error'] = 'Usuario y/o contraseña invalidos';
        header('location:index.php');
    }
}