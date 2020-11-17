/*Crear tablas.*/
     CREATE TABLE IF NOT EXISTS Departamento2(
        CodDepartamento char(3) PRIMARY KEY,
        DescDepartamento varchar(255) NOT null,
            FechaBaja date,
        VolumenNegocio float NOT null)
    ENGINE=INNODB;

