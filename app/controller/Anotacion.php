<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peluquería Ali</title>
    <link rel="stylesheet" href="../../css/estiloreservaPorUsuario.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Serif&display=swap" rel="stylesheet"> 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ralewaydisplay=swap" rel="stylesheet"> 
    
</head>
<body>

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

    <div class='center'>

        <div class='reservar'>

            <?php 
            
                if($_POST['tipo'] == 'bloquear'){
                    $redireccion = "./bloquear.php";
                }else{
                    $redireccion = "./citaCorreo.php";
                }
            ?>
            
            <div class='anotacion'>
                <form action="<?php echo $redireccion;?>" method="post">

                    <label for="anotacion">Anotacion</label>
                    <input type="text" name="anotacion" required>

                    <input type="hidden" name="horaHidden" value='<?php echo $_POST['horaHidden'];?>'>
                    <input type="hidden" name="aceptar" value="0">
                    
                    <input type="submit" value="Enviar">
                </form>
            </div>
        </div>

    </div>
    
    
    
    
</body>
</html>