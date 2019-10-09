<?php
session_start();
require 'autoload.php';
require 'comunes.php';

echo '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>'.(!empty($title) ? $title : 'Pagina desconocida').'</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
            <link rel="stylesheet" type="text/css" href="recursos/css/style.css">
        </head>
        <body>
';