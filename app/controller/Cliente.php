<?php

//se importa el archivo js para usar la funcion mostrarError
echo "<script src='../../js/mostrarError.js'></script>";
echo "<script src='../../js/mostrarCitas.js'></script>";
//se importa el archivo de conexión
require_once("conexion.inc.php");

class Cliente extends Conexion{

    // creacion de variables

        private $correo;
        private $nombre;
        private $pass;
        private $repetirpass;
        private $tlf;
        private $n_tarjeta;
        private $administrador;
    
    // constructor 

        function __construct($correo, $nombre, $pass, $repetirpass, $tlf,$n_tarjeta,$administrador=false){
            $this->correo = $correo;
            $this->nombre = $nombre;
            $this->pass = $pass;
            $this->repetirpass = $repetirpass;
            $this->tlf = $tlf;
            $this->n_tarjeta=$n_tarjeta;
            $this->administrador = $administrador;
    }
    
    public static function preRegistro($conexion, $nombre, $correo, $tlf, $pass, $repetirpass){
        
       // se obtienen los datos del Cliente mediante la consulta

        $existeCorreo = $conexion->query("SELECT * FROM Cliente WHERE correo='$correo'");
        $existeTelefono = $conexion->query("SELECT * FROM Cliente WHERE telefono='$tlf'");

        // comprueba que coincidan las contraseñas, que el correo y el telefono no esten en uso

        //si se cumplen algunas de las condiciones se crea el DOM necesario para mostrar el mensaje mediante la funcion mostrarError()

            if($existeCorreo->fetch()){
                
                $msg = 'Este correo ya esta en uso, pruebe con otro.';
                echo "<script>mostrarError('$msg');</script>";

            }else if($pass !== $repetirpass){
                
                $msg = 'No coinciden las contraseñas, por favor intentelo de nuevo.';
                echo "<script>mostrarError('$msg');</script>";

            }else if($existeTelefono->fetch()){
                
                $msg = 'Este telefono ya esta en uso, por favor pruebe con otro.';
                echo "<script>mostrarError('$msg');</script>";

            }else{
                
                // se cifra la contraseña y se llama a la funcion registro
                $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
                
                Cliente::registro($conexion,$nombre, $correo, $tlf, $pass_hash);
            }
    }

    // se efectua la insercion en la tabla Cliente con los datos obtenidos en el preRegistro
    public static function registro($conexion,$nombre, $correo, $tlf, $pass){
        
        try {

            $msg = 'La cuenta ha sido creada con exito.';
            echo "<script>mostrarError('$msg');</script>";

            $insertar = $conexion->exec("INSERT INTO Cliente (nombre,correo,pass,telefono,administrador) VALUES ('$nombre', '$correo', '$pass', '$tlf', false)");

            header("Location: ./login.php");
    
        } catch (PDOException $err) {
            echo "Error insertando el usuario: " . $err->getMessage();
        }

        
    }

    // login del Cliente

    public static function login($conexion, $correo, $pass){
        
        //consulta para obtener los datos del cliente

        $existe = $conexion->query("SELECT * FROM Cliente WHERE correo='$correo'");

        //fetch para acceder a la informacion de la consulta

        $comprobacion=$existe->fetch();
        
        //si no coinciden las pass se muestra un aviso sino se crean sesiones  

        if(!$comprobacion || !password_verify($pass,$comprobacion['pass'])){

            return true;

        }else{

            $user = $comprobacion['nombre'];
            $telefono = $comprobacion['telefono'];
            $administrador = $comprobacion['administrador'];
            //inicios de las sesiones

            session_start();
            $_SESSION['nombre'] = $user;
            $_SESSION['correo'] = $correo;
            $_SESSION['telefono'] = $telefono;
            $_SESSION['pass'] = $pass;
            $_SESSION['admin'] = $administrador;
            echo "Sesion iniciada"; 
            
            // al iniciar la sesión se mueve al usuario a la pagina del calendario

            header("Location: ./Calendario.php");           
        }       

    }

