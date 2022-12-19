<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peluquería Ali</title>
    <link rel="stylesheet" href="../../css/estiloLogin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Serif&display=swap" rel="stylesheet"> 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ralewaydisplay=swap" rel="stylesheet">
     
</head>
<body>
<script src="../../js/mostrarError.js"></script>

    <div class="center"> 
        <div class="login">
            
            <h2>Iniciar Sesión</h2>

            <form action="#" method="post">
                
                <div class="MostrarAviso"></div>

                <label for="correo">Correo</label>
                <input type="text" name="correo" id="correo">

                <label for="pass">Contraseña</label>
                <input type="password" name="pass" id="pass">

                <div>
                    <input type="checkbox" name="recordar">
                    <label for="recordar">Recordar Contraseña</label>
                </div>

                <div class="submitLogin">
                    <input type="submit" name="submit" value="Inicio de Sesión">
                </div>
                
                <a href="./registro.php">¿No tienes cuenta? Regístrate</a>
            </form>
            
            <?php 

            // se obtienen los ficheros necesarios para el login
            
            require_once("./Cliente.php");
            require_once("./conexion.inc.php");
            $conexion = Conexion::openConexion();
            
            // en caso de que se pulse le submit se harán las comprobaciones pertinentes
            if(isset($_POST['submit'])){

                if(empty($_POST['correo'])||empty($_POST['pass'])){
                    $msg = "No se permiten campos vacios, por favor introduzcalos.";
                    echo "<script>mostrarError('$msg');</script>";
                }else{
                    //creacion de variables
                    $correo = $_POST['correo'];
                    $pass = $_POST['pass'];
                    
                    $aviso = Cliente::login($conexion,$correo,$pass);
                    
                    if($aviso){
                        $msg = "El correo o la contraseña no coinciden, por favor intentelo de nuevo.";
                        echo "<script>mostrarError('$msg');</script>";
                    }
                }
            }
            ?>
            
        </div>
    </div>
</body>
</html>