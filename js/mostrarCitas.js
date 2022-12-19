function mostrarCitas(fechaTotal){

    var divCita = document.createElement('div');
    divCita.setAttribute('class','divCita');

    var pFecha = document.createElement('p');
    var txtFecha = document.createTextNode(fecha);

    var pHora = document.createElement('p');
    var txtHora = document.createTextNode(hora);

    pFecha.appendChild(txtFecha);
    pHora.appendChild(txtHora);

    divCita.appendChild(pFecha,pHora);

}