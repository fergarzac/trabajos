<?php

$title = 'Inicio';
require 'funciones/head.php';
if (!isset($_SESSION['idusuario'])) {
    header('location:dashboard.php');
}
require 'funciones/header.php';
$validate = isset($_GET['toValidate']) && $_GET['toValidate'] == 1 || !isUserValidated($_SESSION['idusuario']);
if(!$validate) {
    if($_SESSION['tipo'] == "1"){
        $data = empresasById($_SESSION['idusuario']);
    }else{
        $data = getUserInfo($_SESSION['idusuario']);
        $isAdmin = $data['carrera'] == "Administacion" ? "selected" : "";
        $isGestion = $data['carrera'] == "Gestion Empresarial" ? "selected" : "";
        $isAlimentarias = $data['carrera'] == "Industrias Alimentarias" ? "selected" : "";
        $isGastronomia = $data['carrera'] == "Gastronomia" ? "selected" : "";
        $isElectro = $data['carrera'] == "Electromecanica" ? "selected" : "";
        $isIndustrial = $data['carrera'] == "Industrial" ? "selected" : "";
        $isSistemas = $data['carrera'] == "Sistemas" ? "selected" : "";
        $isArquitectura = $data['carrera'] == "Arquitectura" ? "selected" : "";
        $checked = $data['disponibilidad_viajar'] == "1" ? "checked" : "";
        $basico = $data['ingles'] == "Basico" ? "selected" : "";
        $intermedio = $data['ingles'] == "Intermedio" ? "selected" : "";
        $avanzado = $data['ingles'] == "Avanzado" ? "selected" : "";
    }
}
?>
<?php
    if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 1) {
?>
        <div class="container">
            <div class="row">
                <div class="col-md-9" style="background: #f8f9fa; margin-top: 10px">
                    <h1>Perfil</h1>
                    <?php
                    if ($validate) {
                        echo '<div class="col-md-12" style="margin-top: 15px"><div class="alert alert-warning" role="alert">
                          Llena los datos.
                        </div></div>';
                    }
                    ?>
                    <form enctype="multipart/form-data" action="<?php echo $validate ? 'validar_empresa.php' : 'modificar_empresa.php'?>" method="POST" onsubmit="return ValidarDatos()">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo isset($data) && !empty($data) ? $data['nombre'] : '' ?>"
                                           placeholder="Ingresa el nombre de la empresa" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="password">RFC</label>
                                    <input type="text" class="form-control" name="rfc" id="rfc" value="<?php echo isset($data) && !empty($data) ? $data['rfc'] : '' ?>"
                                           placeholder="Ingresa el RFC" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="password">Número de SAT</label>
                                    <input type="text" class="form-control" name="sat" id="sat" value="<?php echo isset($data) && !empty($data) ? $data['numero_sat'] : '' ?>"
                                           placeholder="Ingresa el Número de SAT" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="password">Tipo de Empresa</label>
                                    <input type="text" class="form-control" name="tipo_empresa" id="tipo_empresa" value="<?php echo isset($data) && !empty($data) ? $data['tipo_empresa'] : '' ?>"
                                           placeholder="Ingresa el giro de la empresa" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="password">Estado</label>
                                    <input type="text" class="form-control" name="estado" id="estado" value="<?php echo isset($data) && !empty($data) ? $data['estado'] : '' ?>"
                                           placeholder="Ingresa el estado" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="password">Ciudad</label>
                                    <input type="text" class="form-control" name="ciudad" id="ciudad" value="<?php echo isset($data) && !empty($data) ? $data['ciudad'] : '' ?>"
                                           placeholder="Ingresa la ciudad" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="password">Direccion</label>
                                    <input type="text" class="form-control" name="direccion" id="direccion" value="<?php echo isset($data) && !empty($data) ? $data['direccion'] : '' ?>"
                                           placeholder="Ingresa la dirección" autocomplete="off" required>
                                    <input type="file" name="logo" id="logo" style="display: none" onchange="javascript:changeImg()" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Contacto</h5>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="password">Nombre y apellido</label>
                                            <input type="text" class="form-control" name="nombre_contacto" id="nombre_contacto" value="<?php echo isset($data) && !empty($data) ? $data['nombre_contacto'] : '' ?>"
                                                   placeholder="Ingresa el nombre completo del contacto" autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="password">Telefono</label>
                                            <input type="text" class="form-control" name="telefono_contacto" id="telefono_contacto" value="<?php echo isset($data) && !empty($data) ? $data['telefono_contacto'] : '' ?>"
                                                   placeholder="Ingresa el telefono del contacto" autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="password">Sitio web</label>
                                            <input type="text" class="form-control" name="sitio_web" id="sitio_web" value="<?php echo isset($data) && !empty($data) ? $data['sitio_web'] : '' ?>"
                                                   placeholder="Ingresa el sitio web" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="usuario">Descripcion</label>
                                    <textarea class="form-control rounded-0" name="descripcion" id="descripcion"
                                              rows="10" required"><?php echo isset($data) && !empty($data) ? $data['introduccion'] : '' ?></textarea>
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
                <div class="col-md-3" style="background: #f8f9fa; margin-top: 10px">
                    <img id="imglogo" src="<?php echo isset($data['logo']) && !empty($data['logo']) ? $data['logo'] : 'https://via.placeholder.com/150'; ?>" width="100%">

                    <button style="width: 100%; margin-top: 10px" type="button" onclick="document.getElementById('logo').click(); return false;" class="btn btn-primary">Seleccionar Logo</button>
                </div>
            </div>
        </div>
<?php
    }else{
?>
<div class="container">
    <div class="row">
        <div class="col-md-8" style="background: #f8f9fa;margin: 10px">
            <h1>Perfil</h1>
            <?php
            if ($validate) {
                echo '<div class="col-md-12" style="margin-top: 15px"><div class="alert alert-warning" role="alert">
                          Llena los datos.
                        </div></div>';
            }

            if(isset($_SESSION['notificacion'])){
                echo '<div class="col-md-12" style="margin-top: 15px"><div class="alert alert-success" role="alert">
                          Perfil actualizado.
                        </div></div>';
            }
            ?>
            <form enctype="multipart/form-data" action="<?php echo $validate ? 'validar_usuario.php' : 'modificar_usuario.php'?>" method="POST" onsubmit="return ValidarDatosUsuario()">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="password">Nombre</label>
                            <input type="text" class="form-control" name="nombre" id="nombre"
                                   placeholder="Ingresa tu nombre" value="<?php echo isset($data) && !empty($data) ? $data['nombre'] : '' ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="password">Telefono</label>
                            <input type="text" class="form-control" name="telefono" id="telefono"
                                   placeholder="Ingresa tu telefono" value="<?php echo isset($data) && !empty($data) ? $data['telefono'] : '' ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" value="<?php echo isset($data) && !empty($data) ? $data['fecha_nacimiento'] : '' ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="carrera">Carrera</label>
                            <select class="form-control" name="carrera" id="carrera" value="">
                                <option value="0" disabled <?php echo !isset($data) ? 'selected' : '' ?>>-- Selecciona tu carrera --</option>
                                <option value="1" <?php echo isset($isAdmin) ? $isAdmin : '' ?>>Lic. en Administación</option>
                                <option value="2" <?php echo isset($isGestion) ? $isGestion : '' ?>>Ing. en Gestion Empresarial</option>
                                <option value="3" <?php echo isset($isAlimentarias) ? $isAlimentarias : '' ?>>Ing. en Industrias Alimentarias</option>
                                <option value="4" <?php echo isset($isGastronomia) ? $isGastronomia : '' ?>>Gastronomia</option>
                                <option value="5" <?php echo isset($isElectro) ? $isElectro : '' ?>>Ing. Electromecanica</option>
                                <option value="6" <?php echo isset($isIndustrial) ? $isIndustrial : '' ?>>Ing. Industrial</option>
                                <option value="7" <?php echo isset($isSistemas) ? $isSistemas : '' ?>>Ing. en Sistemas Computacionales</option>
                                <option value="8" <?php echo isset($isArquitectura) ? $isArquitectura : '' ?>>Arquitectura</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ingles">Ingles</label>
                            <select class="form-control" name="ingles" id="ingles">
                                <option value="0" disabled <?php echo !isset($data) ? 'selected' : '' ?>>-- Selecciona tu nivel de ingles --</option>
                                <option value="1" <?php echo isset($basico) ? $basico : '' ?>>Basico</option>
                                <option value="2" <?php echo isset($intermedio) ? $intermedio : '' ?>>Intermedio</option>
                                <option value="3" <?php echo isset($avanzado) ? $avanzado : '' ?>>Avanzado</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="custom-control custom-checkbox" style="margin-top: 40px">
                            <input type="checkbox" class="custom-control-input" id="disponibilidad" name="disponibilidad" <?php echo isset($checked) ? $checked : '' ?>>
                            <label class="custom-control-label" for="disponibilidad">Disponibilidad para viajar</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php
                        if(isset($data) && isset($data['curriculum'])){
                            echo '<div class="col-md-12">
                                    <a target="_blank" href="'.$data['curriculum'].'">Ver curriculum actual</a>
                                </div>';
                        }
                    ?>
                    <div class="col-md-12">
                        <label>Curriculum</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="curriculum" name="curriculum">
                            <label class="custom-file-label" for="curriculum">Selecciona tu curriculum</label>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 20px">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary"
                                style="width: 100%; margin-bottom: 20px"><?php echo($validate ? 'Validar' : 'Modificar'); ?></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-3" style="background: #f8f9fa;margin: 10px">
            <?php
            if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 1) {
                $enabled = isset($_SESSION['validado']) && $_SESSION['validado'] == 0 ? 'data-toggle="tooltip" data-placement="top" title="Necesitas validar tu cuenta"' : '';
                echo '<button type="button" class="btn btn-primary col-md-12" style="margin-top: 15px" onclick="javascript:openModal(\'agregar_empleo\', ' . $_SESSION['validado'] . ')" ' . $enabled . '>Agregar Empleo</button>';
            } else {
                echo ' <div style="margin-top: 50px"></div><h3>Postulaciones</h3>';
                foreach ($mis_postulaciones as $e) {
                    echo '<div class="card" style="margin: 10px" >
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        '.$e['titulo'].'
                                    </div>
                                    <div class="col-md-2">
                                        <a href="empleo.php?id=' . $e['idempleo'] . '"  style="float: right">
                                            <i class="fas fa-chevron-circle-right" style="font-size: 20pt"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>';
                }
                echo '</div>';
            }
            ?>
        </div>
    </div>
</div>
<?php
    }
require 'funciones/footer.php';
?>
