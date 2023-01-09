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
        // se hace require de los archivos necesarios
        error_reporting(E_ALL);
        ini_set('display_errors', '1');
        require_once("conexion.inc.php");
        require_once("Cliente.php");
        require_once("../../api/vendor/autoload.php");

        // se inicia la conexion
        $conexion = Conexion::openConexion();
        
        session_start();
        $correo = $_SESSION['correo'];
        $tlf = $_SESSION['telefono'];
        
        // en caso de que se devuelva cliente por post se ingresa la cita al cliente
        if(isset($_POST['cliente'])){

            $fechaYhora = $_POST['horaHidden']; 
            $_POST['correoCliente'];
            $existe = $conexion->query("SELECT fecha_hora FROM Cita");
            $cont = 0;
            
            // while fetch para obtener todas las citas 
            while($resultado = $existe->fetch()){
                $arrayExiste[$cont] = $resultado[0];
                $cont++;
            }
            
            // en caso de que no hayan citas se iguala la primera posicion del array a ""
            if(!isset($arrayExiste)){
                $arrayExiste[0] = "";
            }

            //si se pulsa el submit y no existe la cita en el array se hace la insercion
            if(isset($_POST['horaSubmit']) && !in_array($fechaYhora, $arrayExiste)){

                // Cliente::apiCall($tlf);
                
                $insert = $conexion->exec("INSERT INTO Cita (fecha_hora, correo) VALUES ('$fechaYhora','$_POST[correoCliente]')");
            }
            ?>
                <div class='center'>
                    <div class="mostrar">   
                        <p>La cita ha sido reservada con exito.</p>
                        
                        <hr>
                        
                        <form action='./Horas.php' method='post'>
                            <input type='submit' value='Continuar'>
                        </form>
                        
                    </div>
                </div>
            <?php

        }else{
            // comprobación de variables

            if(!isset($_POST['txtCorreo'])){
                $_POST['txtCorreo'] = $_SESSION['correo'];
            }

            $fallo = 0;
            $existeCorreo = $conexion->query("SELECT correo FROM Cliente");
            $o = 0;

            while($existeCorreof = $existeCorreo->fetch()){
                $correos[$o] = $existeCorreof[0];
                
                if ($correos[$o] == $_POST['txtCorreo']){
                    $fallo = 1;
                }
                
                $o++;
            }

            if($fallo == 0){
                ?>
                    <div class='center'>
                        <div class="mostrar">   
                            <p>Este correo no existe, intentelo de nuevo</p>

                            <hr>
                            
                            <form action='./Calendario.php' method='post'>
                                <input type='submit' value='Volver'>
                            </form>
                            
                        </div>
                    </div>
                <?php
            }else{

                $tlfCliente = $conexion->query("SELECT telefono FROM Cliente WHERE correo ='$_POST[txtCorreo]'");
                $tlf = $tlfCliente->fetch()[0];
    
                // en caso de que no existan anotaciones se hará la insercion solo con el correo
                if(!isset($_POST['anotacion'])){
                    ?>
                    <div class='center'>
                        <div class="mostrar">   
                            <p>La cita <strong> <?php echo $_POST['horaHidden'];?> </strong></p>
                            <p>Se asignó a <?php echo $_POST['txtCorreo'];?>.</p>
                            
                            <hr>
                            
                            <form action='./Calendario.php' method='post'>
                                <input type='submit' value='Continuar'>
                            </form>
                            
                        </div>
                    </div>
                    <?php
    
                    //Cliente::apiCall($tlf);
    
                    $insert = $conexion->exec("INSERT INTO Cita (fecha_hora,correo) VALUES ('$_POST[horaHidden]','$_POST[txtCorreo]')");
    
                }else{
                    
                    ?>
                    <div class='center'>
                        <div class="mostrar">   
                            <?php 
                                // si se envia un correo y una anotacion se hace el insert con ambas
                                if(isset($_POST['txtCorreo'])){
                            ?>
                                <p>La cita <strong> <?php echo $_POST['horaHidden'];?> </strong></p>
                                <p>Se asignó a <?php echo $_POST['txtCorreo'];?>.</p>
                                <p>Anotacion:<?php echo $_POST['anotacion'];?></p>
                                
                                <?php
    
                                // Cliente::apiCall($tlf);
    
                                    $insert = $conexion->exec("INSERT INTO Cita (fecha_hora,correo,anotacion) VALUES ('$_POST[horaHidden]','$_POST[txtCorreo]','$_POST[anotacion]')");
                                
                                ?>
                                <hr>
    
                            <?php
    
                                }else{
                                    // en caso de que no se envie ningun correo se hace la insercion con la anotacion y el correo del admin
                                    ?>
                                        <p>La cita <strong> <?php echo $_POST['horaHidden'];?> </strong> ha sido reservada con exito.</p>
                                        <p>Anotacion:<?php echo $_POST[anotacion];?></p>
                                        
                                        <hr>
                                    <?php
    
                                if($_POST['aceptar'] == 1){
                                    $insert = $conexion->exec("INSERT INTO Cita (fecha_hora, correo) VALUES ('$_POST[horaHidden]','$correo',)");
                                }else{
                                    $insert = $conexion->exec("INSERT INTO Cita (fecha_hora,correo,anotacion) VALUES ('$_POST[horaHidden]','$correo','$_POST[anotacion]')");
                                }
                                    
                                }
                            ?>
                            
                            <form action='./Calendario.php' method='post'>
                                <input type='submit' value='Continuar'>
                            </form>
                            
                        </div>
                    </div>
                    <?php
    
                    
                }

            }

            

        }
    ?>
    
</body>
</html>