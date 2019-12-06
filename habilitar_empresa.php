<?php
session_start();
require 'funciones\comunes.php';

if(!isset($_SESSION['idusuario']) && !isset($_SESSION['tipo']) && $_SESSION['tipo'] !== '3'){
    header('location:index.php');
}

if(!isset($_POST['idempresa']) && !isset($_POST['tipo'])){
    header('location:index.php');
}

//Establecer conexion
$con = getConnection();
if($con !== null) {
    //Limpiar los datos que sean string
    $data = clearData($_POST);
    $tipo = $_POST['tipo'];
    $idempresa = $_POST['idempresa'];
    $sql = "UPDATE usuarios SET validado = '$tipo' WHERE idusuarios = '$idempresa'";
    $result = $con->query($sql);
    if($result) {
        unset($_SESSION['error']);
        header('location:metricas.php');
    }else{
        $_SESSION['error'] = 'No se pudo crear el empleo';
        header('location:metricas.php');
    }
}