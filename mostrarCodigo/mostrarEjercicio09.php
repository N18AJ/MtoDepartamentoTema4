<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <meta name="author" content="Nerea Álvarez Justel">
        <title>DAW. Nerea Álvarez Justel</title>
        <!-- CSS -->
        <link href="../webroot/css/estilos.css" rel="stylesheet" type="text/css">
        <!-- Favicon -->
        <link rel="icon" href="../../../../favicon.png" type="x-icon">
        <!-- Tipografía -->
        <link href="https://fonts.googleapis.com/css?family=ZCOOL+KuaiLe" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Caveat&display=swap" rel="stylesheet">
        <style>
            div{
                font-family: 'Caveat';
                background-color: white;
            }
            #cont{
                margin-top: 15px;
                font-size: 11pt;
                margin-bottom: 15px;
            }
            h1{
                font-size: 20pt;
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
                <!-- NAV -->
                <nav class="segunda_header" id="menu">
                    <ul>
                        <a href="../../indexTema4.html"><li>Tema 4</li></a>
                    </ul>
                </nav>
                <article>
                    <header class="major">
                        <h3>Ejercicio 09</h3>
                    </header>
                    <div id="cont">
                    <?php
                    /**
                     @author: Nerea Álvarez Justel
                    @since: 02/05/2020
                    Comentarios: Mostrar Aplicación.
                    */					
                        echo"<h1>Mantenimiento Departamentos</h1>";
                            highlight_file("../codigoPHP/mtoDepartamentos.php"); //Mostrar código
                            
                        echo"<h1>Mostrar Departamento</h1>";
                            highlight_file("../codigoPHP/mostrarDepartamento.php"); //Mostrar código
                            
                        echo"<h1>editar Departamento</h1>";
                            highlight_file("../codigoPHP/editarDepartamento.php"); //Mostrar código
                            
                        echo"<h1>Borrar Departamento</h1>";
                            highlight_file("../codigoPHP/bajaDepartamento.php"); //Mostrar código    
                        
                        echo"<h1>Añadir Departamentos</h1>";
                            highlight_file("../codigoPHP/altaDepartamento.php"); //Mostrar código
                        
                        echo"<h1>Exportar Departamento</h1>";
                            highlight_file("../codigoPHP/exportarDepartamentos.php"); //Mostrar código
                            
                        echo"<h1>Importar Departamento</h1>";
                            highlight_file("../codigoPHP/importarDepartamentos.php"); //Mostrar código    
                            
                        echo"<h1>Baja Logica Departamentos</h1>";
                            highlight_file("../codigoPHP/bajaLogicaDepartamento.php"); //Mostrar código
                            
                        echo"<h1>Alta Logica Departamentos</h1>";
                            highlight_file("../codigoPHP/altaLogicaDepartamento.php"); //Mostrar código
                            	
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