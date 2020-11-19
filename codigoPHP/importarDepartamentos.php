<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <meta name="author" content="Nerea Álvarez Justel">
        <meta name="robots" content="index, follow" />
        <title>DAW. Nerea Álvarez Justel</title>
        <!-- CSS -->
        <link href="../webroot/css/estilos.css" rel="stylesheet" type="text/css"/>
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
                        <h3>Importar Departamentos en XML</h3>
                    </header>
                    <div id="cont">
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

                            $instruccion = "INSERT INTO Departamento VALUES (:codigo, :descripcion, NULL,:volumenNegocio)";
                            $insercion = $mySQL->prepare($instruccion);
                            $departamentos = simplexml_load_file("../tmp/ficheroXML.xml");//Importación de un fichero fijo

                            foreach ($departamentos as $departamento) {
                                try {
                                    $insercion->execute(array(':codigo' => $departamento->children()[0], ':descripcion' => $departamento->children()[1], ':volumenNegocio' => $departamento->children()[3]));
                                    echo "<label style='color: green;'>El departamento " . $departamento->children()[0] . " se insertó correctamente.</label><br/>";
                                } catch (PDOException $excepcion) {
                                    echo "<label style='color: red;'>El departamento " . $departamento->children()[0] . " no ha podido insertarse.</label><br/>";
                                } finally {
                                    unset($mySQL); //Se cierra la conexion
                                }
                            }
                        ?>
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
    