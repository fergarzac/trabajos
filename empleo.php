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
                        <button type="submit" class="btn btn-info btn-sm" style="float: right">Modificar</button>
                    </div>
                <?php endif; ?>
            </div>
            </p>
            <p>
                <?php echo $data['descripcion']; ?><br><br>
                Tipo de contrato: <?php echo $data['tipo_contrato']; ?><br><br>
                Categoria: <?php echo $data['categoria']; ?><br><br>
                Sueldo: <?php echo $data['sueldo']; ?><br><br>
                Vacantes: <?php echo $data['vacantes']; ?><br><br>
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
                            if(isset($_SESSION['validado']) && $_SESSION['validado']  !== 1 ) {
                                $enabled = 'data-toggle="tooltip" data-placement="top" title="Necesitas validar tu cuenta"';
                                $type = 'button';
                            }else if(yaEstapostulado($_SESSION['idusuario'], $data['idempleos'])){
                                $enabled = 'data-toggle="tooltip" data-placement="top" title="Ya te haz postulado a este empleo"';
                                $type = 'button';
                            }
                            echo '<form action="postularse.php" method="POST">
                                    <input type="hidden"  name="idempleo" id="idempleo" value="'.$data['idempleos'].'">
                                    <button type="'.$type.'" class="btn btn-info" ' . $enabled . '>Postularte</button>
                                </form>';
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
                    <span class="txt-8"><?php echo $data['sitio_web'] ?></span>
                </div>
            </div>
        </div>

    </div>

</div>
<?php
require 'funciones/footer.php';
?>