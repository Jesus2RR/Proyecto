//funcion para añadir dias al calendario segun lo requerido por el administrador
function crearDias(dias){

    var end = document.getElementById('end');
    
    //se crea un div para con y se le crea una clase para modificarlo desde css
    var divPadre = document.createElement('div');
    divPadre.setAttribute('class','diasNumero');
    
    //se obtiene mediante el id del formulario y se añade el div como hijo
    var form = document.getElementById('formularioCalendario');
    form.insertBefore(divPadre,end);

    //se crea un objeto Date
    var date = new Date();
    
    //se obtiene le dia actual del calendario en string y se traduce a numero para operaciones futuras
    var dia = parseInt(String(date.getDate()));

    //se obtiene el mes (numerico) actual y se suma en 1 ya que empieza en 0 y acaba en 11
    var mes = parseInt(String(date.getMonth()+1));

    //año actual
    var year = String(date.getFullYear());

    //dia de la semana, lunes es 1, martes 2 y asi sucesivamente
    var hoy = date.getDay();
    
    //variable contadora iniciada en 1
    var contador = 1;

    //variable para saber cuantos parrafos se han creado
    var restante = 1;

    //fecha completa actual
    var fecha;
    var diaf = dia - hoy +1;
    
    
    //se crean 7 parrafos 
    for(let i=1;i<8;i++){
        
        //se hace la igualdad en el bucle para iterar la variable
        fecha = String(diaf+'/'+mes+'/'+year);
        
        //creacion de parrafos
        parrafo = document.createElement("p");
        
        //se crean botones sumbit con la fecha como value
        boton = document.createElement('button');
        boton.setAttribute('type','submit');
        boton.setAttribute('name','submit');
        
        if(hoy == 0 ){
            hoyChange = 1;
            boton.setAttribute('value',String(fecha+'-'+hoyChange));
            
        }else{
            
            hoyChange = hoy+1;

            if(hoy == i){
                hoyChange = hoy;
            }

            boton.setAttribute('value',String(fecha+'-'+hoyChange));
        }

        
        
        //en caso de que el dia de la semana sea el dia de la semana se escribe
        if(hoy == i){

            //en caso de que el dia si sea la iteracion se crea un nodo de texto con el dia actual del mes y se hace hijo del boton
            textini = document.createTextNode(dia);
            boton.appendChild(textini);
                    
        }
        
        // en caso de que dia sea 0 se guarda 1 en el dia para mostrarlo en orden en el calendario
        //al boton creado en el espacio en blanco se oculta y deshabilita
        
        if(i<hoy){
            boton.setAttribute('disabled','');
            boton.setAttribute('style','opacity:0;');
            
        }

        //cuando la iteracion sea mayor al dia de la semana se crean nodos de texto con el dia del mes sumado a la variable contadora y se hace hijo del boton. La variables contadoras se iteran 
        if(i>hoy){
            text = document.createTextNode(dia+contador);
            boton.appendChild(text);
            contador++;
            restante++;
            hoy++;  
                    
        }  
        
        //se incrementa el dia de la fecha
        diaf++;
        
        //se añaden todos los parrafos creados como hijos del div
        parrafo.appendChild(boton)
        divPadre.appendChild(parrafo);
    }
    
    //se hacen condiciones para obtener el mes en castellano
    if(mes == 1){
        mostrarmes = "Enero";
    }else if(mes == 2){
        mostrarmes = "Febrero";
    }else if(mes == 3){
        mostrarmes = "Marzo";
    }else if(mes == 4){
        mostrarmes = "Abril";
    }else if(mes == 5){
        mostrarmes = "Mayo";
    }else if(mes == 6){
        mostrarmes = "Junio";
    }else if(mes == 7){
        mostrarmes = "Julio";
    }else if(mes == 8){
        mostrarmes = "Agosto";
    }else if(mes == 9){
        mostrarmes = "Septiembre";
    }else if(mes == 10){
        mostrarmes = "Octubre";
    }else if(mes == 11){
        mostrarmes = "Noviembre";
    }else if(mes == 12){
        mostrarmes = "Diciembre";
    }
    
    //se modifica el dom para incluir dentro del primer h1 el mes actual
    var h1 = document.getElementsByTagName('h1')[0];
    var h1content = document.createTextNode(mostrarmes);
    h1.appendChild(h1content);

    //variable para guardar el ultima dia mostrado en el bucle anterior
    var siguienteDia = dia + contador;

    //variable para escribir dentro de los parrafos
    var suma = siguienteDia + newContador;
    
    //variable que delimita el dia que el bucle puede llegar
    var limite;

    //variable para obtener los dias que quedan por mostrar
    var diasRestantes = dias - restante +1 ;
    
    //variables de acceso y contadoras
    var extra = 1;
    var newContador = 0;    
    var enter = false;
    
    //inicializamos el dia de la semana
    hoy=1;    
    
    //mientras queden dias por mostrar y enter sea false entrará al bucle
    while(diasRestantes > 0 && enter == false){
        
        fecha = String(diaf+'/'+mes+'/'+year);
        
        //se declaran las variables aqui para que se actualicen
        diasRestantes = dias - restante +1;
        suma = siguienteDia + newContador;
        
        //segun el mes se declara un limite
        if(mes == 2){
            limite = 28;
        }else if(mes == 1 || mes == 3 || mes == 5 || mes == 7 || mes == 8 || mes == 10 || mes == 12){
            limite = 31;
        }else{
            limite = 30;
        }

        //cuando los dias mostrados superen el limite de dejaran de incrementar y se parará el bucle
        if(suma >= limite){
            enter = true;
        }else{
            newContador++;
        }
        
        //en caso de que 7(Domingo) sea mayor se vuelve al 1(Lunes)
        if(hoy > 7){
            hoy=1;
        }

        //se crea el DOM necesario para mostrar los dias
        parrafo = document.createElement("p");

        boton = document.createElement('button');
        boton.setAttribute('type','submit');
        boton.setAttribute('name','submit');
        boton.setAttribute('value',String(fecha+'-'+hoy));
        
        parrafo.appendChild(boton);
        
        text = document.createTextNode(suma);
        boton.appendChild(text);
        
        divPadre.appendChild(parrafo);

        restante ++;
        hoy++;
        diaf++;
        
    }
    
    //se accedera al bucle al terminar el anterior
    while(enter == true){

        //se inicializa la variable contadora 
        extra = 1;

        //enter se pasa falso
        enter = false;
        diasRestantes = dias - restante +1;
        
        //se incrementa el mes
        mes ++;

        //en caso de que por los calculos sea mayor a 12 (Diciembre), se pasa a 1(Enero)
        if(mes > 12){
            mes = 1;
            year++;
        }

        if(mes == 2){
            limite = 28;
        }else if(mes == 1 || mes == 3 || mes == 5 || mes == 7 || mes == 8 || mes == 10 || mes == 12){
            limite = 31;
        }else{
            limite = 30;
        }

        //asignaciones de meses
        if(mes == 1){
            mostrarmes = "Enero";
        }else if(mes == 2){
            mostrarmes = "Febrero";
        }else if(mes == 3){
            mostrarmes = "Marzo";
        }else if(mes == 4){
            mostrarmes = "Abril";
        }else if(mes == 5){
            mostrarmes = "Mayo";
        }else if(mes == 6){
            mostrarmes = "Junio";
        }else if(mes == 7){
            mostrarmes = "Julio";
        }else if(mes == 8){
            mostrarmes = "Agosto";
        }else if(mes == 9){
            mostrarmes = "Septiembre";
        }else if(mes == 10){
            mostrarmes = "Octubre";
        }else if(mes == 11){
            mostrarmes = "Noviembre";
        }else if(mes == 12){
            mostrarmes = "Diciembre";
        }
        
        //creacion de DOM para mostrar los datos necesarios
        
        var addh1 = document.createElement('h1');
        var addmes = document.createTextNode(mostrarmes);
        addh1.appendChild(addmes);

        var nuevoDiv = document.createElement('div');
        nuevoDiv.setAttribute('class','diasNumero');
        
        var diasSemana = document.getElementsByClassName('diasSemana')[0];
        var clonDiaSemana = diasSemana.cloneNode(true);
        
        //se inserta nuevoDiv antes el div end y así sucesivamente
        form.insertBefore(nuevoDiv,end);
        form.insertBefore(clonDiaSemana,nuevoDiv);
        form.insertBefore(addh1,clonDiaSemana);
        
        //se hace un bucle teniendo en cuenta el dia del mes anterior para rellenar los huecos en blanco del mes actual
        for(i=1;i<hoy;i++){

            blanco = document.createElement('p');
            espacio = document.createTextNode(" ");
            blanco.appendChild(espacio);
            nuevoDiv.appendChild(blanco);
            
        }
        
        //mientras queden dias que mostrar se hace el bucle
        while(diasRestantes > 0){

            if(diaf > limite){
                diaf = 1;
            }

            fecha = String(diaf+'/'+mes+'/'+year);
            
            if(hoy > 7){
                hoy=1;
            }
            
            diasRestantes = dias - restante +1;
            suma = extra;
            extra++;
            restante++;
            
            //en caso de que se terminen los dias se sale del bucle inicial
            if(diasRestantes > 0){
                enter = false;
            }

            //cuando se excede el limite de ese mes se sale de este bucle actual 
            if(suma > limite){
                enter = true;
                break;
            }
            
            //creacion de DOM necesario
            parrafoN = document.createElement("p");
            textoN = document.createTextNode(suma);

            boton = document.createElement('button');
            boton.setAttribute('type','submit');
            boton.setAttribute('name','submit');
            boton.setAttribute('value',String(fecha+'-'+hoy));

            parrafoN.appendChild(boton);
            
            boton.appendChild(textoN);
            nuevoDiv.appendChild(parrafoN);
            hoy++;
            diaf++;

        }
    }
}