// funcion para controlar el texto de las horas que introduce el admin


    function exReg(){
        var ini = document.getElementById('ini').value;
        var fin = document.getElementById('fin').value;
        // solo admite formatos reales de horas con horas y minutos
        var expresion = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;
        var error = "Inserte la hora en el formato: 'Hora:Minutos'";
        
        if(!ini.match(expresion) || !fin.match(expresion)){
            mostrarError(error);
            return false;
        }else{
            return true;
        }
    }