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
            div{
                margin-top: 10px;
                font-family: 'Caveat';
            }
            table{
                border-collapse: collapse;
                 text-align:center;
                 margin-bottom:10px;
            }
            th{
                font-size: 24px;
                width: 25%;
                border-bottom: 2px solid white;
                margin-bottom: 20px;
            }
            td{
                margin-top: 10px;
                text-align: center;
            }
            .icon{
                width: 20px;
                text-align: center;
                margin: 5px;
            }
            .icon2{
                width: 30px;
                text-align: center;
                margin: 10px;
                border-radius:5px;
            }
            #boton{
                width: 100px;
                height: 40px;
                margin-left:10px;
                color: #8d82c4;
                border: 1px solid #8d82c4;
                border-radius:5px;
                background-color: white;
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
            input{
                width: 185px;
                height: 30px;
                text-align: center;
                margin-bottom: 15px;
                font-size: 12pt;
                margin-left:10px;
            }
        </style>
    </head>

    <body> 
        <!-- Header -->
        <header id="header">
            <a href="../../../doc/cv.pdf" target="_blank"><img src="../webroot/media/images/cv2.png" alt="CV" width="55" class="icono_link"/></a>
            <a href="http://daw212.ieslossauces.es/"><img src="../webroot/media/images/logo2.png" alt="Logo" width="150" class="icono_logo"/></a>
            <a href="https://github.com/N18AJ" target="_blank"><img src="../webroot/media/images/git2.png" alt="GitHub" width="65" class="icono_git"/></a>
        </header>
        <!-- Main -->
        <div id="main">
            <!-- Tiles -->
            <section class="tiles">
                <article>
                    <header class="major">
                        <h3 style="text-align: center;">Mantenimiento de Departamentos</h3>
                    </header>
                    <div id="cont">
                         <?php
                         
                        require '../config/confDB.php';
                        require '../core/libreriaValidacion.php';
                        
                        //Declaración de variables
                        $entradaOK = true;

                        //Declaración del array de errores
                        $aErrores['buscar'] = null;

                        //Declaración del array de datos del formulario
                        $aFormulario['buscar'] = null;

                        if (isset($_POST['enviar'])) {//Código que se ejecuta cuando se envia el formulario               
                            $aErrores['buscar'] = validacionFormularios::comprobarAlfaNumerico($_POST['buscar'], 255, 1, 0);
                            foreach ($aErrores as $campo) { //recorre el array en busca de mensajes de error
                                if ($campo != null) {
                                    $entradaOK = false; //cambia la condiccion de la variable
                                }
                            }
                        } else {
                            $entradaOK = false; //cambiamos el valor de la variable porque no se ha pulsado el bot�n de enviar
                        }
                        ?>
                        <!-- BOTONERA INICIAL -->
                        <div style="text-align: center;">
                            <div id="botonAceptar" style="display:inline-block;">
                                <a href="altaDepartamento.php"><h3>Añadir</h3></a>
                            </div>
                            <div id="botonAceptar" style="display:inline-block; ">
                                <a href="importarDepartamentos.php"><h3>Importar</h3></a>
                            </div>
                            <div id="botonAceptar" style="display:inline-block;">
                                <a href="exportarDepartamentos.php"><h3>Exportar</h3></a>
                            </div>
                            <div id="botonAceptar" style="display:inline-block;">
                                <a href="../../indexTema4.html"><h3>Salir</h3></a>
                            </div>
                        </div>
                        <!-- BUSQUEDA -->
                        <h3>Departamento de busqueda</h3>
                        <form name="form1" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" style="text-align: center;">
                            <label style="font-size:20pt;">Descripción departamento</label>
                            <input type="text" name="buscar" style="border: 1px solid #8d82c4;border-radius:5px;" placeholder="Descripcion Dept." value="<?php
                            if ($aErrores['buscar'] == NULL && isset($_POST['buscar'])) {
                                echo $_POST['buscar'];
                            }
                            ?>"> 
                            <input id="boton" type="submit" value="Buscar" name="enviar">
                            <!--//Si el valor es bueno, lo escribe en el campo-->
                            <?php if ($aErrores['buscar'] != NULL) { ?>
                                <div class="error">
                                    <?php echo $aErrores['buscar']; //Mensaje de error que tiene el array aErrores  ?>
                                </div>   
                            <?php 
                            } 
                        ?>  
                        </form>
                        <?php
                        if (isset($_POST['buscar'])) {
                            $aFormulario['buscar'] = $_POST['buscar']; //en el array del formulario guardamos los datos
                        } else {
                            $aFormulario['buscar'] = '';
                        }
                        //Se establece la conexión tanto si se ha posteado buscar como si no
                        try {
                            $mySQL = new PDO(HOST,USER, PASSWD);
                                                // set the PDO error mode to exception
                                                                    //PDO::ERRMODE_EXCEPTION - Además de establecer el código de error, PDO lanzará una excepción PDOException y establecerá sus propiedades para luego poder reflejar el error y su información.
                            $mySQL->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        } catch (PDOException $exc) {
                            echo "Error:". $exc->getMessage() ." <br>";
                            echo "Codigo del error: ".$exc->getCode() ."<br>";
                        }
                        //Si se ha pasado la variable pag se coge y si no se pone a 0
                        if (isset($_GET['pag'])) {
                            $pag = $_GET['pag'];
                        } else {
                            $pag = 0;
                        }

                        //Si se ha pasado por buscar, se hace una consulta filtrando por ese registro
                        if ($aErrores['buscar'] == null && $aFormulario['buscar'] != null) {
                            try {
                                $sqlDepartamento = "SELECT * FROM Departamento where DescDepartamento LIKE '%" . $aFormulario["buscar"] . "%'"; //Los : que van delante, es para indicar que sera una consulta preparada
                                $consulta = $mySQL->prepare($sqlDepartamento);
                                $consulta->execute();
                                $consulta = $mySQL->query($sqlDepartamento);
                                echo 'Se han encontrado <strong style="color:red;">' . $consulta->rowCount() . "</strong> resultados<br><br>";
                            } catch (PDOException $exc) {
                                echo "Error: $exc->getMessage() <br>";
                                echo "Codigo del error: $exc->getCode() <br>";
                            } finally {
                                unset($mySQL);
                            }
                        //Si no se ha pasado por buscar se hace una búsqueda de todos los registros
                        } else {
                            try {
                                if (isset($_GET['pag'])) {
                                    $pag = $_GET['pag'];
                                } else {
                                    $pag = 0;
                                }
                                //Mostrar todos los registros en una tabla
                                $sqlDepartamento = "SELECT * FROM Departamento LIMIT $pag," . 5; //Selección y mostrado de 5 por página
                                $consulta = $mySQL->query($sqlDepartamento);
                            } catch (PDOException $exc) {
                                echo "Error: $exc->getMessage() <br>";
                                echo "Codigo del error: $exc->getCode() <br>";
                            } finally {
                                unset($mySQL);
                            }
                        }
                        /*****  LISTADO *****/
                        echo '<h3>Listado de  departamentos</h3>'; 
                        echo '<table>'; //Distribución de la tabla
                            echo '<tr>';
                                echo '<th>Código</th>';
                                echo '<th>Descripción</th>';
                                echo '<th>Alta/Baja</th>';
                                echo '<th>Volumen</th>';
                                echo '<th>Mostrar</th>';
                                echo '<th>Editar</th>';
                                echo '<th>Borrar</th>';
                            echo '</tr>';
                            //Inserción de datos en cada posición    
                            while ($registro = $consulta->fetchObject()) { //Al realizar el fetchObject, se pueden sacar los datos de $registro como si fuera un objeto
                                $cod = $registro->CodDepartamento;
                                $fecha = $registro->FechaBaja;
                                if ($fecha != NULL) {
                                    echo '<tr>';
                                } else {
                                    echo '<tr>';
                                }
                                    echo "<td>" . $cod . "</td><td>" . $registro->DescDepartamento . "</td>";
                                    if ($fecha == NULL) {
                                        echo '<td><a href="bajaLogicaDepartamento.php?cod=' . $cod . '&pag=' . $pag . '"><img class="icon" src="../webroot/media/images/baja2.png"></a></td>';
                                    } else {
                                        echo '<td><a href="altaLogicaDepartamento.php?cod=' . $cod . '&pag=' . $pag . '"><img class="icon" src="../webroot/media/images/alta2.png"></a></td>';
                                    }
                                    echo "<td>" . $registro->VolumenNegocio . "</td>";
                                    echo '<td><a href="mostrarDepartamento.php?cod=' . $cod . '&pag=' . $pag . '"><img class="icon" style="width: 30px;" src="../webroot/media/images/ver2.png"></a></td>';
                                    echo '<td><a href="editarDepartamento.php?cod=' . $cod . '&pag=' . $pag . '"><img class="icon" src="../webroot/media/images/editar2.png"></a></td>';
                                    echo '<td><a href="bajaDepartamento.php?cod=' . $cod . '&pag=' . $pag . '"><img class="icon" src="../webroot/media/images/eliminar2.png"></a></td>';
                                echo '</tr>';
                            }
                        echo '</table>';
                        
                /** PAGINADO **/
                        if (!isset($_REQUEST['buscar']) || $_REQUEST['buscar']==NULL) {
                                ?>
                                <div id="paginacion" style="text-align: center;">
                                    <div style="display:inline-block;">
                                        <a href="<?php
                                        if ($pag <= 0) {
                                            echo $_SERVER['PHP_SELF'] . "?pag=0";
                                        } else {
                                            echo $_SERVER['PHP_SELF'] . "?pag=" . ($pag - 5);
                                        }
                                        ?>"><img class="icon2" src="../webroot/media/images/izq2.png"></a>
                                    </div>
                                    <div style="display:inline-block;">
                                        <a href="<?php echo $_SERVER['PHP_SELF'] . "?pag=" . ($pag + 5) ?>"><img class="icon2" src="../webroot/media/images/derch2.png"></a>
                                    </div>
                                </div>
                        <?php
                        }
                        ?>
                        </table>
                        </div>
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