<?php
$title = 'Inicio';
require 'funciones/head.php';
require 'funciones/header.php';
if(isset($_SESSION['tipo']) && $_SESSION['tipo']  == 1) {
    $h1 = 'Mis empleos';
    $empleos = empleosByEmpresa($_SESSION['idusuario']);
}else{
    $h1 = 'Todos los empleos';
    $empleos = todosLosEmpleos();
}
?>
<div class="container-fluid">
    <div class="row">
        <?php
            if(isset($_SESSION['validado']) && $_SESSION['validado'] == 0){
                echo '<div class="col-md-12" style="margin-top: 15px"><div class="alert alert-warning" role="alert">
                          No haz validado tu cuenta, da click <a href="perfil.php?toValidate=1" >Aqui</a>
                        </div></div>';
            }
        ?>
        <div class="col-md-8">
            <h1> <?php echo $h1; ?> </h1>
            <div class="col-md-12">
                <?php
                    for($i = 0;$i < sizeof($empleos); $i++ ) {
                        echo '<h5>'.$empleos[$i]['titulo'].'</h5><p>'.$empleos[$i]['descripcion'].'</p><span >$ '.$empleos[$i]['sueldo'].'</span>';
                    }
                ?>
            </div>
        </div>
        <div class="col-md-2">
            <?php
                if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 1) {
                    $enabled = isset($_SESSION['validado']) && $_SESSION['validado'] == 0 ? 'data-toggle="tooltip" data-placement="top" title="Necesitas validar tu cuenta"' : '';
                    echo '<button type="button" class="btn btn-primary col-md-12" style="margin-top: 15px" onclick="javascript:openModal(\'agregar_empleo\', '.$_SESSION['validado'].')" '.$enabled.'>Agregar Empleo</button>';
                }
            ?>
        </div>
    </div>

    <div class="modal fade" id="agregar_empleo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <input type="text" class="form-control" name="puesto" id="puesto" aria-describedby="emailHelp" placeholder="Ingresa puesto requerido">
                        </div>
                        <div class="form-group">
                            <label for="usuario">Descripcion</label>
                            <textarea class="form-control rounded-0" name="descripcion" id="descripcion" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="password">Sueldo mensualk</label>
                            <input type="number" class="form-control" name="sueldo" id="sueldo" placeholder="Ingresa el sueldo mensual">
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