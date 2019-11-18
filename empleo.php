<?php
$title = 'Empleos';
require 'funciones/head.php';
require 'funciones/header.php';
if(!isset($_GET['id'])) {
    header('location:dashboard.php');
}

$data = getDataEmpleo($_GET['id'])[0];
if($data == false || empty($data)) header('location:dashboard.php');
?>

<div class="container-fluid">

    <div class="row" style="margin-top: 20px; margin-left: 5px">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Empleos</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $data['titulo']; ?></li>
            </ol>
        </nav>
    </div>
    <div class="row" >
        <div class="col-md-8">
            <h4>Datos del empleo</h4>
            <?php if (!isset($_SESSION['tipo'])): ?>
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" data-toggle="modal" data-target="#iniciar" class="btn btn-info">Aplicar</button>
                    </div>
                </div>
            <?php elseif ($_SESSION['tipo'] == 2): ?>
                <div class="row">
                    <div class="col-md-12">
                        <form action="postularse.php" method="POST">
                            <input type="hidden"  name="idempleo" id="idempleo" value="<?php echo $data['idempleos']; ?>">
                            <button type="submit" class="btn btn-info">Aplicar</button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-4">
            <h4>Datos de la empresa</h4>
            <div class="row">
                <div class="col-md-12">
                    <img src="https://picsum.photos/200" width="250px" class="rounded float-left" alt="...">
                </div>
                <div class="col-md-12">
                    <span class="txt-15 bold"><?php echo $data['nombre'] ?></span>
                    <p class="txt-10"><?php echo $data['estado'].', '.$data['pais']; ?></p>
                    <span class="txt-8"><?php echo $data['sitio_web'] ?></span>
                </div>
            </div>
        </div>

    </div>

</div>
<?php
require 'funciones/footer.php';
?>