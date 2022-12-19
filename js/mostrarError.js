
    //funcion para mostrar el error pasando por parametro el error pertinente
    function mostrarError(error){

        // se crea un div y se le añade un id
        var divAviso = document.createElement("div");
        divAviso.setAttribute('id','divAviso');

        // se obtiene el div mediante su clase
        var center = document.getElementsByClassName("center")[0];
        
        // se crea un parrafo donde mostrar el texto 
        var parrafo = document.createElement('p');
        var text = document.createTextNode(error);

        //boton para continuar tras el error mostrado
        var botonContinuar = document.createElement('button');
        botonContinuar.innerHTML = 'Continuar';
        botonContinuar.onclick = function(){divAviso.style.display='none';};

        var barra = document.createElement('hr');
        
        //el texto se vincula como hijo al parrafo
        parrafo.appendChild(text);

        //la barra se vincula como hijo del parrafo
        parrafo.appendChild(barra);

        //el boton se vincula como hijo al parrafo
        parrafo.appendChild(botonContinuar);

        // se vincula el div como hijo del body
        center.appendChild(divAviso);

        // se vincula el parrafo como hijo del div
        divAviso.appendChild(parrafo);

    }