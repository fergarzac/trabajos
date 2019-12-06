<?php
session_start();
require 'funciones\comunes.php';

if(!isset($_GET['idusuario']) && !isset($_GET['idempleo']) && !isset($_SESSION['tipo']) && $_SESSION['tipo'] !== '1'){
    header('location:index.php');
}

//Establecer conexion
$con = getConnection();
if($con !== null) {
    //Limpiar los datos que sean string
    $data = clearData($_POST);
    $idusuario = $data['idusuario'];
    $idempleo = $data['idempleo'];
    $idempresa = $_SESSION['idusuario'];
    $sql = "INSERT INTO seleccionado(idusuario, idempleo, idempresa) VALUES ('$idusuario', '$idempleo','$idempresa')";
    $result = $con->query($sql);
    if($result) {
        $_SESSION['notificacion'] = "Seleccionado";
        unset($_SESSION['error']);
    }else{
        $_SESSION['error'] = "Ocurrio un error.";
        unset($_SESSION['notificacion']);
    }
    header('location:empleo.php?id='.$idempleo);
}