function validarEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!regex.test(email)) {        
        return false;
    }
    return true;
}

function esNumero(dato) {
    var regex = /^\d+$/;
    if (!regex.test(dato)) {        
        return false;
    }
    return true;    
}

function esVacio(dato) {
    var regex = /^$|\s/;
    if (!regex.test(dato)) {        
        return false;
    }
    return true;        
}

function minimoCaracteres(dato, minimo) {
    
    if(dato.length<minimo)
        return true;
    return false;
}