<?php
$script = explode('/', $_SERVER['SCRIPT_FILENAME']);
$actual = end($script);
$label = '<span class="sr-only">(current)</span>';
if(isset($_SESSION['tipo'])) {
    $numNotificaciones = getNumeroNotificationes($_SESSION['idusuario'], $_SESSION['tipo'],  $_SESSION['fecha']);
    $listaNotificaciones = getNotificationes($_SESSION['idusuario'], $_SESSION['tipo'],  $_SESSION['fecha']);
}else{
    $numNotificaciones = 0;
    $listaNotificaciones = [];
}


$noti = '';

foreach ($listaNotificaciones as $n) {
    if($n['visto'] == 1){
        $noti .= '<a class="dropdown-item" href="empleo.php?id='.$n['idaux'].'">'.$n['nombre'].' '.$n['evento'].' un empleo</a>';
    }else{
        $noti .= '<a class="dropdown-item" href="empleo.php?id='.$n['idaux'].'&fromNotification='.$n['idnotificaciones'].'">'.$n['nombre'].' '.$n['evento'].' un empleo <span class="badge badge-pill badge-primary">Nuevo</span></a>';
    }

}
$perfil = isset($_SESSION['idusuario']) ? '<li class="nav-item">
<a class="nav-link" href="perfil.php" tabindex="-1" aria-disabled="true">Perfil</a>
</li>' : '';

$superadmin = isset($_SESSION['idusuario']) && $_SESSION['tipo'] == "3" ? '<li class="nav-item">
<a class="nav-link" href="metricas.php" tabindex="-1" aria-disabled="true">Metricas</a>
</li>' : '';
$notificaciones = '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
    <h6 class="dropdown-header">Notificaciones</h6>
    '.$noti.'
  </div>';
$salir = isset($_SESSION['idusuario']) ? '<li class="nav-item dropdown"><a href="#" class="nav-link " role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bell"  data-toggle="tooltip" data-placement="left" title="Notificaciones"><span class="badge badge-light">'.$numNotificaciones.'</span></i></a>'.$notificaciones.'</li><li  class="nav-item"><a style="margin-top: 5px" class="btn btn-sm btn-outline-secondary" href="salir.php">Salir</a></li>' :
 '<button class="btn btn-sm btn-outline-secondary" type="button" data-toggle="modal" data-target="#iniciar">Entrar</button>
 <button class="btn btn-sm btn-outline-secondary" type="button" data-toggle="modal" data-target="#registrar">Registrarse</button>';

$modales = !isset($_SESSION['idusuario']) ? '  <div class="modal fade" id="iniciar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Iniciar Sesion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form action="login.php" method="POST">
                    <div class="form-group">
                        <label for="usuario">Email</label>
                        <input type="email" class="form-control" name="usuario" id="usuario" aria-describedby="emailHelp" placeholder="Ingresa tu Email">
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" name="password" id="password_login" placeholder="Ingresa tu Contraseña">
                    </div>
            
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="registrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrarse</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary col-md-12" onclick="seleccion(1)">Empresa</button>   
                        </div>
                        <div class="col-md-12" style="margin-top:10px">
                            <button type="button" class="btn btn-secondary col-md-12" onclick="seleccion(2)">Usuario</button>   
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="registrarse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrarse</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form action="register.php" method="POST" onsubmit="return validation()">
                    <div class="form-group">
                        <label for="usuario">Email</label>
                        <input type="email" class="form-control" name="usuario_registrar" id="usuario_registrar" aria-describedby="emailHelp" placeholder="Ingresa tu usuario">
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" name="password_registrar" id="password_registrar" placeholder="Ingresa tu Contraseña">
                    </div>
                    <div class="form-group">
                        <label for="password">Confirma contraseña</label>
                        <input type="password" class="form-control" name="password_confim" id="password_confim" placeholder="Ingresa de nuevo tu Contraseña">
                    </div>
                    <input type="hidden" class="form-control" name="tipo" id="tipo">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Registrarse</button>
                </div>
                </form>
            </div>
        </div>
    </div>' : '';
echo '<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="dashboard.php">Empleos</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item '.($actual == "dashboard.php" ? 'active' : '').'">
            <a class="nav-link" href="dashboard.php"> '.($actual == "dashboard.php" ? $label : '').'Inicio </a>
            </li>
            <li class="nav-item '.($actual == "empresas.php" ? 'active' : '').'">
            <a class="nav-link" href="empresas.php"> '.($actual == "empresas.php" ? $label : '').'Empresas</a>
            </li>
            '.$perfil.'
            '.$superadmin.'
        </ul>
        <ul class="nav justify-content-end">
        '.$salir.'
        </ul>
        </div>
    </nav>'. $modales;

$mis_postulaciones = isset($_SESSION['idusuario']) ? getMisPostulaciones($_SESSION['idusuario']) : [];
