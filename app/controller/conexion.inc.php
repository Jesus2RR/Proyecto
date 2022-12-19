<?php
    class Conexion {
        // crea la variable de conexion
        private static $conexion;

        // funcion que crea la conexion con la base de datos segun los datos ofrecidos a la misma

        public static function openConexion(){

            // si existe la variable conexion accede al fichero con los datos de la bbdd

            if(!isset(self::$conexion)){

                try{

                    // acceso al archivo con los datos de la conexion

                    require_once('config.inc.php');

                    // crea una conexion mediante PDO con los datos ofrecidos

                    self::$conexion = new PDO('mysql:host='. NOMBRE_SERVIDOR . '; dbname=' . NOMBRE_BD, NOMBRE_USUARIO, PASSWORD);
                    self::$conexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // se ejecuta la conexion, ya que es una consulta preparada

                    self::$conexion -> exec("SET CHARACTER SET utf8");

                    // se devuelve la conexion

                    return self::$conexion;
                }catch(PDOException $ex){
                    print "ERROR: " . $ex -> getMessage() . "<br/>";
                    die();
                }
            }
        }

        // funcion para cerrar la conexion

        public static function closeConexion(){
            if(isset(self::$conexion)){
                self::$conexion = null;
            }
        }
        
    }