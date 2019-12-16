<?php
session_start();
require 'funciones\comunes.php';

if(!isset($_SESSION['idusuario']) && !isset($_SESSION['tipo']) && $_SESSION['tipo'] !== '1'){
    header('location:index.php');
}
$array = ['nombre', 'telefono', 'fecha_nacimiento', 'carrera', 'ingles', 'disponibilidad'];
if(!validarArray($_POST, $array)){
    //header('location:index.php');
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
    $foto = $urllogo != '' ? ", logo = '$urllogo'" : '';
    $sql = "UPDATE info_empresa SET  nombre = '$nombre', rfc = '$rfc', numero_sat = '$numero_sat', estado = '$estado', ciudad = '$ciudad',
            direccion = '$direccion', tipo_empresa = '$tipo_empresa', introduccion = '$descripcion', sitio_web = '$sitio_web',
             nombre_contacto = '$nombre_contacto', telefono_contacto = '$telefono_contacto' ".$foto." WHERE idempresa = '$idempresa'";
    $result = $con->query($sql);
    if($result){
        unset($_SESSION['error']);
        header('location:perfil.php');
    }else{
        $_SESSION['error'] = 'No se pudo guardar la informacion.';
        header('location:perfil.php');
    }

}