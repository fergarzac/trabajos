<?php
session_start();
require 'funciones\comunes.php';

if(!isset($_POST['nombre']) && !isset($_POST['usuario_registrar']) && !isset($_POST['password_registrar']) && !isset($_POST['tipo'])){
    header('location:index.php');
}

//Establecer conexion
$con = getConnection();
if($con !== null) {
    //Limpiar los datos que sean string
    $data = clearData($_POST);
    $nombre = $data['nombre'];
    $usuario = $data['usuario_registrar'];
    $pass = $data['password_registrar'];
    $tipo = $data['tipo'];
    $sql = "INSERT INTO usuarios(nombre, usuario, password, tipo) VALUES ('$nombre', '$usuario','$pass', '$tipo')";
    $result = $con->query($sql);
    if($result) {
        $sql2 = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
        $result2 = $con->query($sql2);
        $res = $result2->fetch_assoc();
        $_SESSION['idusuario'] = $res['idusuarios'];
        $_SESSION['nombre'] = $res['nombre'];
        $_SESSION['tipo'] = $res['tipo'];
        unset($_SESSION['error']);
        header('location:dashboard.php');
    }else{
        $_SESSION['error'] = 'No se pudo crear el usuario';
        header('location:index.php');
    }
}else{
    $_SESSION['error'] = 'Error en la conexion a la base de datos';
        header('location:index.php');
}