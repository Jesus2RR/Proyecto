<?php

//se importan los archivos js necesarios
echo "<script src='../../js/mostrarError.js'></script>";
echo "<script src='../../js/crearDias.js'></script>";
//se importa el archivo de conexión
require_once("conexion.inc.php");

class Horario extends Conexion{

     // creacion de variables
    private const IDHORAS = 1;
    private $cambioDias;
    private $cambioHoras;

    // constructor 
    function __construct($cambioDias, $cambioHoras){
        $this->cambioDias = $cambioDias;
        $this->nombre = $cambioHoras;
    }

    //funcion para modificar la tabla Horas
    public static function ModificarDatos($conexion,$dias, $horas,$ini, $fin){
        
        $id = self::IDHORAS;

        //se realiza una consulta para obtener datos de la tabla Horas
        $existe = $conexion->query("SELECT * FROM Horario WHERE idhora='$id'");
        $existef = $existe->fetch();
        
        //en caso de que este vacia se hace una insercion, sino se actualiza la insercion hecha previamente
        if(!$existef){
            $insertar = $conexion->exec("INSERT INTO Horario (idhora,dias,horas,diaIni,diaFin) VALUES ('$id', '$dias', '$horas','$ini','$fin')");
        }else{
            $update = $conexion->exec("UPDATE Horario SET dias='$dias', horas='$horas', diaIni='$ini',diaFin='$fin' WHERE idhora='$id'");
        }

    }

    // se devuelve los dias que se mostraran en el calendario
    public static function devolverDia($conexion){
        $id = self::IDHORAS;
        $dia = $conexion->query("SELECT dias FROM Horario WHERE idhora='$id'");
        $diaf = $dia->fetch();

        return $diaf[0];
    }

    // se devuelven los minutos con los que muestran en el calendario
    public static function devolverMin($conexion){
        $id = self::IDHORAS;
        $min = $conexion->query("SELECT horas FROM Horario WHERE idhora='$id'");
        $minf = $min->fetch();

        return $minf[0];
    }

    // se devuelve la hora a la que se inician las horas
    public static function devolverIni($conexion){
        $id = self::IDHORAS;
        $ini = $conexion->query("SELECT diaIni FROM Horario WHERE idhora='$id'");
        $inif = $ini->fetch();

        return $inif[0];
    }

    // se devuelve la hora a la que finalizan las horask 
    public static function devolverFin($conexion){
        $id = self::IDHORAS;
        $fin = $conexion->query("SELECT diaFin FROM Horario WHERE idhora='$id'");
        $finf = $fin->fetch();

        return $finf[0];
    }
}