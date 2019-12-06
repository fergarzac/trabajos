<?php
$title = 'Inicio';
require 'funciones/head.php';
require 'funciones/header.php';
if(!isset($_GET['id']) || empty($_GET['id']) || !isset($_SESSION['tipo']) || $_SESSION['tipo'] == 2){
    header('location:dashboard.php');
}

$data = getUserInfo($_GET['id']);
?>
<div class="container">
    <div class="row">
        <div class="col-md-8" style="background: #f8f9fa;margin: 10px">
            <h1>Postulante</h1>
            <p>
                Nombre: <?php echo $data['nombre']; ?><br>
                Fecha de nacimiento: <?php echo date_format(date_create($data['fecha_nacimiento']), 'd/m/Y') . ' ('.$data['edad'].' años)'; ?><br>
            </p>
        </div>

    </div>
</div>

