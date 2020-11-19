<?php
require '../core/libreriaValidacion.php';
require '../config/confDB.php';

    $entradaOK = true;

//Declaración del array de errores
    $aErrores['codigo'] = null;
    $aErrores['descripcion'] = null;
    $aErrores['volumenNegocio'] = null;

//Declaración del array de datos del formulario
    $aFormulario['codigo'] = null;
    $aFormulario['descripcion'] = null;
    $aFormulario['volumenNegocio'] = null;
    
if (isset($_REQUEST['Aceptar'])) {
    $codigo = strtoupper($_REQUEST['codigo']); //strtoupper — Convierte un string a mayúsculas
    
    $aErrores['codigo'] = validacionFormularios::comprobarAlfabetico($_REQUEST['codigo'], 3, 1, 1);
    $aErrores['descripcion'] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['descripcion'], 255, 1, 1);
    $aErrores['volumenNegocio'] = validacionFormularios::comprobarEntero($_REQUEST['volumenNegocio'], PHP_INT_MAX, 1, 1);

    foreach ($aErrores as $key => $value) { //recorre el array en busca de mensajes de error
        if ($value != null) {
            $entradaOK = false; //cambia la condiccion de la variable
        }
    }               
                
    if ($entradaOK) { //si el valor es true procesamos los datos que hemos recogido 
        try {
            $mySQL = new PDO("mysql:host=".SERVER.";dbname=".DB, USER, PASSWD);// Datos de la conexión a la base de datos
            $mySQL->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);// set the PDO error mode to exception
        } catch (Exception $exc) {
            die("No se ha podido establecer la conexión:<br> " . $exc->getMessage());
        }
        try {
            if ($codigo != NULL) {
                $sqlDepartamento2 = "INSERT INTO `Departamento` (`CodDepartamento`, `DescDepartamento`, `FechaBaja`, `VolumenNegocio`) VALUES (:codigo, :descripcion, NULL, :volumenNegocio);"; //Los : que van delante, es para indicar que sera una consulta preparada
                $consulta = $mySQL->prepare($sqlDepartamento2);
                $consulta->bindParam(":codigo", $codigo);
                $consulta->bindParam(":descripcion", $_REQUEST['descripcion']);
                $consulta->bindParam(":volumenNegocio", $_REQUEST['volumenNegocio']);
                $consulta->execute();
            }
        } catch (Exception $exc) {
            die("Error en la insercción de datos:<br> " . $exc->getMessage());
        }
    }
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <meta name="author" content="Nerea Álvarez Justel">
        <meta name="robots" content="index, follow" />
        <title>DAW. Nerea Álvarez Justel</title>
        <!-- CSS -->
        <link href="../webroot/css/estilos.css" rel="stylesheet" type="text/css">
        <!-- Favicon -->
        <link rel="icon" href="../../../../favicon.png" type="x-icon">
        <!-- Tipografía -->
        <link href="https://fonts.googleapis.com/css?family=ZCOOL+KuaiLe" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Caveat&display=swap" rel="stylesheet">
        <style>
            #cont{
                text-align: center;
            }
            #botonAceptar{
                margin:20px;
                text-align: center;
                color: #8d82c4; 
                width: 120px; 
                height: 40px; 
                font-size: 10pt;
                border-radius: 10px;
                border: 1px solid #8d82c4;
            }
        </style>
    </head>

    <body> 
        <!-- Header -->
        <header id="header">
            <a href="https://www.linkedin.com/in/nerea-%C3%A1lvarez-justel-a99b0a166/" target="_blank"><img src="../webroot/media/images/link.png" alt="LinkedIn" width="65" class="icono_link"/></a>
            <a href="../../../../index.html"><img src="../webroot/media/images/logo.png" alt="Logo" width="150" class="icono_logo"/></a>
            <a href="https://github.com/N18AJ" target="_blank"><img src="../webroot/media/images/git.png" alt="GitHub" width="65" class="icono_git"/></a>
        </header>


        <!-- Main -->
        <div id="main">

            <!-- Tiles -->
            <section class="tiles">
                <article>
                    <header class="major">
                        <h3>Exportar Departamentos</h3>
                    </header>
                    <div id="cont">
                        <table>
                            <tr>
                                <td><a href="../tmp/ficheroXML.xml" target="_blank"><h3>Mostrar ficheros exportados</h3></a></td>
                                <td><a href="exportarXML.php"><h3>Exportar a XML</h3></a></td>
                            </tr>
                        </table>   
                        <input id="botonAceptar" type="button" name="Volver" value="Volver" onclick="location='mtoDepartamentos.php'">
                    </div> 
                </article>
            </section>
        </div>

        <!-- Footer -->
        <footer id="footer">
            <a href="../../../../index.html"><div class="copyright">&copy; Nerea Álvarez Justel</div></a>
        </footer>
    </body>
</html>

