<?php
$title = 'Empleos';
require 'funciones/head.php';
require 'funciones/header.php';
if(!isset($_GET['id'])) {
    header('location:dashboard.php');
}

$data = getDataEmpleo($_GET['id'])[0];

if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == "1"){
    $postulantes = getPostulantes($_GET['id']);
    $pagina = isset($_GET['page']) && !empty($_GET['page']) ? $_GET['page'] : 1;
    $paginacion = empleosPaginados($postulantes, $pagina);
    $nextPage = isset($_GET['page']) && !empty($_GET['page']) && intval($_GET['page']) < $paginacion['paginas'] ? intval($_GET['page']) + 1 : 2;
    $previusPage = isset($_GET['page']) && !empty($_GET['page']) && intval($_GET['page']) > 1 ? intval($_GET['page']) - 1 : 1;
}elseif (isset($_SESSION['tipo']) && $_SESSION['tipo'] == "2") {
    agregarVisita($_SESSION['idusuario'], $_GET['id']);
}
$categorias = getCategorias();
if($data == false || empty($data)) header('location:dashboard.php');
$visitas = numerodeVisitas($_GET['id']);

?>

<div class="container">


    <div class="row" >
        <div class="col-md-8" style="background: #f8f9fa;margin: 10px; padding: 15px">
            <div class="row" style="margin-top: 20px; margin-left: 5px">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Empleos</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $data['titulo']; ?></li>
                    </ol>
                </nav>
            </div>
            <h4>Datos del empleo</h4>
            <p >
            <div class="row">
                <div class="col-md-10">
                    <span style="font-weight: bold;font-size: 12pt"><?php echo $data['titulo']; ?></span> <span style="font-size: 10pt; color: darkgrey">Publicado: <?php echo date_format(date_create($data['creado_el']),"d/m/Y"); ?></span>
                </div>
                <?php if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == "1"):?>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-info btn-sm" style="float: right" onclick="javascript:openModal('modificar_empleo', '<?php echo $_SESSION['validado'] ?>')">Modificar</button>
                    </div>
                <?php endif; ?>
            </div>
            </p>
            <p>
                <?php echo $data['descripcion']; ?><br><br>
                Tipo de contrato: <?php echo $data['tipo_contrato']; ?><br><br>
                Categoria: <?php echo empty($data['nom_categoria']) ? 'Sin Categoria' : $data['nom_categoria']; ?><br><br>
                Ciudad: <?php echo empty($data['nom_ciudad']) ? '' : $data['nom_ciudad']; ?><br><br>
                Estado: <?php echo empty($data['nom_estado']) ? '' : $data['nom_estado']; ?><br><br>
                Sueldo: <?php echo $data['sueldo']; ?><br><br>
                Vacantes: <?php echo ($data['vacantes'] - totalSeleccionados($_GET['id'])); ?><br><br>
            </p>
            <?php if (!isset($_SESSION['tipo'])): ?>
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" data-toggle="modal" data-target="#iniciar" class="btn btn-info">Postularte</button>
                    </div>
                </div>
            <?php elseif ($_SESSION['tipo'] == 2): ?>
                <div class="row">
                    <div class="col-md-12">
                        <?php
                            $enabled = '';
                            $type = 'submit';
                            if(isset($_SESSION['validado']) && $_SESSION['validado']  != 1 ) {
                                $enabled = 'data-toggle="tooltip" data-placement="top" title="Necesitas validar tu cuenta"';
                                $type = 'button';
                            }

                            if(!yaEstapostulado($_SESSION['idusuario'], $data['idempleos'])){
                                echo '<form action="postularse.php" method="POST">
                                    <input type="hidden"  name="idempleo" id="idempleo" value="'.$data['idempleos'].'">
                                    <button type="'.$type.'" class="btn btn-info" ' . $enabled . '>Postularte</button>
                                </form>';
                            }else{
                                echo '<span class="badge badge-primary">Ya estas postulado</span>';
                                echo '<form action="despostularse.php" method="POST">
                                    <input type="hidden"  name="idempleo" id="idempleo" value="'.$data['idempleos'].'">
                                    <button type="submit" class="btn btn-sm btn-info">Deshacer</button>
                                </form>';
                            }

                        ?>

                    </div>
                </div>
            <?php elseif ($_SESSION['tipo'] == 1): ?>
                <div class="row">
                    <div class="col-md-12">
                        <h4>Tienes <?php echo sizeof($postulantes) == 1 ? sizeof($postulantes) . ' postulante' : sizeof($postulantes) . ' postulantes'; ?></h4>
                        <div class="accordion" id="accordionExample">
                        <form action="seleccionar.php" method="POST">
                        <?php
                        $seleccionar = estadoDeEmpleo($_GET['id']) ? '<button type="submit" class="btn btn-primary" >Seleccionar</button>' : '';
                        foreach ($postulantes as $e) {
                            if(yaEstaseleccionado($e['idusuario'], $_GET['id'])) $seleccionar =  '';
                            if(isset($data['vacantes']) && (intval($data['vacantes']) - totalSeleccionados($_GET['id']) == 0)) $seleccionar =  '';
                            $buttonCurriculum = !empty($e['curriculum']) ? '<a class="btn btn-primary" target="_blank" href="'.$e['curriculum'].'">Ver curriculum</a>' :
                                '<button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="No tiene curriculum">Ver curriculum</button>';
                            echo '<div class="card">
                                    <div class="card-header" id="headingOne">
                                      <h2 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse'.$e['idusuario'].'" aria-expanded="true" aria-controls="collapseOne">
                                          '.$e['nombre'].' - '.date_format(date_create($e['fecha']),"d/m/Y").'
                                        </button>
                                      </h2>
                                    </div>
                                
                                    <div id="collapse'.$e['idusuario'].'" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                      <div class="card-body">
                                        <p>
                                            Nombre: '.$e['nombre'].'<br>
                                            Edad: '.date_format(date_create($e['fecha_nacimiento']),"d/m/Y").' ('.$e['edad'].' años)<br>
                                            Telefono: '.$e['telefono'].'<br>
                                            Ingles: '.$e['ingles'].'<br>
                                            Disponibilidad para viajar: '.($e['disponibilidad_viajar'] ? 'Si' : 'No').'<br>
                                        </p>
                                        '.$buttonCurriculum.'
                                        <input type="hidden" name="idusuario" value="'.$e['idusuario'].'" />
                                        <input type="hidden" name="idempleo" value="'.$_GET['id'].'" />
                                        '.$seleccionar.'
                                      </div>
                                    </div>
                                  </div>';
                        }
                        ?>
                        </form>
                        </div>
                        <nav aria-label="Page navigation example" style="margin-top: 10px">
                            <ul class="pagination">
                                <li class="page-item"><a class="page-link" href="<?php echo 'empleo.php?id='.$_GET['id'].'&page='.$previusPage ?>">Anterior</a></li>
                                <?php
                                for ($i = 1; $i <= $paginacion['paginas']; $i++) {
                                    echo  '<li class="page-item"><a class="page-link" href="empleo.php?id='.$_GET['id'].'&page='.$i.'">'.$i.'</a></li>';

                                }
                                ?>
                                <li class="page-item"><a class="page-link" href="<?php echo 'empleo.php?id='.$_GET['id'].'&page='.$nextPage ?>">Siguiente</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            <?php endif; ?>
            <p>
                <span style="font-size: 10pt; color: darkgrey">Visitado por <?php echo $visitas; ?> usuarios</span>
            </p>
        </div>
        <div class="col-md-3" style="background: #f8f9fa;margin: 10px; padding: 15px">
            <h4>Datos de la empresa</h4>
            <div class="row">
                <div class="col-md-12">
                    <img src="<?php echo isset($data['logo']) && !empty($data['logo']) ? $data['logo'] : 'https://via.placeholder.com/150'; ?>" width="250px" class="rounded float-left" alt="...">
                </div>
                <div class="col-md-12">
                    <a href="empleos.php?id=<?php echo $data['idempresa'] ?>"><span class="txt-15 bold"><?php echo $data['nombre'] ?></span></a>
                    <p class="txt-10"><?php echo $data['ciudad'].', '.$data['estado']; ?></p>
                    <span class="txt-8"><a href="<?php echo $data['sitio_web'] ?>"><?php echo $data['sitio_web'] ?></a></span>
                </div>
            </div>
        </div>

    </div>
    <?php if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 1): ?>
        <div class="modal fade" id="modificar_empleo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modificar Empleo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="modificar_empleo.php" method="POST" onsubmit="return ValidarEmpleo()">
                        <input name="idempleo" type="hidden" value="<?php echo $_GET['id'] ?>">
                        <div class="form-group">
                            <label for="nombre">Puesto</label>
                            <input type="text" class="form-control" name="puesto" id="puesto"
                                   aria-describedby="emailHelp" placeholder="Ingresa puesto requerido"
                                   value="<?php echo isset($data['titulo']) ? $data['titulo']: '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="usuario">Descripcion</label>
                            <textarea class="form-control rounded-0" name="descripcion" id="descripcion"
                                      rows="10"><?php echo isset($data['descripcion']) ? $data['descripcion']: '' ?></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Estado</label>
                                    <input  class="form-control" name="estado" id="estado"
                                            placeholder="Ingresa el estado"
                                            value="<?php echo isset($data['nom_estado']) ? $data['nom_estado']: '' ?>">
                                    <select class="custom-select" name="estado" id="estado" onchange="getCiudades(this)">
                                        <?php
                                        foreach($estados as $d){
                                            if(isset($data['nom_estado']) && $data['nom_estado'] == $d['idestados']) {
                                                echo '<option selected value="'.$d['idestados'].'">'.$d['estado'].'</option>';
                                            }else{
                                                echo '<option value="'.$d['idestados'].'">'.$d['estado'].'</option>';
                                            }
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
                                           placeholder="Ingresa el sueldo mensual"
                                           value="<?php echo isset($data['sueldo']) ? $data['sueldo']: '' ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Vacantes</label>
                                    <input type="number" class="form-control" name="vacantes" id="vacantes"
                                           placeholder="Ingresa el numero de vacantes"
                                           value="<?php echo isset($data['vacantes']) ? $data['vacantes']: '' ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="formControlRange">Categoria</label>
                                    <select class="custom-select" name="categoria">
                                        <?php
                                        if(isset($data['categoria'])){
                                            echo '<option>Seleccionar</option>';
                                        }else{
                                            echo '<option selected>Seleccionar</option>';
                                        }
                                        foreach($categorias as $d){
                                            if($d['idcategoria_empleos'] == $data['categoria']){
                                                echo '<option selected value="'.$d['idcategoria_empleos'].'">'.$d['nombre'].'</option>';
                                            }else{
                                                echo '<option value="'.$d['idcategoria_empleos'].'">'.$d['nombre'].'</option>';
                                            }

                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="formControlRange">Tipo de contrato</label>
                                    <select class="custom-select" name="tipo">
                                        <option value="0" selected>Seleccionar</option>
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
                    <button type="submit" class="btn btn-primary">Modificar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <?php endif; ?>
</div>
<?php
require 'funciones/footer.php';
?>