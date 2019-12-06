<?php
$title = 'Inicio';
require 'funciones/head.php';
if (!isset($_SESSION['idusuario']) || (isset($_SESSION['tipo']) && !($_SESSION['tipo'] == 3))) {
    header('location:dashboard.php');
}
require 'funciones/header.php';

$empleos = todosLosEmpleosActivos();
$usuarios = getUsuarios();
$empresas = getEmpresasActivadas();
$empresas_pendientes = getEmpresasValidadas();
$postulaciones = getPostulaciones();
$seleccionados = getSeleccionados();

$totalEmpleos = is_array($empleos) ? sizeof($empleos) : 0;
$totalUsuarios = is_array($usuarios) ? sizeof($usuarios) : 0;
$totalEmpresas = is_array($empresas) ? sizeof($empresas) : 0;
$totalPostulaciones = is_array($postulaciones) ? sizeof($postulaciones) : 0;
$totalSeleccionados = is_array($seleccionados) ? sizeof($seleccionados) : 0;
?>
<div class="container">
    <h1>Metricas</h1>
    <div class="row" style="margin-top: 25px">
        <div class="col-md-3">
            <div class="card" style="width: 100%;height: 150px;text-align: center">
                <div class="card-body">
                    <h5 class="card-title">Total de Usuarios</h5>
                    <p class="card-text" style="vertical-align: center;font-size: 25pt;font-weight: bold">
                        <?php echo $totalUsuarios ?>
                    </p>
                    <a href="#" onclick="getTabla(0)">Ver</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card" style="width: 100%;height: 150px;text-align: center">
                <div class="card-body">
                    <h5 class="card-title">Total de empresas</h5>
                    <p class="card-text" style="vertical-align: center;font-size: 25pt;font-weight: bold">
                        <?php echo $totalEmpresas ?>
                    </p>
                    <a href="#" onclick="getTabla(1)">Ver</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card" style="width: 100%;height: 150px;text-align: center">
                <div class="card-body">
                    <h5 class="card-title">Total de empleos</h5>
                    <p class="card-text" style="vertical-align: center;font-size: 25pt;font-weight: bold">
                        <?php echo $totalEmpleos ?>
                    </p>
                    <a href="#" onclick="getTabla(2)">Ver</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card" style="width: 100%;height: 150px;text-align: center">
                <div class="card-body">
                    <h5 class="card-title">Seleccionados</h5>
                    <p class="card-text" style="vertical-align: center;font-size: 25pt;font-weight: bold">
                        <?php echo $totalSeleccionados ?>
                    </p>
                    <a href="#" onclick="getTabla(3)">Ver</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 15px">
        <div class="col-md-12" id="usuarios" style="display: none">
            <h5>Usuarios</h5>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Telefono</th>
                    <th scope="col">Edad</th>
                    <th scope="col">Carrera</th>
                    <th scope="col">Ingles</th>
                </tr>
                </thead>
                <tbody>

                <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <th scope="row"><?php echo $u['nombre'] ?></th>
                        <td><?php echo $u['telefono'] ?></td>
                        <td><?php echo $u['edad'] ?></td>
                        <td><?php echo $u['carrera'] ?></td>
                        <td><?php echo $u['ingles'] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-12" id="empresas" style="display: none">
            <div class="row">
                <div class="col-md-6">
                    <h5>Empresas</h5>
                </div>
                <div class="col-md-6" >
                    <button type="button" style="float: right" class="btn btn-secondary btn-sm" onclick="getTabla(4)">Pendientes</button>
                </div>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">RFC</th>
                    <th scope="col">Numero SAT</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Ciudad</th>
                    <th scope="col">Direccion</th>
                    <th scope="col">Acciones</th>
                </tr>
                </thead>
                <tbody>

                <?php foreach ($empresas as $e): ?>
                    <tr>
                        <th scope="row"><?php echo $e['nombre'] ?></th>
                        <td><?php echo $e['rfc'] ?></td>
                        <td><?php echo $e['numero_sat'] ?></td>
                        <td><?php echo $e['estado'] ?></td>
                        <td><?php echo $e['ciudad'] ?></td>
                        <td><?php echo $e['direccion'] ?></td>
                        <td>
                            <form method="post" action="habilitar_empresa.php">
                                <input type="hidden" value="<?php echo $e['idempresa'] ?>" name="idempresa">
                                <input type="hidden" value="2" name="tipo">
                                <button type="submit" class="btn btn-primary btn-sm" >Desactivar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-12" id="empleos" style="display: none">
            <h5>Empleos</h5>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Titulo</th>
                    <th scope="col">Sueldo</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Visitas</th>
                    <th scope="col">Postulantes</th>
                    <th scope="col">Agregado</th>
                </tr>
                </thead>
                <tbody>

                <?php foreach ($empleos as $e): ?>
                    <tr>
                        <th scope="row"><?php echo $e['titulo'] ?></th>
                        <td><?php echo $e['sueldo'] ?></td>
                        <td><?php echo $e['categoria'] ?></td>
                        <td><?php echo numerodeVisitas($e['idempleos']) ?></td>
                        <td><?php echo sizeof(getPostulantes($e['idempleos'])) ?></td>
                        <td><?php echo date_format(date_create($e['creado_el']), 'd/m/Y') ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-12" id="seleccionados" style="display: none">
            <h5>Seleccionados</h5>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Fecha</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Empleo</th>
                    <th scope="col">Empresa</th>
                </tr>
                </thead>
                <tbody>

                <?php foreach ($seleccionados as $s): ?>
                    <tr>
                        <th scope="row"><?php echo date_format(date_create($s['creado_el']), 'd/m/Y') ?></th>
                        <td><?php echo $s['nombre_usuario'] ?></td>
                        <td><?php echo $s['titulo'] ?></td>
                        <td><?php echo $s['nombre_empresa'] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-12" id="empresas_pendientes" style="display: none">
            <div class="row">
                <div class="col-md-6">
                    <h5>Empresas pendientes</h5>
                </div>
                <div class="col-md-6" >
                    <button type="button" style="float: right" class="btn btn-primary btn-sm" onclick="getTabla(1)">Activas</button>
                </div>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">RFC</th>
                    <th scope="col">Numero SAT</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Ciudad</th>
                    <th scope="col">Direccion</th>
                    <th scope="col">Accion</th>
                </tr>
                </thead>
                <tbody>

                <?php foreach ($empresas_pendientes as $e): ?>
                    <tr>
                        <th scope="row"><?php echo $e['nombre'] ?></th>
                        <td><?php echo $e['rfc'] ?></td>
                        <td><?php echo $e['numero_sat'] ?></td>
                        <td><?php echo $e['estado'] ?></td>
                        <td><?php echo $e['ciudad'] ?></td>
                        <td><?php echo $e['direccion'] ?></td>
                        <td>
                            <form method="post" action="habilitar_empresa.php">
                                <input type="hidden" value="<?php echo $e['idempresa'] ?>" name="idempresa">
                                <input type="hidden" value="1" name="tipo">
                                <button type="submit" class="btn btn-primary btn-sm" >Activar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
require 'funciones/footer.php';
?>
