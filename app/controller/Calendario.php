<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peluquería Ali</title>
    <link rel="stylesheet" href="../../css/estiloCalendario.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Serif&display=swap" rel="stylesheet"> 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ralewaydisplay=swap" rel="stylesheet"> 
    
    
</head>
<body>
    <!-- se obtienen los archivos js necesarios -->
<script src='../../js/crearDias.js'></script>

    <?php   

        error_reporting(E_ALL);
        ini_set('display_errors', '1');

        session_start();
        require_once("./Horario.php");        
        require_once("./funcionesCalendario.php");
        require_once("./conexion.inc.php");
        
        $conexion = Conexion::openConexion();
        
        
    ?>
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

                
                <h1></h1>

                <div class="diasSemana">
                    <p>L</p>
                    <p>M</p>
                    <p>X</p>
                    <p>J</p>
                    <p>V</p>
                    <p>S</p>
                    <p>D</p>
                </div>

                <div class="center">

                    <form action="./Horas.php" id="formularioCalendario" method="post">
                        <div id='end'></div>
                    </form>

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

                <div class="adminCalendar">
                    <div class="centrarCalendar">
                        <h1></h1>

                        <div class="diasSemana">
                            <p>L</p>
                            <p>M</p>
                            <p>X</p>
                            <p>J</p>
                            <p>V</p>
                            <p>S</p>
                            <p>D</p>
                        </div>

                        <div class="center">

                            <form action="#" id="formularioCalendario" method="post">
                                <div id='end'></div>
                            </form>

                        </div>
                    </div>

                    <div class="mostrarDia">
                            <?php 
                                // se muestra el nombre del usuario y se llaman a las funciones
                                if (!isset($_POST['submit'])){
                                    $dia = diaSemana(date('N'));
                                    $mes = mesSpain(date('n'));
                                    $year = date('Y');
                                    $num = devolverDiaNumerico(date('j'));
                                    $fechaMes = strval('/'.date('n'));
                                    $_POST['submit'] = strval($num.'/'.$mes.'/'.$year.'-'.date('N'));
                                }else{
                                    
                                    $dia = diaSemana($_POST['submit']);
                                    $mes = mesSpain($_POST['submit']);
                                    $num = devolverDiaNumerico($_POST['submit']);
                                    $fechaMes = strval('/'.$_POST['submit']);
                                } 
                                
                                if(date('j') == '1' || '2' || '3' || '4' || '5' || '6' || '7' || '8' || '9'){
                                    $mes = mesSpain($fechaMes);
                                }

                                $ini = Horario::devolverIni($conexion);
                                $fin = Horario::devolverFin($conexion);
                                $mins = Horario::devolverMin($conexion);
                                
                            ?>
                        <h1><?php echo $dia;?></h1>

                        <div><p><?php echo $num." de ".$mes; ?></p></div>

                        <table>
                            <?php 
                            
                            generarHorasAdmin($conexion,$_POST['submit'],$mins,$ini,$fin); 
                            
                            ?>
                        </table>

                    </div>

                    
                    
                </div>
        <?php
            }
        }
    ?>

    <?php 
       
       //se obtienen los dias para mostrar el calendario
        $dias = Horario::devolverDia($conexion);
        echo "<script>crearDias('$dias');</script>";
        
    ?>

</body>
</html>