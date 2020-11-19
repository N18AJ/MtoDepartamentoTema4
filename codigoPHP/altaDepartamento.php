
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
    
if (isset($_REQUEST['enviar'])) {
    $codigo = strtoupper($_REQUEST['codigo']); //strtoupper — Convierte un string a mayúsculas
    
    $aErrores['codigo'] = validacionFormularios::comprobarAlfabetico($_REQUEST['codigo'], 3, 1, 1);
    if($aErrores['codigo'] == null){ // si no ha habido ningun error de validacion del campo del codigo del departamento
        try { // Bloque de código que puede tener excepciones en el objeto PDO
            $mySQL = new PDO(HOST,USER, PASSWD); // creo un objeto PDO con la conexion a la base de datos
            $mySQL->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Establezco el atributo para la apariciopn de errores y le pongo el modo para que cuando haya un error se lance una excepcion

            $selectSQL = "SELECT CodDepartamento FROM Departamento WHERE CodDepartamento = :codigo";
            $sentenciaSQL = $mySQL->prepare($selectSQL); // prepara la consulta
            $codigoDuplicado = [':codigo'=> $_REQUEST['codigo']];
            $sentenciaSQL->execute($codigoDuplicado); // ejecuta la consulta 
            if($sentenciaSQL->rowCount()>0){
                $aErrores['codigo']= "El código del departamento ya existe"; // meto un mensaje de error en el array de errores del codigo del departamento
            }

        }catch (PDOException $mensajeError) { //Cuando se produce una excepcion se corta el programa y salta la excepción con el mensaje de error
            echo "<h4>Se ha producido un error. Disculpe las molestias</h4>";
        } finally {
            unset($mySQL);
        }
    }

    $aErrores['descripcion'] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['descripcion'], 255, 1, 1);
    $aErrores['volumenNegocio'] = validacionFormularios::comprobarFloat($_REQUEST['volumenNegocio'], PHP_INT_MAX, 1, 1);

    foreach ($aErrores as $key => $value) { //recorre el array en busca de mensajes de error
        if ($value != null) {
            $entradaOK = false; //cambia la condiccion de la variable
        }
    }               
                
    if ($entradaOK) { //si el valor es true procesamos los datos que hemos recogido 
        try {
            $mySQL = new PDO(HOST,USER, PASSWD);
                            // set the PDO error mode to exception
						//PDO::ERRMODE_EXCEPTION - Además de establecer el código de error, PDO lanzará una excepción PDOException y establecerá sus propiedades para luego poder reflejar el error y su información.
            $mySQL->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if ($codigo != NULL) {                
                $sqlDepartamento = "INSERT INTO Departamento (CodDepartamento, DescDepartamento, VolumenNegocio) VALUES (:codigo, :descripcion, :volumenNegocio);"; //Los : que van delante, es para indicar que sera una consulta preparada
                $consulta = $mySQL->prepare($sqlDepartamento);
                $consulta->bindParam(":codigo", $_REQUEST['codigo']);
                $consulta->bindParam(":descripcion", $_REQUEST['descripcion']);
                $consulta->bindParam(":volumenNegocio", $_REQUEST['volumenNegocio']);
                $consulta->execute();//Ejecutamos la consulta   
            }
        //Volver a la pagina de inicio
          header("Location: mtoDepartamentos.php");
        } catch (PDOException $exc) {
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
                        <h3>Departamento de Añadido</h3>
                    </header>
                    <div id="cont">
                        <form style="text-align: center;" action="<?php basename($_SERVER['PHP_SELF']) ?>">
                            <label for="codigo">Codigo</label><br>
                            <input type="text" name="codigo" maxlength="3" value="<?php if(isset($aErrores['codigo']) || $aErrores['codigo'] != null)
                                {echo $_REQUEST['codigo'];}?>"><?php if($aErrores['codigo'] != null){echo '<div class="error">'.$aErrores['codigo'].'</div><br>';} ?><br>
                            <label for="descripcion">Descripción</label><br>
                            <input type="text" name="descripcion" value="<?php if(isset($aErrores['descripcion']) || $aErrores['descripcion'] != null)
                                {echo $_REQUEST['descripcion'];}?>"><?php if($aErrores['descripcion'] != null){echo '<div class="error">'.$aErrores['descripcion'].'</div><br>';} ?><br>
                            <label for="volumenNegocio">Volumen de Negocio</label><br>
                            <input type="text" name="volumenNegocio" value="<?php if(isset($aErrores['volumenNegocio']) || $aErrores['volumenNegocio'] != null)
                                {echo $_REQUEST['volumenNegocio'];}?>"><?php if($aErrores['volumenNegocio'] != null){echo '<div class="error">'.$aErrores['volumenNegocio'].'</div><br>';} ?><br>

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

