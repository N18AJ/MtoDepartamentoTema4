<?php
$codigo = $_GET['cod'];
if ($codigo != null) {
    try {
        require '../config/confDB.php';

        $mySQL = new PDO(HOST,USER, PASSWD);
					// set the PDO error mode to exception
						//PDO::ERRMODE_EXCEPTION - Además de establecer el código de error, PDO lanzará una excepción PDOException y establecerá sus propiedades para luego poder reflejar el error y su información.
        $mySQL->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sqlDepartamento = "SELECT * FROM Departamento WHERE CodDepartamento=:codigo"; //Los : que van delante, es para indicar que sera una consulta preparada
        $consulta = $mySQL->prepare($sqlDepartamento);
        $consulta->bindParam(":codigo", $codigo);
        $consulta->execute();

        $result = $consulta->fetch(PDO::FETCH_ASSOC); //Obtiene el resultado de la consulta en formato Array
        $descripcion = $result['DescDepartamento'];
        $fechaBaja = $result['FechaBaja'];
        $volumenNegocio = $result['VolumenNegocio'];
    } catch (Exception $exc) {
        die("No se ha podido establecer la conexión:<br> " . $exc->getMessage());
    }
?>
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
            input{
                width: 185px;
                height: 30px;
                text-align: center;
                margin-bottom: 15px;
                border: 1px solid #8d82c4;
                border-radius:5px;
            }
            #boton{
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
                        <h3>Mostrar Departamento</h3>
                    </header>
                    <div id="cont">
                        <!-- Estructura de formulario -->
                        <h1>Datos del Departamento <?php echo $_GET['cod']; ?></h1>
                        <form style="text-align: center;">
                            <label for="codigo">Codigo</label><br>
                            <input type="text" value="<?php echo $codigo ?>" name="codigo" disabled><br>
                            <label for="descripcion">Descripción</label><br>
                            <input type="text" value="<?php echo $descripcion ?>" name="descripcion" disabled><br>
                            <label for="fechaBaja">Fecha de Baja</label><br>
                            <input type="text" value="<?php echo $fechaBaja ?>" name="fechaBaja" disabled><br>
                            <label for="volumenNegocio">Volumen de Negocio</label><br>
                            <input type="text" value="<?php echo $volumenNegocio ?>" name="volumenNegocio" disabled><br>
                        </form>
                        <!-- Boton VOLVER -->
                        <input id="boton" style="text-align: center;" type="button" name="Volver" value="Volveer" onclick="location='mtoDepartamentos.php'">
<?php 
    } 
?>
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
