<?php
$title = 'Inicio';
require 'funciones/head.php';
require 'funciones/header.php';


if(isset($_GET['buscar']) && !empty($_GET['buscar'])) {
    $h1 = 'Busquedas de ' . $_GET['buscar'];
    $empresas = empresasByBusqueda($_GET['buscar']);
}else {
    $h1 = 'Todos los empleos';
    $empresas = getEmpresas();
}

$categorias = getCategorias();
$estados = getEstados();
$pagina = isset($_GET['page']) && !empty($_GET['page']) ? $_GET['page'] : 1;
$paginacion = empleosPaginados($empresas, $pagina);
$nextPage = isset($_GET['page']) && !empty($_GET['page']) && intval($_GET['page']) < $paginacion['paginas'] ? intval($_GET['page']) + 1 : 2;
$previusPage = isset($_GET['page']) && !empty($_GET['page']) && intval($_GET['page']) > 1 ? intval($_GET['page']) - 1 : 1;
?>
    <div class="container">
        <?php if (isset($modales)) echo $modales; ?>
        <div class="row">
            <?php
            if (isset($_SESSION['validado']) && $_SESSION['validado'] == 0 && $_SESSION['tipo'] != 3) {
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
            <div class="col-md-8" style="background: #f8f9fa;margin: 10px">
                <h1> Empresas </h1>
                <div class="col-md-12">
                    <form action="empresas.php" method="GET">
                    <div class="row"
                    <div class="buscador">
                        <div class="col-md-8">
                            <input type="text" name="buscar" class="input-buscar" placeholder="Buscar Empresa" autocomplete="off"/>
                        </div>
                        <div class="col-md-4">
                            <input type="submit" class="btn-buscar" value="Buscar">
                        </div>
                    </div>
                    </form>
                </div>
                <div class="col-md-12 mt">
                    <?php
                    foreach ($paginacion['empleos'] as $key => $data) {
                        echo '<div class="card" style="margin: 5px">
                                  <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <img src="'. (isset($data['logo']) && !empty($data['logo']) ? $data['logo'] : "https://via.placeholder.com/150")  .'" width="100%">
                                        </div>
                                        <div class="col-md-10">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <span class="txt-15 bold">' . $data['nombre'] . '</span><br>
                                                    <span class="txt-8">' . $data['estado'] . '</span><br>
                                                    <span class="txt-8">' . $data['sitio_web'] . '</span>
                                                </div>
                                                <div class="col-md-2">
                                                    <a href="empleos.php?id=' . $data['idempresa'] . '" style="float: right">
                                                        <i class="fas fa-chevron-circle-right" style="font-size: 30pt"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                </div>';
                    }
                    ?>
                    <div class="mt">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item"><a class="page-link" href="<?php echo 'dashboard.php?page='.$previusPage ?>">Anterior</a></li>
                                <?php
                                for ($i = 1; $i <= $paginacion['paginas']; $i++) {
                                    echo  '<li class="page-item"><a class="page-link" href="dashboard.php?page='.$i.'">'.$i.'</a></li>';

                                }
                                ?>
                                <li class="page-item"><a class="page-link" href="<?php echo 'dashboard.php?page='.$nextPage ?>">Siguiente</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        <div class="col-md-3" style="background: #f8f9fa;margin: 10px">
            <?php
            if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 1) {
                $enabled = isset($_SESSION['validado']) && $_SESSION['validado'] != 1 ? 'data-toggle="tooltip" data-placement="top" title="Necesitas validar tu cuenta"' : '';
                $class = isset($_SESSION['validado']) && $_SESSION['validado'] != 1 ? 'secondary' : 'primary';
                echo '<button type="button" class="btn btn-'.$class.' col-md-12" style="margin-top: 15px" onclick="javascript:openModal(\'agregar_empleo\', ' . $_SESSION['validado'] . ')" ' . $enabled . '>Agregar Empleo</button>';
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Estado</label>
                                    <select class="custom-select" name="estado" id="estado" onchange="getCiudades(this)">
                                        <option selected>Seleccionar</option>
                                        <?php
                                        foreach($estados as $d){
                                            echo '<option value="'.$d['idestados'].'">'.$d['estado'].'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Ciudad</label>
                                    <select class="custom-select" name="ciudad" id="ciudad">

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Sueldo mensual</label>
                                    <input type="number" class="form-control" name="sueldo" id="sueldo"
                                           placeholder="Ingresa el sueldo mensual">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Vacantes</label>
                                    <input type="number" class="form-control" name="vacantes" id="vacantes"
                                           placeholder="Ingresa el numero de vacantes">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="formControlRange">Categoria</label>
                                    <select class="custom-select" name="categoria">
                                        <option selected>Seleccionar</option>
                                        <?php
                                        foreach($categorias as $d){
                                            echo '<option value="'.$d['idcategoria_empleos'].'">'.$d['nombre'].'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="formControlRange">Tipo de contrato</label>
                                    <select class="custom-select" name="tipo">
                                        <option selected>Seleccionar</option>
                                        <option value="1">Tiempo completo</option>
                                        <option value="2">Medio tiempo</option>
                                        <option value="3">Indeterminado</option>
                                        <option value="4">Determinado</option>
                                        <option value="5">Temporal</option>
                                        <option value="6">Otro</option>
                                    </select>
                                </div>
                            </div>
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