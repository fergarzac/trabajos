<?php
function getConnection() {
    $server = 'localhost';
    $user = 'root';
    $pass = '';
    $db = 'empleos';
    $con = mysqli_connect($server, $user, $pass, $db);
    if (mysqli_connect_errno())
    {
        return false;
    }
    return $con;
}

function clearData($data){
    $res = [];
    foreach($data as $id => $str) {
        $res[$id] = filter_var($str, FILTER_SANITIZE_STRING);
    }
    return $res;
}


function todosLosEmpleos() {
    $con = getConnection();
    if($con !== null) {
        $sql = "SELECT * FROM empleos ORDER BY creado_el DESC";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    return false;
}

function empleosByEmpresa($id = 0) {
    $con = getConnection();
    $id = intval($id);
    if($con !== null && $id > 0) {
        $sql = "SELECT * FROM empleos where idempresa = '$id' ORDER BY creado_el DESC";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    return false;
}

function validarArray($fuente, $array) {
    foreach($array as $data) {
        if(!array_key_exists($data, $fuente)) {
            return false;
        }
    }
    return true;
}

function validarEstadoEmpleo($id = 0) {
    $con = getConnection();
    $id = intval($id);
    if($con !== null && $id > 0) {
        $sql = "SELECT * FROM empleos where idempleos = '$id' AND estado = 1";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return true;
        }
    }
    return false;
}

function getDataEmpleo($id = 0) {
    $con = getConnection();
    $id = intval($id);
    if($con !== null && $id > 0) {
        $sql = "SELECT * FROM empleos 
                LEFT JOIN info_empresa ON empleos.idempresa = info_empresa.idempresa 
                LEFT JOIN usuarios ON empleos.idempresa = usuarios.idusuarios
                where empleos.idempleos='$id'";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    return false;
}

function getMisPostulaciones($id = 0) {
    $con = getConnection();
    $id = intval($id);
    if($con !== null && $id > 0) {
        $sql = "SELECT * FROM postulaciones left join empleos 
                on empleos.idempleos = postulaciones.idempleo
                where postulaciones.idusuario = '$id' ORDER BY fecha DESC";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    return false;
}

function getEmpresas() {
    $con = getConnection();
    if($con !== null) {
        $sql = "SELECT * FROM info_empresa left join usuarios 
                on info_empresa.idempresa = usuarios.idusuarios";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    return false;
}

function empleosByBusqueda($busqueda = '') {
    $con = getConnection();
    if($con !== null) {
        $sql = "SELECT * FROM empleos WHERE titulo LIKE \"%".$busqueda."%\" OR descripcion LIKE \"%".$busqueda."%\" ORDER BY creado_el DESC";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    return false;
}

function empleosPaginados($data = [], $pagina = 1, $itemsPorPagina = 10) {
    if(empty($data)) return ['paginas' => 0, 'empleos' => []];

    $totalPaginas = ceil(sizeof($data) / $itemsPorPagina);

    $start = $totalPaginas <= $pagina ? $start = ($totalPaginas - 1) * $itemsPorPagina : ($pagina - 1) * $itemsPorPagina;
    $fin = $start + $itemsPorPagina;
    $empleos = array_slice($data, $start, $fin);
    return ['paginas' => $totalPaginas, 'empleos' => $empleos];
}
function empresasById($id) {
    $con = getConnection();
    if($con !== null) {
        $sql = "SELECT * FROM info_empresa
			LEFT JOIN usuarios ON usuarios.idusuarios = info_empresa.idempresa
			where info_empresa.idempresa = '$id' ";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return $result->fetch_all(MYSQLI_ASSOC)[0];
        }
        return [];
    }
    return false;
}
function empresasByBusqueda($busqueda = '') {
    $con = getConnection();
    if($con !== null) {
        $sql = "SELECT * FROM info_empresa
			LEFT JOIN usuarios ON usuarios.idusuarios = info_empresa.idempresa
			where info_empresa.nombre LIKE \"%".$busqueda."%\" OR info_empresa.pais = '$busqueda' OR info_empresa.estado = '$busqueda' ";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    return false;
}

function getUserInfo($id = '') {
    if($id == '') return [];
    $con = getConnection();
    if($con !== null) {
        $sql = "SELECT * FROM info_usuario
			LEFT JOIN usuarios ON usuarios.idusuarios = info_usuario.idusuario
			where info_usuario.idusuario = '$id'";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return $result->fetch_all(MYSQLI_ASSOC)[0];
        }
        return [];
    }
    return [];
}


function isUserValidated($id = ''){
    if($id == '') return false;
    $con = getConnection();
    if($con !== null) {
        $sql = "SELECT * FROM usuarios where validado = 1 AND idusuarios = '$id'";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return true;
        }
        return false;
    }
    return false;
}