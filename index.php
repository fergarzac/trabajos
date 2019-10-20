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
            <input type="text" class="input-buscar" placeholder="Buscar Trabajo" />
            <div class="btn-buscar">Buscar</div>
            <div class="row" style="margin-top: 10px">
                <?php
                if(!isset($_SESSION['idusuario'])){
                    echo '<div class="col-6"><button type="button" class="btn btn-link" data-toggle="modal" data-target="#iniciar">
                            Iniciar Sesion
                        </button>
                        </div>
                        <div class="col-6" style="text-align: right;">
                            <a href="#">Registrar</a>
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
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Ingresa tu Contraseña">
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
</div>
<?php
require 'funciones/footer.php';
?>