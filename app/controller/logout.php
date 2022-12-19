<?php

// obtiene el fichero de Cliente
require_once("Cliente.php");

// inicia una sesion para obtener los datos de la misma y poder cerrarla

session_start();
Cliente::cerrarSesion();

// se redirige a la página principal
header("Location:../../index.php");

