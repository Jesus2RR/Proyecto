<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peluquería Ali</title>
    <link rel="stylesheet" href="../../css/estiloCitaAdmin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Serif&display=swap" rel="stylesheet"> 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ralewaydisplay=swap" rel="stylesheet"> 
    
    
</head>
<body>
<script src='../../js/mostrarError.js'></script>
    <?php 
    
    // se hacen los requires necesarios
    require_once("conexion.inc.php");
    $conexion = Conexion::openConexion();
    
    session_start();
    $correo = $_SESSION['correo'];

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

                <div class='fondo'>
                    <h2>Reservar Usuario</h2>

                    <form class='formData' action='#' method='post'>
                        <label for="txtCorreo">Introduzca un correo</label>
                        <input class='tCorreo' name='txtCorreo' type='email'>

                        <label for="comentario">Anotaciones</label>
                        <textarea name="comentario"></textarea>

                        <p>Horario: <?php echo $_POST['horaHidden'];?></p>

                        <input type='hidden' name='horaHidden' value='<?php echo $_POST['horaHidden'];?>'>
                        
                        <div class="submitModificar">
                            <input class='sCorreo' name='citaSubmit' type='submit' value='Enviar'>
                        </div>

                    </form>

                    <form class='formBloq' action="./bloquear.php" method='post'>

                        <input type='hidden' name='horaHidden' value='<?php echo $_POST['horaHidden'];?>'>
                        
                        <div class="submitModificar">
                            <input type="submit" name='blockSubmit' class='sCorreo bloquear' value="Bloquear">
                        </div>
                        
                        
                    </form>

                </div>

            </div>

        <?php
        
        // en caso de que se pulse el submit se hacen las comprobaciones
        if(isset($_POST['citaSubmit'])){

            // si todos los campos estan vacios
            if((empty($_POST['comentario'])) && empty($_POST['txtCorreo'])){

                $msg = 'Debe al menos introducir un campo.';
                echo "<script>mostrarError('$msg');</script>";
    
            }

            // si solo se introduce el correo se hace la insercion en base de datos con el correo
            if($_POST['txtCorreo'] && empty($_POST['comentario'])){
                $comprobar = $conexion->query("SELECT correo FROM Cliente");

                $x=0;

                while($comprobarf = $comprobar->fetch()){
                    $correos[$x] = $comprobarf[0];

                    if($correos[$x] != $_POST['txtCorreo']){
                        $error = false;
                        
                    }else{
                        $error = true;
                    }

                    $x++;
                }

                if($error == false){

                    $msg = 'Este correo no esta registrado, pruebe de nuevo.';
                    echo "<script>mostrarError('$msg');</script>";

                }else{

                    header("Location: ./citaCorreo.php?txtCorreo=$_POST[txtCorreo]&horaHidden=$_POST[horaHidden]");
                    
                }
                
            }

            // si se introduce solo la anotacion se hace la insercion con el correo del admin
            if($_POST['comentario'] && empty($_POST['txtCorreo'])){

                header("Location: ./citaCorreo.php?horaHidden=$_POST[horaHidden]&comentario=$_POST[comentario]");
            }

            // si se introduce el correo y la anotacion se inserta con el correo introducido 
            if($_POST['comentario'] && $_POST['txtCorreo']){

                header("Location: ./citaCorreo.php?txtCorreo=$_POST[txtCorreo]&horaHidden=$_POST[horaHidden]&comentario=$_POST[comentario]");
                
            }

        }
    
    }
    
    ?>
</body>
</html>






















                
            
          

