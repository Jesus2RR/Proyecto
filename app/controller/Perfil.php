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
        // se hacen los require necesarios
        require_once("./Cliente.php"); 
        require_once("./conexion.inc.php");
        $conexion = Conexion::openConexion();
        
        if(isset($_SESSION['correo'])){
        if($_SESSION['admin'] == 0){
    ?>
                <input class="check" type="checkbox">
                
                <div class="respmenu">       
                    <nav>
                        <ul>
                            <li><a href="../../index.php">Inicio</a></li>
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
        <form action="./cambiarPerfil.php" method="post">

            <div class="info">
                <label for="nombre">Nombre: <?php echo $_SESSION['nombre']; ?></label>
                <label for="tlf">Teléfono: <?php echo $_SESSION['telefono']; ?></label>
                <label for="correo">Correo: <?php echo $_SESSION['correo']; ?></label>
            </div>
            
            <div class="submitPerfil">
                <input type="submit" name="submit" value="Cambiar datos">
            </div>

        </form>
    </div>

    <hr>

    <div class="scroll">
        <?php
            Cliente::devolverCitas($conexion,$_SESSION['correo']);
        ?>
    </div>
    
    
</body>
</html>