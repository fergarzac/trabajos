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