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
        
        require_once("conexion.inc.php");
        require_once("../../api/vendor/autoload.php");

        // se inicia la conexion 
        $conexion = Conexion::openConexion();
        
        session_start();

        //se obtiene el telefono mediante el correo de la tabla cita por la fecha
        $tlfCliente=$conexion->query("SELECT telefono FROM Cliente WHERE correo = (SELECT correo FROM Cita WHERE fecha_hora = '$_POST[fechaBorrar]')");

        // si llega por post el telefono será el de la sesion sino el de la consulta
        if(!isset($_POST['tlf'])){
            $tlf = $_SESSION['telefono'];
        }else{
            $tlf = $tlfCliente->fetch()[0];
        }
        
        // se obtiene la fecha a borrar mediante post

        $_POST['fechaBorrar'];
        $_POST['pag'];

        
        if(!isset($_POST['admin']) && isset($_POST['tlf'])){
            
            // Cliente::apiCall($tlf);

        }

        // se borra la cita recibida por post
        $borrado = $conexion->query("DELETE FROM Cita WHERE fecha_hora = '$_POST[fechaBorrar]'");
        
    ?>
    
    <div class='center'>
        <div class="mostrar">   
            <p>La cita: <strong> <?php echo $_POST['fechaBorrar'];?> </strong> </p>
            <p>Se ha cancelado correctamente.</p>
            
            <hr>
            <?php 
                // en caso de que se 0 se devuelve al perfil
                if($_POST['pag']==0){
                    ?>
                        <form action='./Perfil.php' method='post'>
                            <input type='submit' value='Continuar'>
                        </form>
                    <?php
                // en caso de que sea 2 se devuelve a horas.php
                }else if($_POST['pag']==2){
                    ?>
                        <form action='./Horas.php' method='post'>
                            <input type='submit' value='Continuar'>
                        </form>
                    <?php
                // en caso de que sea 1 se devuelve a las reservas
                }else{
                    ?>
                    <form action='./Calendario.php' method='post'>
                        <input type='submit' value='Continuar'>
                    </form>
                    <?php
                }
            
            ?>
            
        </div>
    </div>
    
        
    
    
</body>
</html>


















