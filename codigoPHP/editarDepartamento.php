<?php
//Fichero de URL
require_once '../config/confLocation.php';
require '../core/libreriaValidacion.php';
require '../config/confDB.php';

if (isset($_POST['enviar'])) {
    $entradaOK = true;

    //Declaración del array de errores
    $aErrores['descripcion'] = null;
    $aErrores['volumenNegocio'] = null;

    //Declaración del array de datos del formulario
    $aFormulario['descripcion'] = null;
    $aFormulario['volumenNegocio'] = null;

    if (!isset($_POST['descripcion']) || $_POST['descripcion'] == null) {
                $_POST['descripcion'] = 'Descripción '.$_GET['cod'];
            }
    $aErrores['descripcion'] = validacionFormularios::comprobarAlfaNumerico($_POST['descripcion'], 255, 1, 1);
    if (!isset($_POST['volumenNegocio']) || $_POST['volumenNegocio'] == null) {
                $_POST['volumenNegocio'] = 1;
            }
    $aErrores['volumenNegocio'] = validacionFormularios::comprobarEntero($_POST['volumenNegocio'], PHP_INT_MAX, 1, 1);

    foreach ($aErrores as $campo) { //recorre el array en busca de mensajes de error
        if ($campo != null) {
            $entradaOK = false; //cambia la condiccion de la variable
        }
    }

    if ($entradaOK) { //si el valor es true procesamos los datos que hemos recogido 
        try {
            $mySQL = new PDO(HOST,USER, PASSWD);
					// set the PDO error mode to exception
                                                    //PDO::ERRMODE_EXCEPTION - Además de establecer el código de error, PDO lanzará una excepción PDOException y establecerá sus propiedades para luego poder reflejar el error y su información.
            $mySQL->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $exc) {
            die("No se ha podido establecer la conexión:<br> " . $exc->getMessage());
        }
        try {
            $sqlDepartamento = "UPDATE Departamento SET DescDepartamento=:descDept, VolumenNegocio=:volumenNegocio WHERE CodDepartamento=:codDept"; //Los : que van delante, es para indicar que sera una consulta preparada
            $consulta = $mySQL->prepare($sqlDepartamento);
            $consulta->bindParam(":codDept", $_GET['cod']);
            $consulta->bindParam(":descDept", $_POST['descripcion']);
            
            $consulta->bindParam(":volumenNegocio", $_POST['volumenNegocio']);
            $consulta->execute();
            //Volver a la pagina de inicio
            header('Location: '.URL.'/proyectoDWES/proyectoTema4/MtoDepartamentosTema4/codigoPHP/mtoDepartamentos.php');
        } catch (Exception $exc) {
            die("Error en la insercción de datos:<br> " . $exc->getMessage());
        }
    }
}

if (isset($_GET['cod'])) {
    $codigo = $_GET['cod'];
    try {    
        $mySQL = new PDO(HOST,USER, PASSWD);
					// set the PDO error mode to exception
						//PDO::ERRMODE_EXCEPTION - Además de establecer el código de error, PDO lanzará una excepción PDOException y establecerá sus propiedades para luego poder reflejar el error y su información.
        $mySQL->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sqlDepartamento = "SELECT * FROM Departamento WHERE CodDepartamento=:codigo"; //Los : que van delante, es para indicar que sera una consulta preparada
        $consulta = $mySQL->prepare($sqlDepartamento);
        $consulta->bindParam(":codigo", $codigo);
        $consulta->execute();

        $result = $consulta->fetch(PDO::FETCH_ASSOC); //Obtiene el resultado de la consulta en formato Array
        $cod = $result['CodDepartamento'];
        $descripcion = $result['DescDepartamento'];
        $fechaBaja = $result['FechaBaja'];
        if($fechaBaja==null){
            $fechaBaja='EN SERVICIO';
        }
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
            #botonAceptar{
                margin:20px;
                text-align: center;
                color: #18B618; 
                width: 120px; 
                height: 40px; 
                font-size: 10pt;
                border-radius: 10px;
                border: 2px solid #18B618;
            }
            #botonCancelar{
                margin:20px;
                text-align: center;
                color: #E72727; 
                width: 120px; 
                height: 40px; 
                font-size: 10pt;
                border-radius: 10px;
                border: 2px solid #E72727;
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
                        <h3>Editar el Departamento</h3>
                    </header>
                    <div id="cont">
                        <form style="text-align: center;" action="<?php echo 'editarDepartamento.php?cod=' . $codigo; ?>" method="post">
                            <label for="codigo">Codigo</label><br>
                            <input type="text" value="<?php echo $codigo ?>" name="codigo" disabled><br>
                            <label for="descripcion">Descripción</label><br>
                            <input type="text" value="<?php echo $descripcion ?>" name="descripcion"><br>
                            <label for="fechaBaja">Fecha Baja</label><br>
                            <input type="text" value="<?php echo $fechaBaja ?>" name="fechaBaja" disabled><br>
                            <label for="volumenNegocio">Volumen de Negocio</label><br>
                            <input type="text" value="<?php echo $volumenNegocio ?>" name="volumenNegocio"><br>

                            <input id="botonAceptar" type="submit" name="enviar" value="Aceptar">
                            <input id="botonCancelar" type="button" name="Cancelar" value="Cancelar" onclick="location='mtoDepartamentos.php'">

                        </form>
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
<?php
    } else {
        echo '<h1>No se puede acceder a esta página sin un código de departamento</h1>';
    }
?>
 