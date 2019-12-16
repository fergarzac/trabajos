<?php
session_start();
require 'autoload.php';
require 'comunes.php';

if(isset($_SESSION['idusuario'])){
    $_SESSION['validado'] = updateValidado($_SESSION['idusuario']);
}
if(isset($_GET['fromNotification']) && !empty($_GET['fromNotification']) && isset($_SESSION['idusuario'])){
    marcarLeidaNotificacion($_SESSION['idusuario'], $_GET['fromNotification']);
}

echo '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>'.(!empty($title) ? $title : 'Pagina desconocida').'</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
            <link rel="stylesheet" type="text/css" href="recursos/css/style.css">
            <script src="recursos/js/scripts.js"></script>
            <script src="https://kit.fontawesome.com/e1919c653d.js" crossorigin="anonymous"></script>
        </head>
        <body>
';