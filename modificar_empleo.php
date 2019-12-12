<?php
session_start();
require 'funciones\comunes.php';

if(!isset($_SESSION['idusuario']) && !isset($_SESSION['tipo']) && $_SESSION['tipo'] !== '1'){
    header('location:index.php');
}

if(!isset($_POST['puesto']) && !isset($_POST['descripcion']) && !isset($_POST['sueldo'])){
    header('location:index.php');
}

//Establecer conexion
$con = getConnection();
if($con !== null) {
    //Limpiar los datos que sean string
    $data = clearData($_POST);
    $titulo = $_POST['puesto'];
    $descripcion = nl2br($_POST['descripcion']);
    $sueldo = $_POST['sueldo'];
    $categoria = $_POST['categoria'];
    $ciudad = $_POST['ciudad'];
    $estado = $_POST['estado'];
    $vacantes = $_POST['vacantes'];
    $tipo_contrato = $_POST['tipo'] == 0 ? '' : "tipo_contrato = " . $_POST['tipo'] . ",";
    $idempleo = $_POST['idempleo'];
    $sql = "UPDATE empleos SET titulo = '$titulo', descripcion = '$descripcion', sueldo = '$sueldo',ciudad = '$ciudad',
            estado_x = '$estado', categoria = '$categoria', ".$tipo_contrato." vacantes = '$vacantes' WHERE idempleos = '$idempleo'";
    $result = $con->query($sql);
    if($result) {
        unset($_SESSION['error']);
        header('location:empleo.php?id='.$idempleo);
    }else{
        $_SESSION['error'] = 'No se pudo modificar el empleo';
        header('location:empleo.php?id='.$idempleo);
    }
}