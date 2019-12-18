<?php

/* Obtiene la conexion de base de datos */
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

/* Sanitiza los datos de un array */
function clearData($data){
    $res = [];
    foreach($data as $id => $str) {
        $res[$id] = filter_var($str, FILTER_SANITIZE_STRING);
    }
    return $res;
}

/* Obtiene todos los empleos */
function todosLosEmpleos() {
    $con = getConnection();
    if($con !== null) {
        $condicion = isset($_SESSION['tipo']) && $_SESSION['tipo'] == 2 ? 'WHERE empleos.estado = 1 AND empleos.idempresa IN (SELECT idusuarios FROM usuarios WHERE validado = 1 and tipo = 1)' : '';
        $sql = "SELECT * FROM empleos LEFT JOIN info_empresa ON info_empresa.idempresa = empleos.idempresa ".$condicion." ORDER BY creado_el DESC";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    return false;
}

/* Obtiene todos los empleos activos */
function todosLosEmpleosActivos() {
    $con = getConnection();
    if($con !== null) {
        $sql = "SELECT * FROM empleos where estado = 1 ORDER BY creado_el DESC";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    return false;
}

/* Obtiene todos los empleos */
function getUsuarios() {
    $con = getConnection();
    if($con !== null) {
        $sql = "SELECT * FROM usuarios LEFT JOIN info_usuario ON info_usuario.idusuario = usuarios.idusuarios where tipo = 2 ORDER BY creado_el DESC";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    return false;
}

/* Obtiene todos los empleos de una empresa */
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

/* Validacion de array */
function validarArray($fuente, $array) {
    foreach($array as $data) {
        if(!array_key_exists($data, $fuente)) {
            return false;
        }
    }
    return true;
}

/* Verifica si un empleo esta activo */
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

/* Obtiene la informacion del empleo y la empresa */
function getDataEmpleo($id = 0) {
    $con = getConnection();
    $id = intval($id);
    if($con !== null && $id > 0) {
        $sql = "SELECT empleos.*, usuarios.*, categoria_empleos.nombre as nom_categoria, estados.estado as nom_estado, ciudades.ciudad as nom_ciudad,
        info_empresa.estado as estado_em, info_empresa.ciudad as ciudad_em, info_empresa.nombre, info_empresa.sitio_web,info_empresa.logo as logo FROM empleos 
                LEFT JOIN info_empresa ON empleos.idempresa = info_empresa.idempresa 
                LEFT JOIN usuarios ON empleos.idempresa = usuarios.idusuarios
                LEFT JOIN categoria_empleos ON categoria_empleos.idcategoria_empleos = empleos.categoria
                LEFT JOIN estados ON estados.idestados = empleos.estado_x
                LEFT JOIN ciudades ON ciudades.idciudad = empleos.ciudad
                where empleos.idempleos='$id'";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    return false;
}

/* Obtiene las postulaciones de un usuario */
function getMisPostulaciones($id = 0) {
    $con = getConnection();
    $id = intval($id);
    if($con !== null && $id > 0) {
        $sql = "SELECT * FROM postulaciones left join empleos 
                on empleos.idempleos = postulaciones.idempleo and empleos.estado = 1
                where postulaciones.idusuario = '$id' AND empleos.idempleos is not null ORDER BY fecha DESC";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    return false;
}

/* Obtiene todas las empresas y su informacion */
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

/* Obtiene todas las empresas y su informacion */
function getEmpresasActivadas() {
    $con = getConnection();
    if($con !== null) {
        $sql = "SELECT * FROM usuarios left join info_empresa 
                on info_empresa.idempresa = usuarios.idusuarios where tipo = 1 AND validado = 1";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    return false;
}

/* Obtiene todas las empresas y su informacion */
function getEmpresasValidadas() {
    $con = getConnection();
    if($con !== null) {
        $sql = "SELECT * FROM usuarios left join info_empresa 
                on info_empresa.idempresa = usuarios.idusuarios where tipo = 1 AND validado = 2";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    return false;
}

/* Busca los empleos por parametros */
function empleosByBusqueda($busqueda) {
    $con = getConnection();
    if($con !== null) {
        $query = query($busqueda);
        $sql = "SELECT * FROM empleos WHERE ".$query." ORDER BY creado_el DESC";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    return false;
}

/* Verifica si es una busqueda */
function isBusqueda($data){
    $param = ['buscar', 'salarioMin', 'salarioMax', 'categoria', 'tipo'];
    foreach ($param as $p){
        if(array_key_exists($p, $data) && !empty($data[$p])){
            return true;
        }
    }
    return false;
}


/* Regresa el array de parametros con valores */
function parametrosBusqueda($data){
    $d = [];
    $param = ['buscar', 'salarioMin', 'salarioMax', 'categoria', 'tipo'];
    foreach ($param as $p){
        if(array_key_exists($p, $data) && !empty($data[$p])){
            $d[$p] = $data[$p];
        }
    }
    return $d;
}


/* Genera el query de busqueda */
function query($data) {
    $str = '';
    $param = parametrosBusqueda($data);
    foreach ($param as $key => $p){
        switch ($key){
            case 'buscar':
                $str .= ' (titulo LIKE "%'.$p.'%" OR descripcion LIKE "%'.$p.'%")';
                break;
            case 'salarioMin':
                $str .= 'sueldo >=' . $p;
                break;
            case 'salarioMax':
                $str .= 'sueldo <=' . $p ;
                break;
            case 'categoria':
                $str .= 'categoria =' . $p ;
                break;
            case 'tipo':
                $str .= 'tipo_contraro =' . $p ;
                break;

        }
        $str .= array_key_last($param) !== $key ? " AND " : "";
    }
    return $str;
}

/* Regresa el array de empleados por pagina */
function empleosPaginados($data = [], $pagina = 1, $itemsPorPagina = 10) {
    if(empty($data)) return ['paginas' => 0, 'empleos' => []];

    $totalPaginas = ceil(sizeof($data) / $itemsPorPagina);

    $start = $totalPaginas <= $pagina ? $start = ($totalPaginas - 1) * $itemsPorPagina : ($pagina - 1) * $itemsPorPagina;
    $fin = $start + $itemsPorPagina;
    $empleos = array_slice($data, $start, $fin);
    return ['paginas' => $totalPaginas, 'empleos' => $empleos];
}

/* Obtiene informacion de la empresa dado su id */
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

/* Busca las empresas por nombre */
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

/* Obtiene la informacion de un usuario */
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

/* Verifica si un usuario esta validado o no */
function isUserValidated($id = ''){
    if($id == '') return false;
    $con = getConnection();
    if($con !== null) {
        $sql = "SELECT * FROM usuarios where validado IN (1,2)  AND idusuarios = '$id'";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return true;
        }
        return false;
    }
    return false;
}

/* Obtiene las postulaciones de un usuario y su informacion */
function getPostulantes($id) {
    if($id == '') return [];
    $con = getConnection();
    if($con !== null) {
        $sql = "SELECT * FROM postulaciones
			LEFT JOIN info_usuario ON info_usuario.idusuario = postulaciones.idusuario
			where postulaciones.idempleo = '$id' and (SELECT count(*) FROM info_usuario where idusuario = postulaciones.idusuario) > 0 ORDER BY fecha DESC";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    return [];
}

/* Obtiene el total de empleos disponibles */
function getTotalEmpleos() {
    $con = getConnection();
    if($con !== null) {
        $sql = "SELECT * FROM empleos WHERE estado = 1";
        $result = $con->query($sql);
        return $result ? $result->num_rows : '';
    }
    return 0;
}

/* Obtiene el numero de notificaciones sin leer */
function getNumeroNotificationes($id, $tipo, $desde){
    $con = getConnection();
    if($con !== null) {
        $c = $tipo == 1 ? "(5)" : "(1,2,3,4)";
        $sql = "SELECT count(*) as total FROM notificaciones where JSON_SEARCH(visto_por, 'one', \"$id\") is null and creado_el >= '$desde' and evento IN ".$c;
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return $result->fetch_all(MYSQLI_ASSOC)[0]['total'];
        }
    }
    return 0;
}

/* Obtiene una lista de notificaciones sin leer */
function getNotificationes($id, $tipo, $desde){
    $con = getConnection();
    if($con !== null){
        if($tipo == 1){
            $c = "(5)";
            $sql = "SELECT notificaciones.*, JSON_SEARCH(visto_por, 'one', \"$id\") is not null as visto, info_usuario.nombre
                FROM notificaciones LEFT JOIN info_usuario ON info_usuario.idusuario = notificaciones.idusuario
                where evento IN ".$c." and creado_el >= '$desde' order by creado_el DESC LIMIT 15";
        }else if($tipo == 2){
            $c = "(1,2,3,4)";
            $sql = "SELECT notificaciones.*, JSON_SEARCH(visto_por, 'one', \"$id\") is not null as visto, info_empresa.nombre
                FROM notificaciones LEFT JOIN info_empresa ON info_empresa.idempresa = notificaciones.idusuario
                where evento IN ".$c." and creado_el >= '$desde' order by creado_el DESC LIMIT 15";
        }else{
            $c = "(2,3,4)";
            $sql = "SELECT notificaciones.*, JSON_SEARCH(visto_por, 'one', \"$id\") is not null as visto, info_empresa.nombre
                FROM notificaciones LEFT JOIN info_empresa ON info_empresa.idempresa = notificaciones.idusuario
                where evento IN ".$c." and creado_el >= '$desde' order by creado_el DESC LIMIT 15";
        }
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    return [];
}
/* Marca como leida una notificacion */
function marcarLeidaNotificacion($iduser, $idnotificacion) {
    $con = getConnection();
    if($con !== null) {
        $sql = "UPDATE notificaciones SET visto_por = JSON_ARRAY_APPEND(visto_por,'$', '$iduser') WHERE idnotificaciones = '$idnotificacion'";
        $result = $con->query($sql);
        return $result;
    }
    return false;
}
/* Verifica si un usuario ya esta postulado a un empleo */
function yaEstapostulado($idusuario, $idempleo) {
    $con = getConnection();
    if($con !== null && $idusuario > 0 && $idempleo > 0) {
        $sql = "SELECT * FROM postulaciones where idempleo = '$idempleo' AND idusuario = $idusuario";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return true;
        }
    }
    return false;
}

/* Verifica si un usuario ya esta seleccionado a un empleo */
function yaEstaseleccionado($idusuario, $idempleo) {
    $con = getConnection();
    if($con !== null && $idusuario > 0 && $idempleo > 0) {
        $sql = "SELECT * FROM seleccionado where idempleo = '$idempleo' AND idusuario = $idusuario";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return true;
        }
    }
    return false;
}

function updateValidado($idusuario) {
    $con = getConnection();
    if($con !== null && $idusuario > 0) {
        $sql = "SELECT validado FROM usuarios where idusuarios = '$idusuario'";
        $result = $con->query($sql);
        if($result){
            return $result->fetch_all(MYSQLI_ASSOC)[0]['validado'];
        }
    }
    return '0';
}

/* Sube los archivos a la carpeta upload y regresa la ruta y nombre con la que se guardo */
function uploadFile($file){
    $target_dir = "uploads/";
    $usuario = explode("@", $_SESSION['usuario']);
    $ext = pathinfo(basename($file["name"]), PATHINFO_EXTENSION);
    $random = isset($_SESSION['tipo']) && $_SESSION['tipo'] == 1 ? rand(1, 10000) : $usuario[0];
    $target_file = $target_dir . $random . '.' . $ext;
    $uploadOk = 1;

    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if file already exists
    if ($file["size"] > 500000) {
        $uploadOk = 0;
    }
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" && $imageFileType != "pdf" && $imageFileType != "doc") {
        return ['status' => 3];
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        return ['status' => 0];
    } else {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            return ['status' => 1, 'dir' => $target_file];
        } else {
            return ['status' => 0];
        }
    }
}

/* Agrega una visita a la base de datos */
function agregarVisita($idusuario, $idempleo){
    $con = getConnection();
    if($con !== null && $idusuario > 0 && $idempleo > 0) {
        $sql = "SELECT * FROM vistas where idempleo = '$idempleo' AND idusuario = '$idusuario'";
        $result = $con->query($sql);
        if($result && $result->num_rows<1){
            $sql = "INSERT INTO vistas(idusuario, idempleo) VALUES('$idusuario', '$idempleo')";
            $result = $con->query($sql);
            return $result;
        }

    }
    return false;
}

/* Obtiene el numero de visitas de un empleo */
function numerodeVisitas($idempleo){
    $con = getConnection();
    if($con !== null && $idempleo > 0) {
        $sql = "SELECT * FROM vistas where idempleo = '$idempleo'";
        $result = $con->query($sql);
        if($result){
            return $result->num_rows;
        }

    }
    return false;
}

/* Obtiene todas las postulaciones */
function getPostulaciones() {
    $con = getConnection();
    if($con !== null) {
        $sql = "SELECT * FROM postulaciones where idempleo IN (SELECT idempleos FROM empleos WHERE estado = '1')";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    return false;
}

/* Obtiene la informacion de los seleccionados */
function getSeleccionados() {
    $con = getConnection();
    if($con !== null) {
        $sql = "SELECT info_usuario.nombre as nombre_usuario, info_empresa.nombre as nombre_empresa, 
                empleos.titulo, seleccionado.creado_el FROM seleccionado
                LEFT JOIN info_usuario ON info_usuario.idusuario = seleccionado.idusuario
                LEFT JOIN info_empresa ON info_empresa.idempresa = seleccionado.idempresa
                LEFT JOIN empleos ON empleos.idempleos = seleccionado.idempleo
                ORDER BY seleccionado.creado_el DESC";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    return false;
}

function totalVacantes($id) {
    $con = getConnection();
    if($con !== null) {
        $sql = "SELECT vacantes FROM empleos WHERE idempleos = '$id'";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return $result->fetch_all(MYSQLI_ASSOC)[0]['vacantes'];
        }
        return [];
    }
    return false;
}

function totalSeleccionados($id) {
    $con = getConnection();
    if($con !== null) {
        $sql = "SELECT count(*) as total FROM seleccionado WHERE idempleo = '$id'";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return $result->fetch_all(MYSQLI_ASSOC)[0]['total'];
        }
        return [];
    }
    return false;
}

function estadoDeEmpleo($id){
    $con = getConnection();
    if($con !== null) {
        $sql = "SELECT estado FROM empleos WHERE idempleos = '$id'";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return $result->fetch_all(MYSQLI_ASSOC)[0]['estado'] == 1;
        }
        return false;
    }
    return false;
}

/* Obtiene las categorias */
function getCategorias() {
    $con = getConnection();
    if($con !== null) {
        $sql = "SELECT * FROM categoria_empleos";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    return false;
}

/* Obtiene los tipos de empresas */
function getTiposEmpresas() {
    $con = getConnection();
    if($con !== null) {
        $sql = "SELECT * FROM tipos_empresa";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    return false;
}

function getEmpresasActivas(){
    $con = getConnection();
    if($con !== null) {
        $sql = "SELECT * FROM usuarios WHERE tipo = 1 AND validado = 1";
        $result = $con->query($sql);
        if($result){
            return $result->num_rows;
        }
        return 0;
    }
    return false;
}

function getEmpresasInactivas(){
    $con = getConnection();
    if($con !== null) {
        $sql = "SELECT * FROM usuarios WHERE tipo = 1 AND (validado = 0 OR validado = 2)";
        $result = $con->query($sql);
        if($result){
            return $result->num_rows;
        }
        return 0;
    }
    return false;
}

function getCiudades($idestado) {
    $con = getConnection();
    if($con !== null) {
        mysqli_set_charset($con,"utf8");
        $sql = "SELECT * FROM ciudades WHERE idestado = '$idestado'";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return ($result->fetch_all(MYSQLI_ASSOC));
        }
        return  [];
    }
    return  [];
}
function getEstados() {
    $con = getConnection();
    if($con !== null) {
        $sql = "SELECT * FROM estados";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    return false;
}

function getEstado($id) {
    $con = getConnection();
    if($con !== null) {
        mysqli_set_charset($con,"utf8");
        $sql = "SELECT * FROM estados WHERE idestados = '$id'";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return $result->fetch_all(MYSQLI_ASSOC)[0];
        }
        return [];
    }
    return false;
}

function getCiudad($id) {
    $con = getConnection();
    if($con !== null) {
        mysqli_set_charset($con,"utf8");
        $sql = "SELECT * FROM ciudades WHERE idciudad = '$id'";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return $result->fetch_all(MYSQLI_ASSOC)[0];
        }
        return [];
    }
    return false;
}

function getLogo($id) {
    $con = getConnection();
    if($con !== null) {
        mysqli_set_charset($con,"utf8");
        $sql = "SELECT logo FROM info_empresa WHERE idempresa = '$id'";
        $result = $con->query($sql);
        if($result && $result->num_rows>0){
            return $result->fetch_all(MYSQLI_ASSOC)[0]['logo'];
        }
        return "";
    }
    return "";
}