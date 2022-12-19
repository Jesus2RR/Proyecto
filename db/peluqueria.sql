DROP DATABASE IF EXISTS peluqueria;
CREATE DATABASE peluqueria;

DROP USER IF EXISTS 'test'@'localhost';
CREATE USER 'test'@'localhost' IDENTIFIED BY 'aa';

USE peluqueria;

GRANT ALL ON peluqueria.*TO 'test';

USE peluqueria;

CREATE TABLE Cliente(
    correo varchar(200) PRIMARY KEY,
    nombre varchar(200) NOT NULL,
    pass varchar(200) NOT NULL,
    telefono varchar(200) UNIQUE NOT NULL,
    n_tarjeta char(16), 
    administrador boolean
);

CREATE TABLE Cita(
    fecha_hora varchar(200) PRIMARY KEY,
    correo varchar(200) NOT NULL,
    anotacion varchar(200),
    
    FOREIGN KEY (correo) REFERENCES Cliente (correo) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE Horario(
    idhora int PRIMARY KEY,
    dias varchar(2) NOT NULL,
    horas varchar(3) NOT NULL,
    diaIni varchar(5) NOT NULL,
    diaFin varchar(5) NOT NULL
);