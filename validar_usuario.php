<?php
session_start();
require 'funciones\comunes.php';

if(!isset($_SESSION['idusuario']) && !isset($_SESSION['tipo']) && $_SESSION['tipo'] !== '1'){
    header('location:index.php');
}
$array = ['nombre', 'telefono', 'fecha_nacimiento', 'carrera', 'ingles', 'disponibilidad'];
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
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $edad = $_POST['edad'];

    //Calcula tu edad
    $cumpleanos = new DateTime($fecha_nacimiento);
    $hoy = new DateTime();
    $edad = $hoy->diff($cumpleanos)->y;

    $carrera = $_POST['carrera'];
    $ingles = $_POST['ingles'];
    $disponibilidad = $_POST['disponibilidad'] == "on" ? true : false;

    $uploadCurriculum = isset($_FILES['curriculum']) ? uploadFile($_FILES['curriculum']) : ['status' => 0];
    $curriculum = $uploadCurriculum['status'] == 1 ? $uploadCurriculum['dir'] : '';
    $idusuario = $_SESSION['idusuario'];
    $sql = "INSERT INTO info_usuario(idusuario, nombre, telefono, fecha_nacimiento, edad, carrera, ingles, disponibilidad_viajar, curriculum) 
            VALUES ('$idusuario', '$nombre', '$telefono', '$fecha_nacimiento', '$edad', '$carrera', '$ingles', '$disponibilidad', '$curriculum')";

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
        unset($_SESSION['error']);
        header('location:dashboard.php');
    }
}