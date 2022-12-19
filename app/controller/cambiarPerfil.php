<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peluquería Ali</title>
    <link rel="stylesheet" href="../../css/estiloPerfil.css">
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

    <?php 
    // en caso de que exista una sesión se muestra el menu hamburguesa
        if(isset($_SESSION['correo'])){

        // se muestra un menu hamburguesa segun el tipo de usuario
        // menu hamburguesa cliente
            if($_SESSION['admin'] == 0){
                ?>
                    <input class="check" type="checkbox">
                    
                    <div class="respmenu">       
                        <nav>
                            <ul>
                                <li><a href="./index.php">Inicio</a></li>
                                <li><a href="./Perfil.php">Perfil</a></li>
                                <li><a href="./Calendario.php">Calendario</a></li>
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
        <?php
                }else{
                // menu hamburguesa admin
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
            <?php
                }
            }
            ?>
    
    <h1>Perfil Personal</h1>
    <div class="center">
    <form action="#" method="post">

        <div class="info">

            <div>
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" value="<?php echo $_SESSION['nombre']; ?>">
            </div>

            <div>
                <label for="telefono">Teléfono:</label>
                <input type="text" name="telefono" pattern="(6|7)[ -]*([0-9][ -]*){8}" value="<?php echo $_SESSION['telefono']; ?>">
            </div>

            <label for="correo">Correo: <?php echo $_SESSION['correo']; ?></label>
        </div>
        
        <div class="submitPerfil">
            <input type="submit" name="submitPerfil" value="Aplicar cambios">
        </div>

    </form>
    </div>
    <?php 
    
    // se obtienen los ficheros necesarios para modificar el perfil
    
    require_once("./Cliente.php");
    require_once("./conexion.inc.php");
    $conexion = Conexion::openConexion();

    // en caso de que se pulse el submit se verifican los datos de entrada para modificar el perfil
    if(isset($_POST['submitPerfil'])){

        if($_POST['nombre'] == "" || $_POST['nombre'] == " "){
            $msg = "No se permiten dejar campos vacios, por favor introduzcalos.";
            echo "<script>mostrarError('$msg');</script>";
        }else{
            Cliente::modificarPerfil($conexion,$_POST['nombre'],$_POST['telefono'],$_SESSION['correo']);
        }
    }
    
    ?>
</body>
</html>