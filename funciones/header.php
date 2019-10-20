<?php
$perfil = isset($_SESSION['idusuario']) ? '<li class="nav-item">
<a class="nav-link" href="#" tabindex="-1" aria-disabled="true">Perfil</a>
</li>' : '';
$salir = isset($_SESSION['idusuario']) ? '<a class="btn btn-sm btn-outline-secondary" href="salir.php">Salir</a>' :
 '<button class="btn btn-sm btn-outline-secondary" type="button">Entrar</button>
 <button class="btn btn-sm btn-outline-secondary" type="button">Registrarse</button>';
echo '<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Empleos</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
            <a class="nav-link" href="#">Inicio <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">Empleos</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">Empresas</a>
            </li>
            '.$perfil.'
        </ul>
        <ul class="nav justify-content-end">
        '.$salir.'
        </ul>
        </div>
    </nav>';