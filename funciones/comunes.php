<?php
function getConnection() {
    $server = 'localhost';
    $user = 'root';
    $pass = '';
    $db = 'empleos';
    $con = mysqli_connect($server, $user, $pass, $db);
    if (mysqli_connect_errno())
    {
        return false;
    }
    return $con;
}

function clearData($data){
    $res = [];
    foreach($data as $id => $str) {
        $res[$id] = filter_var($str, FILTER_SANITIZE_STRING);
    }
    return $res;
}


function todosLosEmpleos() {
    $con = getConnection();
    if($con !== null) {
        $sql = "SELECT * FROM empleos";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    return false;
}

function empleosByEmpresa($id = 0) {
    $con = getConnection();
    $id = intval($id);
    if($con !== null && $id > 0) {
        $sql = "SELECT * FROM empleos where idempresa = '$id'";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    return false;
}

function validarArray($fuente, $array) {
    foreach($array as $data) {
        if(!array_key_exists($data, $fuente)) {
            return false;
        }
    }
    return true;
}