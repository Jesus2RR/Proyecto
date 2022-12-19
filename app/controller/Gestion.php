<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peluquería Ali</title>
    <link rel="stylesheet" href="../../css/estiloGestion.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Serif&display=swap" rel="stylesheet"> 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ralewaydisplay=swap" rel="stylesheet"> 
    
    
</head>
<body>
    <?php session_start();?>
    <input class="check" type="checkbox">
    <script src='../../js/controlHoras.js'></script>
    <?php 
        
        if($_SESSION['admin'] == 1){
    
    ?>
                <input class="check" type="checkbox">

                <div class="respmenu">    
                  
                    <nav>
                        <ul>
                            <li><a href="../../index.php">Inicio</a></li>
                            <li><a href="./Perfil.php">Perfil</a></li>
                            <li><a href="./Calendario.php">Calendario</a></li>
                            <li><a href="./Gestion.php">Configurar Calendario</a></li>
                            <li><a href="./reservas.php">Reservas</a></li>
                            <li><a href="./logout.php" class="cerrarSesion">Cerrar sesión</a></li>
                        </ul>
                    </nav>
                </div>
            
                <div class="superior">
                
                    <div class="menuH">
                        <div class="hamburguesa bar1"></div>
                        <div class="hamburguesa bar2"></div>
                        <div class="hamburguesa bar3"></div>
                    </div>
                    
                </div>

    

    <div class="center">
    
        <form action="#" onsubmit="return exReg()" method="post">
        <h1>Gestion del Calendario</h1>
            <div class="info">
                <div>
                    <label for="dias">Intervalo de días:</label>
                    <input type="text" name="dias" value="">
                </div>

                <div>
                    <label for="horas">Intervalo de horas (min):</label>
                    <input type="text" name="horas" class="min" value="">
                </div>

                <div>
                    <label for="horaIni">Hora Inicial:</label>
                    <input type="text" name="horaIni" id="ini" value="">
                </div>

                <div>
                    <label for="horaFinal">Hora Final:</label>
                    <input type="text" name="horaFinal" id="fin" value="">
                </div>
                
            </div>

            <div class="submitGestion">
                <input type="submit" name="submitGestion" value="Modificar Calendario">
            </div>

        </form>
    </div>

    <?php

        }

    // se hacen los require necesarios
    
    require_once("./conexion.inc.php");
    require_once("./Horario.php");
    $conexion = Conexion::openConexion();

    // en caso de que se pulse el submit se comprobara la entrada de datos
    if(isset($_POST['submitGestion'])){

        if($_POST['horaFinal'] == " " || $_POST['horaFinal'] == "" || $_POST['horaIni'] == " " || $_POST['horaIni'] == "" || $_POST['dias'] == "" || $_POST['dias'] == " " || $_POST['horas'] == "" || $_POST['horas'] == " "){

            $msg = "No se permiten dejar campos vacios, por favor introduzcalos.";
            echo "<script>mostrarError('$msg');</script>";

        }else{
            Horario::ModificarDatos($conexion,$_POST['dias'],$_POST['horas'],$_POST['horaIni'],$_POST['horaFinal']);
            
        }
    }

    ?>
    
</body>
</html>