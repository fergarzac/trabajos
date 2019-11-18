<?php
session_start();
require 'funciones\comunes.php';

if(!isset($_SESSION['idusuario']) && !isset($_SESSION['tipo']) && $_SESSION['tipo'] !== '1'){
    header('location:index.php');
}
$array = ['nombre', 'telefono'];
if(!validarArray($_POST, $array)){
    header('location:index.php');
}

//Establecer conexion
$con = getConnection();
if($con !== null) {
    //Limpiar los datos que sean string
    $data = clearData($_POST);
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $idusuario = $_SESSION['idusuario'];
    $sql = "INSERT INTO info_usuario(idusuario, nombre, telefono) VALUES ('$idusuario', '$nombre', '$telefono')";
    $result = $con->query($sql);
    if($result) {
        $sql2 = "UPDATE usuarios SET validado = 1 WHERE idusuarios = '$idusuario'";
        $result2 = $con->query($sql2);
        if($result2) {
            unset($_SESSION['error']);
            $_SESSION['validado'] = 1;
            header('location:dashboard.php');
        }else{
            $_SESSION['error'] = 'Pendiente de validacion.';
            header('location:index.php');
        }
    }else{
        $_SESSION['error'] = 'No se pudo guardar la informacion.';
        header('location:index.php');
    }
}