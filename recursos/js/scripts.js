var sueldo = document.getElementById("sueldo");
sueldo.addEventListener("keyup", function(e){
    e.preventDefault();
    if(e.keyCode == 189){
        sueldo.value = sueldo.value.substring(0, sueldo.value.length - 1);
    }

})
function seleccion(tipo) {
    var input_tipo = document.getElementById('tipo');
    input_tipo.value = tipo;
    $('#registrar').modal('hide');
    $('#registrarse').modal('show');
}

function openModal(id, validate = null) {
    if(validate == null || validate == 1) {
        $('#'+id).modal('show');
    }
}


function validation() {
    var pass = document.getElementById('password_registrar');
    var pass_confirm = document.getElementById('password_confim');
    var email = document.getElementById('usuario_registrar');
    if(emailIsValid(email.value)) {
        email.setAttribute('style', '');
        if((pass.value.length > 0) && (pass.value == pass_confirm.value)) {
            pass.setAttribute('style', '');
            pass_confirm.setAttribute('style', '');
            return true;
        }
        pass.setAttribute('style', 'border: 1px red solid');
        pass_confirm.setAttribute('style', 'border: 1px red solid');
        alert('Las contraseñas no coinciden.');
        return false;
    }
    email.setAttribute('style', 'border: 1px red solid');
    alert('Email invalido.');
    return false;
}

function ValidarEmpleo(){
    var puesto = document.getElementById('puesto');
    var descripcion = document.getElementById('descripcion');
    var sueldo = document.getElementById('sueldo');
    var estado = document.getElementById('estado');
    var ciudad = document.getElementById('ciudad');
    var vacantes = document.getElementById('vacantes');

    if(puesto.value.length > 0 && descripcion.value.length > 0 && sueldo.value.length > 0 && estado.value.length > 0 && ciudad.value.length > 0 && vacantes.value.length > 0 && sueldo.value > 0 && vacantes.value > 0) return true;
    alert('Faltan datos por llenar o tienes un dato incorrecto.')
    return false;
}

function emailIsValid (email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)
  }

function ValidarDatos(){
    var rfc = document.getElementById('rfc');
    var nombre = document.getElementById('nombre');
    var sat = document.getElementById('sat');
    var tipo = document.getElementById('tipo_empresa');
    var ciudad = document.getElementById('ciudad');
    var estado = document.getElementById('estado');
    var descripcion = document.getElementById('descripcion');
    var sitio_web = document.getElementById('sitio_web');
    var direccion = document.getElementById('direccion');
    var nombre_contacto = document.getElementById('nombre_contacto');
    var telefono_contacto = document.getElementById('telefono_contacto');
    if(rfc.value.length < 12 || rfc.value.length > 13){
        alert('El RFC no es valido, debe tener mas de 12 caracteres y menos de 13.');
        return false;
    }

    if(!isURL(sitio_web.value)) {
        alert('No es un sitio web valido.');
        return false;
    }
    if(nombre_contacto.value.length > 0 && telefono_contacto.value.length > 0 && sat.value.length > 0 && tipo.value.length > 0 && nombre.value.length > 0 && ciudad.value.length > 0 && estado.value.length > 0 && descripcion.value.length > 0 && sitio_web.value.length > 0 && direccion.value.length > 0) return true;

    alert('Olvidaste llenar un campo, o pusiste datos invalidos');
    return false;
}

function isURL(str) {
    var RegExp = (/^HTTP|HTTP|http(s)?:\/\/(www\.)?[A-Za-z0-9]+([\-\.]{1}[A-Za-z0-9]+)*\.[A-Za-z]{2,40}(:[0-9]{1,40})?(\/.*)?$/);
    return RegExp.test(str);
}

function ValidarDatosUsuario(){
    var nombre = document.getElementById('nombre');
    var telefono = document.getElementById('telefono');
    if(nombre.value.length > 0 && telefono.value.length > 0 ) return true;
    alert('Llena todos los campos');
    return false;
}

function changeImg(){
    var input = document.getElementById('logo');
    var url = input.value;
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#imglogo').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
    else{
        $('#imglogo').attr('src', 'https://via.placeholder.com/150');
    }
}

function getTabla(id){
    var paneles = ['usuarios','empresas','empleos','seleccionados','empresas_pendientes'];
    hideAll(paneles);
    document.getElementById(paneles[id]).style.display = "block";
}

function hideAll(paneles){
    paneles.forEach(function (e) {
        document.getElementById(e).style.display = "none";
    });
}

function getCiudades(estado) {
    var id = estado.value;
    var opts = {
        method: 'GET',
        headers: {}
    };
    fetch('ciudades.php?id='+id, opts).then(function (response) {
        return response.json();
    }).then(function (body) {
        var ciudades = document.getElementById('ciudad');
        var options = "";
        body.forEach(function(element, index){
            options += "<option value='"+element.idciudad+"'>"+element.ciudad+"</option>"
        })
        ciudades.innerHTML = options;
    });
}