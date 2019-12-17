<?php
header('Content-Type: application/json; charset=utf-8');
session_start();
require 'funciones\comunes.php';

if(!isset($_SESSION['idusuario'])){
    header('location:index.php');
}
$array = ['id'];
if(!validarArray($_GET, $array)){
    header('location:index.php');
}
$data = clearData($_GET);

echo json_encode(getCiudades($data['id']), JSON_UNESCAPED_UNICODE);