    // funcion para cerrar la sesion de cualquier usuario
    public static function cerrarSesion(){
            
        //se cierra la sesion nombre
        if(isset($_SESSION['nombre'])){
            unset($_SESSION['nombre']);
        }
        //se cierra la sesion correo
        if(isset($_SESSION['correo'])){
            unset($_SESSION['correo']);
        }
        //se cierra la sesion pass
        if(isset($_SESSION['pass'])){
            unset($_SESSION['pass']);
        }
        //se cierra la sesion telefono
        if(isset($_SESSION['telefono'])){
            unset($_SESSION['telefono']);
        }
        //destruccion de la sesiones
        session_destroy();   

    }

    //funcion para modificar el perfil del usuario
    public static function modificarPerfil($conexion,$nombre,$telefono,$correo){

        //se guardan los datos de la sesion para reescribirlos más tarde

        $mantenerSesion = $conexion->query("SELECT nombre,telefono FROM Cliente");
        $mantenerSesionf = $mantenerSesion->fetch();

        $userSesion = $mantenerSesionf['nombre'];
        $telefonoSesion = $mantenerSesionf['telefono'];
        $correoSesion = $correo;

        //consulta para las comprobaciones previas
        $existe = $conexion->query("SELECT telefono FROM Cliente");
        $repetido = false;
        
        // while fetch para comprobar que no este en uso el telefono
        while($existe->fetch()){
            $comprobacion = $existe->fetch();

            if($telefono == $comprobacion['telefono']){

                $repetido = true;
                $msg = 'Este telefono ya esta en uso, porfavor pruebe con otro.';
                echo "<script>mostrarError('$msg');</script>";
                            
            }
        }

        //en caso de que el telefono sea igual que el anterior solo se modifica el nombre
        //mensaje de exito al modificar el usuario

        if($repetido == false){
            $update = $conexion->exec("UPDATE Cliente SET nombre='$nombre', telefono='$telefono' WHERE correo='$correo'");

            $msg = 'El usuario ha sido modificado con exito';
            echo "<script>mostrarError('$msg');</script>";
        }

        //se obtienen los datos actualizados desde la base de datos para sobreescribirlos en las sesiones
        $actualizarDatos = $conexion->query("SELECT nombre,telefono FROM Cliente WHERE correo='$correo'");

        $actualizarDatosf = $actualizarDatos->fetch();

        $_SESSION['nombre'] = $actualizarDatosf['nombre'];
        $_SESSION['telefono'] = $actualizarDatosf['telefono'];
        
        //se refresca la pagina al cabo de un segundo para mostrar los datos actualizados
        header("Refresh: 1; url=./cambiarPerfil.php");

    }

    // funcion para devolver las citas al cliente
    public static function devolverCitas($conexion,$correo){

        // se obtiene la fecha de la cita mediante el correo del usuario que la haya hecho
        $consulta = $conexion->query("SELECT fecha_hora FROM Cita WHERE correo='$correo' ORDER BY fecha_hora");
        $i=0;

        // en caso de que no se devuelvan citas se mostrara el dom oportuno
        if($consulta->rowCount() == 0){
            ?>
            <div class='center'>
                <div class="citas nocita">
                    <p>No hay citas pendientes</p>
                    <div class="divImg">
                        <img id="logo" src="../../img/equis.png" alt="imagen no encontrada">
                    </div>
                </div>
            </div> 
                
            <?php
        }

        while($consultaf = $consulta->fetch()){
            $consultaArray[$i] = $consultaf[0];

            //se recorta el string para obtener la fecha
            $fecha = substr($consultaArray[$i],0,-5);

            //se recorta el string para obtener la hora
            $hora = substr($consultaArray[$i],-5);

            if(substr($fecha,-1,1)=="-"){
                $fecha = substr($consultaArray[$i],0,-6);
            }

            if(substr($hora,0,1)=="-"){
                $fecha = substr($consultaArray[$i],-4);
            }
            
            echo "<div class='citas'>";   
                
                echo "<div class='citasFecha'>";
                    echo "<p>";
                        echo "Fecha: ".$fecha;
                    echo "</p>";

                    echo "<p>";
                        echo "Hora: ".$hora;
                    echo "</p>";

                echo "</div>";

                    echo "<form action='./borrarCita.php' class='formCancelar' method='post'>";
                        echo "<div class='cancelarCita'>
                                <input type='submit' name='submit' value='Cancelar'>
                            </div>";
                        echo "
                            <input type='hidden' name='pag' value='0'>
                            <input type='hidden' name='fechaBorrar' value='$consultaArray[$i]'>
                            ";    
                    echo "</form>";

            echo "</div>";
            
            $i++;

        }
    }

