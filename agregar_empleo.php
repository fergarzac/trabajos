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
    $tipo_contrato = $_POST['tipo'];
    $idempresa = $_SESSION['idusuario'];
    $sql = "INSERT INTO empleos(titulo, descripcion, sueldo, categoria, tipo_contrato, idempresa) VALUES ('$titulo', '$descripcion','$sueldo','$categoria','$tipo_contrato','$idempresa')";
    $result = $con->query($sql);
    if($result) {
        unset($_SESSION['error']);
        header('location:dashboard.php');
    }else{
        $_SESSION['error'] = 'No se pudo crear el empleo';
        header('location:dashboard.php');
    }
}