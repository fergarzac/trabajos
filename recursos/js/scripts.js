function seleccion(tipo) {
    var input_tipo = document.getElementById('tipo');
    input_tipo.value = tipo;
    $('#registrar').modal('hide');
    $('#registrarse').modal('show');
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

function emailIsValid (email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)
  }