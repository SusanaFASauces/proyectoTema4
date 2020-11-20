-- Autor.- Susana Fabián Antón
-- Fecha creación.- 27/10/2020
-- Última modificación.- 10/11/2020

-- creamos la base de datos
CREATE DATABASE IF NOT EXISTS DAW208DBDepartamentos;

-- creamos el usuario administrador de la base de datos
CREATE USER IF NOT EXISTS 'usuarioDAW208DBDepartamentos'@'%' IDENTIFIED BY 'P@ssw0rd';

-- utilizamos de la base de datos
USE DAW208DBDepartamentos;

-- creamos las tablas que va a usar nuestra base de datos
CREATE TABLE IF NOT EXISTS Departamento (
    CodDepartamento VARCHAR(3) NOT NULL,
    DescDepartamento VARCHAR(255) NOT NULL,
    FechaBaja DATE NULL,
    VolumenNegocio FLOAT NOT NULL,
    PRIMARY KEY(CodDepartamento)
);

-- otorgamos permisos a la tabla 'Departamento'
GRANT ALL PRIVILEGES ON DAW208DBDepartamentos.* TO 'usuarioDAW208DBDepartamentos'@'%';