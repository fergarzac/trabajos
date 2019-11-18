<?php
$title = 'Inicio';
require 'funciones/head.php';
require 'funciones/header.php';
$validate = isset($_GET['toValidate']) && $_GET['toValidate'] == 1;
?>
<?php
    if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 1) {
?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <h1>Perfil</h1>
                    <?php
                    if ($validate) {
                        echo '<div class="col-md-12" style="margin-top: 15px"><div class="alert alert-warning" role="alert">
                          Llena los datos.
                        </div></div>';
                    }
                    ?>
                    <form action="validar_empresa.php" method="POST" onsubmit="return ValidarDatos()">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">RFC</label>
                                    <input type="text" class="form-control" name="rfc" id="rfc"
                                           placeholder="Ingresa el RFC">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Pais</label>
                                    <input type="text" class="form-control" name="pais" id="pais"
                                           placeholder="Ingresa el pais">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Estado</label>
                                    <input type="text" class="form-control" name="estado" id="estado"
                                           placeholder="Ingresa el estado">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Ciudad</label>
                                    <input type="text" class="form-control" name="ciudad" id="ciudad"
                                           placeholder="Ingresa la ciudad">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Direccion</label>
                                    <input type="text" class="form-control" name="direccion" id="direccion"
                                           placeholder="Ingresa el sueldo mensual">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Tipo de Empresa</label>
                                    <input type="text" class="form-control" name="tipo_empresa" id="tipo_empresa"
                                           placeholder="Ingresa el sueldo mensual">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="usuario">Descripcion</label>
                                    <textarea class="form-control rounded-0" name="descripcion" id="descripcion"
                                              rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="password">Sitio web</label>
                                    <input type="text" class="form-control" name="sitio_web" id="sitio_web"
                                           placeholder="Ingresa el sueldo mensual">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary"
                                        style="width: 100%; margin-bottom: 20px"><?php echo($validate ? 'Validar' : 'Modificar'); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
<?php
    }else{
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <h1>Perfil</h1>
            <?php
            if ($validate) {
                echo '<div class="col-md-12" style="margin-top: 15px"><div class="alert alert-warning" role="alert">
                          Llena los datos.
                        </div></div>';
            }
            ?>
            <form action="validar_usuario.php" method="POST" onsubmit="return ValidarDatosUsuario()">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Nombre</label>
                            <input type="text" class="form-control" name="nombre" id="nombre"
                                   placeholder="Ingresa tu nombre">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Telefono</label>
                            <input type="text" class="form-control" name="telefono" id="telefono"
                                   placeholder="Ingresa tu telefono">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary"
                                style="width: 100%; margin-bottom: 20px"><?php echo($validate ? 'Validar' : 'Modificar'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
    }
?>
