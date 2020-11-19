<?php

require '../config/confDB.php';

try {
    $mySQL = new PDO(HOST,USER, PASSWD);
                        // set the PDO error mode to exception
                                            //PDO::ERRMODE_EXCEPTION - Además de establecer el código de error, PDO lanzará una excepción PDOException y establecerá sus propiedades para luego poder reflejar el error y su información.
    $mySQL->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $excepcion) {
    die("Error en la conexión a la base de datos"); //Error al guardar el fichero
}
try {
    $consulta = $mySQL->query("SELECT * FROM Departamento"); //Query a la base de datos para sacar todo lo que tiene
    $XML = new DOMDocument("1.0", "utf-8"); //Creacion del objeto DOMDocument
    $XML->formatOutput = true; //Para que salga bien formateado
//La primera etiqueta será el nombre de la base de datos
    $raiz = $XML->appendChild($XML->createElement("Departamentos"));

    while ($linea = $consulta->fetchObject()) {
        $departamento = $raiz->appendChild($XML->createElement("Departamento"));
        $departamento->appendChild($XML->createElement("CodDepartamento", $linea->CodDepartamento));
        $departamento->appendChild($XML->createElement("DescDepartamento", $linea->DescDepartamento));
        $departamento->appendChild($XML->createElement("FechaBaja", $linea->FechaBaja));
        $departamento->appendChild($XML->createElement("VolumenNegocio", $linea->VolumenNegocio));
    }
    $XML->saveXML(); //Guarda la estructura XML en formato String
    
    $fechaActual = new DateTime();
    $fileName = $fechaActual->format("Ymd") . "-" . date('h:i:s a', time()) . "departamento.xml";

    if ($XML->save("../tmp/ficheroXML.xml")) {//Si se ha podido guardar el ficheroXML
        header('Content-Type: text/xml'); //Poner cabecera de XML
        header("Content-Disposition: attachment; filename=$fileName"); //Colocar la cabecera de xml en  el fichero
        readfile("../tmp/ficheroXML.xml"); //Descargar el fichero en el cliente
    } else {
        die("Error al exportar el fichero"); //Si ocurre un error
    }
} catch (PDOException $excepcion) {
    echo "Error: " . $excepcion->getMessage() . "<br>";
    echo "Codigo del error: " . $excepcion->getCode() . "<br>";
} finally {
    unset($mySQL);//Se cierra la conexion
}
?>