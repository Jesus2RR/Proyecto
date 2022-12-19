<?php
    
    // se obtiene el dia de la semana en numero y segun el numero se traduce al dia en español
    function diaSemana($fecha){
        
        $dia = substr($fecha,-1);
        switch($dia){
            case 1:
                $dia = "Lunes";
                break;
            case 2:
                $dia = "Martes";
                break;
            case 3:
                $dia = "Miercoles";
                break;
            case 4:
                $dia = "Jueves";
                break;
            case 5:
                $dia = "Viernes";
                break;
            case 6:
                $dia = "Sabado";
                break;
            case 7:
                $dia = "Domingo";
                break; 
            }   
                
            // se devuelve el dia obtenido 
            return $dia;  
    }

    //funcion para mostrar el mes de la fecha clickada
    function mesSpain($fecha){
        
        //se obtiene la fecha total y se recorta hasta obtener el mes numerico
        $mes = substr($fecha,-9,2);

        //en el caso de meses de un solo digito se recoge la primera barra.
        switch($mes){
            case "/1":
                $mes = "enero";
                break;
            case "/2":
                $mes = "febrero";
                break;
            case "/3":
                $mes = "marzo";
                break;  
            case "/4":
                $mes = "abril";
                break;
            case "/5":
                $mes = "mayo";
                break;
            case "/6":
                $mes = "junio"; 
                break;
            case "/7":
                $mes = "julio"; 
                break;
            case "/8":
                $mes = "agosto";
                break;
            case "/9":
                $mes = "septiembre";
                break;
            case "10":
                $mes = "octubre";
                break;
            case "11":
                $mes = "noviembre";
                break;
            case "12":
                $mes = "diciembre";    
                break;
        }

        // se devuelve el mes resultante
        return $mes;
    }

    //funcion para devolver el día numerico
    function devolverDiaNumerico($fecha){
        //se obtiene la fecha total y se recorta hasta obtener el día numerico
        $num = substr($fecha,-12,2);

        //en caso de que sea un dia de solo un dígito se obtiene la barra y se remplaza por un string vacio
        $numFinal = str_replace('/','',$num);

        return $numFinal;
    }

    
    function generarHoras($conexion,$fecha,$minDb,$ini,$fin,$correo){

        $key =0;

        // la hora a la que empieza
        $hora = strtotime($ini);

        // la ultima hora a mostrar
        $horaMaxima = strtotime($fin);

        // los limites para no mostrar el descanso del peluquero
        $limiteHora1 = strtotime("13:00");
        $limiteHora2 = strtotime("17:00");

        // las comprobaciones se hacen en tipo date
        while(date("H:i",$hora) < date("H:i",$horaMaxima)){
            
            if((!(date("H:i",$hora) >= date("H:i",$limiteHora1) && (date("H:i",$hora) < date("H:i",$limiteHora2))))){
                
                $existe = $conexion->query("SELECT fecha_hora FROM Cita");
                $cont = 0;
                
                // se guarda en un array todas las fechas reservadas
                while($resultado = $existe->fetch()){
                    $arrayExiste[$cont] = $resultado[0];
                    $cont++;
                }

                // si el array no existe se guarda en su primera posicion un caracter vacio
                if(!isset($arrayExiste)){
                    $arrayExiste[0] = "";
                }
                
                $fechayHora = substr($fecha,0,-1).strval(date("H:i",$hora));
                
                //se muestran los divs

                // en caso de que la hora este reservada se añade una clase al div
                if(in_array($fechayHora, $arrayExiste)){
                    echo "<div class='tarde horas rojo client'>".date("H:i",$hora)."</div>";

                    // en caso de que no este reservada la hora se envia el correo del cliente y la fecha a borrar 
                }else{
                    echo "<form action='./citaCorreo.php' method='post'>";
                        echo "<input class='tarde horas' name='horaSubmit' type='submit' value='".strval(date("H:i",$hora))."'>";
                        echo "<input type='hidden' name='horaHidden' value='$fechayHora'>";
                        echo "<input type='hidden' name='correoCliente' value='$correo'>";
                        echo "<input type='hidden' name='cliente' value='1'>";  
                    echo "</form>";
                }
            }

            $hora = $hora+60*$minDb;
            $key++;
            
        }
    }

    
    function generarHorasAdmin($conexion,$fecha,$minDb,$ini,$fin){

        $key =0;
        $hora = strtotime($ini);
        $horaMaxima = strtotime($fin);
        $limiteHora1 = strtotime("13:00");
        $limiteHora2 = strtotime("17:00");

        while(date("H:i",$hora) < date("H:i",$horaMaxima)){
            
            if((!(date("H:i",$hora) >= date("H:i",$limiteHora1) && (date("H:i",$hora) < date("H:i",$limiteHora2))))){

                $existe = $conexion->query("SELECT fecha_hora FROM Cita");
                $cont = 0;
                
                while($resultado = $existe->fetch()){
                    $arrayExiste[$cont] = $resultado[0];
                    $cont++;
                }

                if(!isset($arrayExiste)){
                    $arrayExiste[0] = "";
                }
                
                $fechayHora = substr($fecha,0,-1).strval(date("H:i",$hora));
                
                //se muestran los divs

                $tlfCliente = $conexion->query("SELECT telefono FROM Cliente WHERE correo='' ");

                if(in_array($fechayHora, $arrayExiste)){
                    // en caso de que este reservada la hora aparecera un boton para cancelar la hora
                    echo "<form class='formRojo' action='./borrarCita.php' method='post'>";
                        echo "<div class='tarde horas rojo'>".date("H:i",$hora)."</div>";
                        echo "<input class='opcion cancelar' name='horaSubmit' type='submit' value='Cancelar'>";
                        echo "<input type='hidden' name='fechaBorrar' value='$fechayHora'>";
                        echo "<input type='hidden' name='tlf' value='tlf'>";
                        echo "<input type='hidden' name='pag' value='2'>";  
                    echo "</form>";
                }else{
                    
                    // en caso de que la hora este libre es un boton que guarda la hora y la muestra
                    echo "<div class='libre'>";
                        echo "<form action='./modificarHora.php' method='post'>";

                            echo "<input class='tarde horas horaAdmin' name='horaSubmit' type='submit' value='".strval(date("H:i",$hora))."'>";
                            echo "<input type='hidden' name='horaHidden' value='$fechayHora'>"; 

                        echo "</form>";
                    echo "</div>";
                    
                }
            }

            $hora = $hora+60*$minDb;
            $key++;
            
        }
    }

   
?>


