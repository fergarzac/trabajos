<?php
session_start();
require 'funciones\comunes.php';

if(!isset($_SESSION['idusuario']) && !isset($_SESSION['tipo']) && $_SESSION['tipo'] !== '2'){
    header('location:index.php');
}
$array = ['idempleo'];
if(!validarArray($_POST, $array)){
    header('location:index.php');
}

//Establecer conexion
$con = getConnection();
if($con !== null) {
    $data = clearData($_POST);
    $idempleo = $_POST['idempleo'];
    if(validarEstadoEmpleo($idempleo)) {
        $idusuario = $_SESSION['idusuario'];
        $sql = "DELETE FROM postulaciones WHERE idusuario = '$idusuario' AND idempleo = '$idempleo'";
        $result = $con->query($sql);
        if($result) {
            unset($_SESSION['error']);
            header('location:dashboard.php');
        }else{
            $_SESSION['error'] = 'No te pudiste postular a este empleo.';
            header('location:dashboard.php');
        }
    }else {
        $_SESSION['error'] = 'Empleo ya no esta disponible.';
        header('location:dashboard.php');
    }
}else {
    $_SESSION['error'] = 'Ocurrio un error.';
    header('location:dashboard.php');
}