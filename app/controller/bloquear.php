<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peluquería Ali</title>
    <link rel="stylesheet" href="../../css/estiloborrarCita.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Serif&display=swap" rel="stylesheet"> 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ralewaydisplay=swap" rel="stylesheet"> 
    
    
</head>
<body>

    <?php
        // require de los ficheros necesarios
        // se inicia la conexion
        error_reporting(E_ALL);
        ini_set('display_errors', '1');
        require_once("conexion.inc.php");
        require_once("Cliente.php");
        $conexion = Conexion::openConexion();

        echo $_POST['horaHidden'];

        session_start();
        $correo = $_SESSION['correo'];
        
        // insert con la hora enviada por formulario, correo logeado actual y un mensaje como anotación
        if($_POST['aceptar'] == 1){
            $insert = $conexion->exec("INSERT INTO Cita (fecha_hora, correo, anotacion) VALUES ('$_POST[horaHidden]','$correo', 'HORA BLOQUEADA')");
        }else{
            $insert = $conexion->exec("INSERT INTO Cita (fecha_hora, correo, anotacion) VALUES ('$_POST[horaHidden]','$correo', '$_POST[anotacion]')");
        }
        
    ?>
    <!-- formulario para enviar de vuelta a la página horas.php -->
    <div class='center'>
        <div class="mostrar">   
            <p>La cita: <?php echo $_POST['horaHidden']; ?></p>
            <p>Se ha bloqueado correctamente.</p>
            
            <hr>
            <?php 
                
                ?>
                <form action='./Calendario.php' method='post'>
                    <input type='submit' value='Continuar'>
                </form>
                <?php

            ?>
            
        </div>
    </div>
    
</body>
</html>






















                
            
          

