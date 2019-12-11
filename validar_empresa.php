<?php
session_start();
require 'funciones\comunes.php';

if(!isset($_SESSION['idusuario']) && !isset($_SESSION['tipo']) && $_SESSION['tipo'] !== '1'){
    header('location:index.php');
}
$array = ['rfc', 'nombre', 'sat', 'estado', 'ciudad', 'direccion', 'tipo_empresa', 'descripcion', 'sitio_web', 'nombre_contacto', 'telefono_contacto'];
if(!validarArray($_POST, $array)){
    header('location:index.php');
}

//Establecer conexion
$con = getConnection();
if($con !== null) {
    //Limpiar los datos que sean string
    $data = clearData($_POST);
    $rfc = $_POST['rfc'];
    $nombre = $_POST['nombre'];
    $numero_sat = $_POST['sat'];
    $estado = $_POST['estado'];
    $ciudad = $_POST['ciudad'];
    $direccion = $_POST['direccion'];
    $tipo_empresa = $_POST['tipo_empresa'];
    $descripcion = $_POST['descripcion'];
    $sitio_web = $_POST['sitio_web'];
    $nombre_contacto = $_POST['nombre_contacto'];
    $telefono_contacto = $_POST['telefono_contacto'];
    $idempresa = $_SESSION['idusuario'];
    $uploadCurriculum = isset($_FILES['logo']) && !empty($_FILES['logo']) ? uploadFile($_FILES['logo']) : ['status' => 0];
    $urllogo = $uploadCurriculum['status'] == 1 ? $uploadCurriculum['dir'] : '';
    $sql = "INSERT INTO info_empresa(idempresa, nombre, rfc, numero_sat, estado, ciudad, direccion, tipo_empresa, introduccion, sitio_web, nombre_contacto, telefono_contacto, logo) VALUES 
            ('$idempresa', '$nombre', '$rfc', '$numero_sat', '$estado', '$ciudad', '$direccion', '$tipo_empresa', '$descripcion', '$sitio_web', '$nombre_contacto', '$telefono_contacto', '$urllogo')";
    $result = $con->query($sql);
    if($result) {
        $sql2 = "UPDATE usuarios SET validado = 2 WHERE idusuarios = '$idempresa'";
        $result2 = $con->query($sql2);
        if($result2) {
            unset($_SESSION['error']);
            $_SESSION['validado'] = 2;
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