<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peluquería Ali</title>
    <link rel="stylesheet" href="../../css/estiloRegistro.css">
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
    <div class="center">
        <div class="login">
        
        <h2>Registro</h2>

        <form action="#" method="post">

            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" >

            <label for="correo">Correo</label>
            <input type="email" name="correo" id="correo">

            <label for="tlf">Telefono</label>
            <input type="text" name="tlf" pattern="(6|7)[ -]*([0-9][ -]*){8}" id="telefono" >

            <label for="pass">Contraseña</label>
            <input type="password" name="pass" id="pass" >

            <label for="repetirpass">Repetir Contraseña</label>
            <input type="password" name="repetirpass" id="repetirpass" >

            <div class="submitLogin">
                <input type="submit" name="submit" value="Regístrate">
            </div>
            
        </form>

        <?php 

        // se accede a los ficheros necesarios

        require_once("./Cliente.php");
        require_once("./conexion.inc.php");
        $conexion = Conexion::openConexion();

        // si se envia el formulario se harán las comprobaciones

        if (isset($_POST['submit'])) {

            //Comprobamos que todos los campos necesarios han sido rellenados en el formulario
            if(empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['repetirpass']) ||empty($_POST['pass']) || empty($_POST['tlf'])){

                $msg = 'No se permiten campos vacios, por favor complete el formulario.';
                echo "<script>mostrarError('$msg');</script>";

            }else{
                $nombre = $_POST['nombre'];
                $correo = $_POST['correo'];
                $repetirpass = $_POST['repetirpass'];
                $tlf = $_POST['tlf'];
                $pass= $_POST['pass'];
                
                Cliente::preRegistro($conexion, $nombre, $correo, $tlf, $pass, $repetirpass);
                
            }
         }
        ?>
        

        </div>
    </div>
</body>
</html>