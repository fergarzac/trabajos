<?php
$title = 'Inicio';
require 'funciones/head.php';
require 'funciones/header.php';
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('location:dashboard.php');
}

$empleos = empleosByEmpresa($_GET['id']);
$datosEmpresa = empresasById($_GET['id']);

$h1 = "Empleos de la empresa " . $datosEmpresa['nombre'];
$pagina = isset($_GET['page']) && !empty($_GET['page']) ? $_GET['page'] : 1;
$paginacion = empleosPaginados($empleos, $pagina);
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
                <h1> <?php echo $h1; ?> </h1>
                <div class="col-md-12">
                    <form action="dashboard.php" method="GET">
                    <div class="row"
                    <div class="buscador">
                            <div class="col-md-8">
                                <input type="text" name="buscar" class="input-buscar" placeholder="Buscar Trabajo" autocomplete="off" />
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
                                        <div class="col-md-10">
                                            <span class="txt-15 bold">' . $data['titulo'] . '</span><br>
                                            <span class="txt-12">' . $data['descripcion'] . '</span><br>
                                            <span class="txt-10">$ ' . $data['sueldo'] . '</span><br>
                                            <span class="txt-8" style="color: darkgrey"> ' . date_format(date_create($data['creado_el']), 'd/m/Y')  . '</span>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="empleo.php?id=' . $data['idempleos'] . '"  style="float: right">
                                                <i class="fas fa-chevron-circle-right" style="font-size: 30pt"></i>
                                            </a>
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