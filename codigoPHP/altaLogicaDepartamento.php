<?php
require '../config/confDB.php';

if (isset($_GET['cod'])) {
        try {
            $mySQL = new PDO(HOST,USER, PASSWD);
				// set the PDO error mode to exception
                                                    //PDO::ERRMODE_EXCEPTION - Además de establecer el código de error, PDO lanzará una excepción PDOException y establecerá sus propiedades para luego poder reflejar el error y su información.
            $mySQL->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exc) {
            die("No se ha podido establecer la conexión:<br> " . $exc->getMessage());
        }
        try {
            $sqlDepartamento = "UPDATE Departamento SET FechaBaja = NULL WHERE CodDepartamento = :codDept;"; //Los : que van delante, es para indicar que sera una consulta preparada
            $consulta = $mySQL->prepare($sqlDepartamento);
            $consulta->bindParam(":codDept", $_GET['cod']);
            $consulta->execute();
            //Volver a la pagina de inicio
          header("Location: mtoDepartamentos.php");
        } catch (PDOException $exc) {
            die("Error en la insercción de datos:<br> " . $exc->getMessage());
        }
}
?>