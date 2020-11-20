-- Autor.- Susana Fabián Antón
-- Fecha creación.- 10/11/2020
-- Última modificación.- 10/11/2020

-- creamos la tabla Departamento
CREATE TABLE IF NOT EXISTS Departamento (
    CodDepartamento VARCHAR(3),
    DescDepartamento VARCHAR(255),
    FechaBaja DATE,
    VolumenNegocio FLOAT,
    PRIMARY KEY(CodDepartamento)
)ENGINE=InnoDB;