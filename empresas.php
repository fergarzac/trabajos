<?php
$title = 'Inicio';
require 'funciones/head.php';
require 'funciones/header.php';
$empresas = getEmpresas();
?>
    <div class="container-fluid">
        <?php if (isset($modales)) echo $modales; ?>
        <div class="row">
            <?php
            if (isset($_SESSION['validado']) && $_SESSION['validado'] == 0) {
                echo '<div class="col-md-12" style="margin-top: 15px"><div class="alert alert-warning" role="alert">
                          No haz validado tu cuenta, da click <a href="perfil.php?toValidate=1" >Aqui</a>
                        </div></div>';
            }
            if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
                echo '<div class="col-md-12" style="margin-top: 15px"><div class="alert alert-danger" role="alert">
                                  ' . $_SESSION['error'] . '
                                </div></div>';
            }
            ?>
            <div class="col-md-8">
                <h1> Empresas </h1>
                <div class="col-md-12">
                    <div class="row"
                    <div class="buscador">
                        <div class="col-md-8">
                            <input type="text" class="input-buscar" placeholder="Buscar Empresa"/>
                        </div>
                        <div class="col-md-4">
                            <div class="btn-buscar">Buscar</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt">
                    <?php
                    for ($i = 0; $i < sizeof($empresas); $i++) {
                        echo '<div class="card">
                                 <div class="card-header">
                                    <span class="txt-15 bold">' . $empresas[$i]['nombre'] . '</span>
                                 </div>
                                  <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <span class="txt-8">' . $empresas[$i]['estado'] . '</span><br>
                                            <span class="txt-8">' . $empresas[$i]['sitio_web'] . '</span>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="perfil.php?id=' . $empresas[$i]['idempresa'] . '"  class="btn btn-primary col-md-12">Ver</a>
                                        </div>
                                    </div>
                                  </div>
                                </div>';
                    }
                    ?>
                </div>
            </div>
        <div class="col-md-3">
            <?php
            if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 1) {
                $enabled = isset($_SESSION['validado']) && $_SESSION['validado'] == 0 ? 'data-toggle="tooltip" data-placement="top" title="Necesitas validar tu cuenta"' : '';
                echo '<button type="button" class="btn btn-primary col-md-12" style="margin-top: 15px" onclick="javascript:openModal(\'agregar_empleo\', ' . $_SESSION['validado'] . ')" ' . $enabled . '>Agregar Empleo</button>';
            } else {
                echo ' <div style="margin-top: 50px"></div><h3>Postulaciones</h3>';
                foreach ($mis_postulaciones as $e) {
                    echo '<div class="card" style="margin: 10px">
                            <div class="card-body">
                                '.$e['titulo'].'
                            </div>
                        </div>';
                }
                echo '</div>';
            }
            ?>
        </div>
    </div>
    </div>
    <div class="modal fade" id="agregar_empleo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Empleo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="agregar_empleo.php" method="POST" onsubmit="return ValidarEmpleo()">
                        <div class="form-group">
                            <label for="nombre">Puesto</label>
                            <input type="text" class="form-control" name="puesto" id="puesto"
                                   aria-describedby="emailHelp" placeholder="Ingresa puesto requerido">
                        </div>
                        <div class="form-group">
                            <label for="usuario">Descripcion</label>
                            <textarea class="form-control rounded-0" name="descripcion" id="descripcion"
                                      rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="password">Sueldo mensualk</label>
                            <input type="number" class="form-control" name="sueldo" id="sueldo"
                                   placeholder="Ingresa el sueldo mensual">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Publicar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
<?php
require 'funciones/footer.php';
?>