    public static function devolverReservas($conexion){
        
        $consulta = $conexion->query("SELECT fecha_hora,correo,anotacion FROM Cita ORDER BY fecha_hora");
        
        $i=0;

        // en caso de que no se devuelvan citas se mostrara el dom oportuno
        if($consulta->rowCount() == 0){
            ?>
            <div class='center'>
                <div class="citas nocita">
                    <p>No hay citas pendientes</p>
                    <div class="divImg">
                        <img id="logo" src="../../img/equis.png" alt="imagen no encontrada">
                    </div>
                </div>
            </div> 
                
            <?php
        }
        
        while($consultaf = $consulta->fetch()){

            $arrayFechas[$i] = $consultaf['fecha_hora'];
            $arrayCorreos[$i] = $consultaf['correo'];
            $arrayAnotaciones[$i] = $consultaf['anotacion'];

            //se recorta el string para obtener la fecha
            $fecha = substr($arrayFechas[$i],0,-5);

            //se recorta el string para obtener la hora
            $hora = substr($arrayFechas[$i],-5);
            
            if(substr($fecha,-1,1)=="-"){
                $fecha = substr($arrayFechas[$i],0,-6);
            }

            if(substr($hora,0,1)=="-"){
                $fecha = substr($arrayFechas[$i],-4);
            }
            
            echo "<div class='citas'>";   
                
                echo "<div class='citasFecha'>";
                    echo "<p>";
                        echo "Fecha: ".$fecha;
                    echo "</p>";

                    echo "<p>";
                        echo "Hora: ".$hora;
                    echo "</p>";

                    echo "<p>";
                        echo "Correo: ".$arrayCorreos[$i];
                    echo "</p>";

                    if($arrayAnotaciones[$i] != null ){
                        echo "<p>";
                            echo "Anotacion: ".$arrayAnotaciones[$i];
                        echo "</p>";
                    }

                echo "</div>";

                    echo "<form action='./borrarCita.php' class='formCancelar' method='post'>";
                        echo "<div class='cancelarCita'>
                                <input type='submit' name='submit' value='Cancelar'>
                            </div>";
                        echo "
                            <input type='hidden' name='pag' value='1'>
                            <input type='hidden' name='fechaBorrar' value='$arrayFechas[$i]'>
                            <input type='hidden' name'admin' value='admin'>
                            <input type='hidden' name'tlf' value='tlf'>
                            ";    
                    echo "</form>";

            echo "</div>";
            
            $i++;
            
        }
    }

    public static function apiCall($tlf){
        //envio de sms
        $message = new \Esendex\Model\DispatchMessage(
            "Ali", // Send from
            $tlf, // Send to any valid number
            "Su cita de las $_POST[fechaBorrar] ha sido borrada",
            \Esendex\Model\Message::SmsType
        );
        $authentication = new \Esendex\Authentication\LoginAuthentication(
            "EX0349744", // Your Esendex Account Reference
            "9435@cifpceuta.es", // Your login email address
            "54d98e2d1a574e72bebe" // Your password
        );
        $service = new \Esendex\DispatchService($authentication);
        $result = $service->send($message);
    }
}


