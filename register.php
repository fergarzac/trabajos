<?php
session_start();
require 'funciones\comunes.php';

if(!isset($_POST['nombre']) && !isset($_POST['usuario_registrar']) && !isset($_POST['password_registrar']) && !isset($_POST['tipo'])){
    header('location:index.php');
}



//Establecer conexion
$con = getConnection();
if($con !== null) {
    //Limpiar los datos que sean string
    $data = clearData($_POST);
    $nombre = $data['nombre'];
    $usuario = $data['usuario_registrar'];
    $pass = $data['password_registrar'];
    $tipo = $data['tipo'];

    //verifica si en caso de ser un alumno el que se quiere registrar, debe ser con un correo del instituto
    if($tipo == "1" || preg_match("/^[a-zA-Z0-9]+@itscc.edu.mx/", $usuario)){
        $sql = "INSERT INTO usuarios(usuario, password, tipo) VALUES ('$usuario','$pass', '$tipo')";
        $result = $con->query($sql);
        if($result) {
            $sql2 = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
            $result2 = $con->query($sql2);
            $res = $result2->fetch_assoc();
            $_SESSION['idusuario'] = $res['idusuarios'];
            $_SESSION['tipo'] = $res['tipo'];
            $_SESSION['fecha'] = $res['creado_el'];
            $_SESSION['validado'] = $res['validado'];
            unset($_SESSION['error']);
            header('location:dashboard.php');
        }else{
            $_SESSION['error'] = 'No se pudo crear el usuario';
            header('location:index.php');
        }
    }else{
        $_SESSION['error'] = 'Tu correo debe ser institucional.';
        header('location:index.php');
    }
}else{
    $_SESSION['error'] = 'Error en la conexion a la base de datos';
        header('location:index.php');
}