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

    //Calcula tu edad
    $cumpleanos = new DateTime($fecha_nacimiento);
    $hoy = new DateTime();
    $edad = $hoy->diff($cumpleanos)->y;

    $carrera = $_POST['carrera'];
    $ingles = $_POST['ingles'];
    $disponibilidad = $_POST['disponibilidad'] == "on" ? true : false;
    $uploadCurriculum = isset($_FILES['curriculum']) ? uploadFile($_FILES['curriculum']) : ['status' => 0];
    $curriculum = $uploadCurriculum['status'] == 1 ? $uploadCurriculum['dir'] : '';
    $cr = $curriculum != '' ? ", curriculum = '$curriculum'" : '';
    $idusuario = $_SESSION['idusuario'];
    $sql = "UPDATE info_usuario SET nombre = '$nombre', telefono = '$telefono', fecha_nacimiento = '$fecha_nacimiento', edad = '$edad', 
            carrera = '$carrera', ingles = '$ingles', disponibilidad_viajar = '$disponibilidad' ".$cr."
            WHERE idusuario = '$idusuario'";

    $result = $con->query($sql);
    if($result) {
        $_SESSION['notificacion'] = "Usuario modificado correctamente";
        unset($_SESSION['error']);
        header('location:perfil.php');
    }else{
        $_SESSION['error'] = "Ocurrio un error.";
        unset($_SESSION['notificacion']);
        header('location:dashboard.php');
    }
}