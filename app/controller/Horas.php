<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario</title>
    <link rel="stylesheet" href="../../css/estiloHoras.css">
    <?php 
    // se hace un require para poder utilizar las funciones necesarias
        require_once("./Horario.php");        
        require_once("./conexion.inc.php");
        $conexion = Conexion::openConexion();
        require_once("./funcionesCalendario.php");
        
    // se inicia la sesion
        session_start();

        if(isset($_POST['submit'])){
            $_SESSION['fecha'] = $_POST['submit'];
        }
    ?>
</head>
<body>
    <?php
    $correo  = $_SESSION['correo'];
    
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
    ?>
    <main>
        <div class="mainCalendario"> 

            <div class="calendario">
                
                <?php
                    // se muestra el nombre del usuario y se llaman a las funciones
                    echo $_SESSION['nombre'];
                    $fecha = $_SESSION['fecha'];
                    $mins = Horario::devolverMin($conexion);
                    $dia = diaSemana($fecha);
                    $mes = mesSpain($fecha);
                    $num = devolverDiaNumerico($fecha);
                ?>

            </div>           
            
            <div class="diaLetra">
                <h1><?php echo $dia?></h1>
                <div><p><?php echo $num." de ".$mes; ?></p></div>
            </div>

            <div class="conjuntoHoras">
                <div class="Horas">
                    <!-- se recogen todos los nombres del los divs para utilizarlos posteriormente como clave principal en la insercion -->
                    <?php $ini = Horario::devolverIni($conexion);?>
                    <?php $fin = Horario::devolverFin($conexion);?>
                    <?php 
                    if($_SESSION['admin'] ==0){
                        generarHoras($conexion,$fecha,$mins,$ini,$fin,$correo);
                    }else{
                        generarHorasAdmin($conexion,$fecha,$mins,$ini,$fin);
                    }
                    ?>
                </div>
            </div>  
        </div>
    </main>
</body>
</html>