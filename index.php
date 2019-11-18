<?php
$title = 'Inicio';
require 'funciones/head.php';
?>
<div class="bg">
    <img src="recursos/imagenes/background.jpg" />
</div>
<div class="container-fluid">
    
    <div class="row">
        <div class="buscador">
            <center><h1>Hay 100 trabajos disponibles.</h1></center>
            <form action="dashboard.php" method="GET">
                <input type="text" class="input-buscar" name="buscar" placeholder="Buscar Trabajo" />
                <input type="submit" class="btn-buscar mt" value="Buscar">
            </form>

            <div class="row" style="margin-top: 10px">
                <?php
                if(!isset($_SESSION['idusuario'])){
                    echo '<div class="col-6">
                        <button type="button" class="btn btn-link" data-toggle="modal" data-target="#iniciar">
                            Iniciar Sesion
                        </button>
                        </div>
                        <div class="col-6" style="text-align: right;">
                            <button type="button" class="btn btn-link" data-toggle="modal" data-target="#registrar">
                                Registrarse
                            </button>
                        </div>';
                }else {
                    echo '<div class="col-12" style="text-align: center;">
                            <a href="dashboard.php">Ir al dashboard</a>
                        </div>';
                }

                ?>
            </div>
        </div>
        <?php
            if(isset($_SESSION['error'])) {
                echo '<div class="error"> '.$_SESSION['error'].' </div>';
            }
        ?>
        
    </div>

    <div class="modal fade" id="iniciar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" name="nombre" id="nombre" aria-describedby="emailHelp" placeholder="Ingresa nombre completo o nombre de la empresa">
                    </div>
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
    </div>
</div>
<?php
require 'funciones/footer.php';
?>