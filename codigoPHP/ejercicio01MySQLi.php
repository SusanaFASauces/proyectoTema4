<!DOCTYPE html>
<html>
    <head>
        <title>Susana Fabián Antón</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../webroot/css/estilo.css">
    </head>
    <body>
        <header>
            <h1>CFGS Desarrollo de Aplicaciones Web</h1>
            <h2>Ejercicio 01 MySQLi</h2>
        </header>
        <main>
            <section>
                <header>
                    <h3>Conexión a la base de datos con la cuenta usuario y tratamiento de errores</h3>
                </header>
                <article>
                    <header>
                        <h4>Conexión correcta</h4>
                    </header>
                    <?php
                        /**
                         * @author Susana Fabián Antón
                         * @since 18/11/2020
                         * @version 18/11/2020
                         */
                        require_once '../config/confDBMySQLi.php'; //fichero que contiene las constantes de configuración de una base de datos en PDO
                        
                        $controlador = new mysqli_driver(); //creo un objeto de la clase mysqli_driver
                        $controlador->report_mode = MYSQLI_REPORT_STRICT; //establezco que se deben lanzar excepciones cuando ocurran errores
                        
                        try {
                            $miDB = new mysqli(HOST, USER, PASSWORD, DBNAME, PORT); //instanciamos un objeto de la clase mysqli para conectarnos a la base de datos
                            
                            echo "<p style=color:green>Conexión establecida con éxito</p>"; //mostramos un mensaje indicando que todo ha ido bien
                        }
                        catch(mysqli_sql_exception $ex){
                            echo "<p style='color:red;'>No se ha podido establecer la conexión</p>";
                            echo "<p style=color:red>Error: ".$ex->getCode()."<br>"; // muestro el mensaje de error
                            echo "Código de error: ".$ex->getMessage()."</p>"; // muestro el código del error
                        }
                        finally {
                            $miDB->close(); //cerramos la conexion
                        }
                    ?>
                </article>
                <article>
                    <header>
                        <h4>Conexión fallida</h4>
                    </header>
                    <?php
                        require_once '../config/confDBMySQLi.php'; //fichero que contiene las constantes de configuración de una base de datos en PDO
                        
                        $controlador = new mysqli_driver(); //creo un objeto de la clase mysqli_driver
                        $controlador->report_mode = MYSQLI_REPORT_STRICT; //establezco que se deben lanzar excepciones cuando ocurran errores
                        
                        try {
                            $miDB = new mysqli(HOST, USER, 'paso', DBNAME, PORT); //instanciamos un objeto de la clase mysqli para conectarnos a la base de datos
                            
                            echo "<p style=color:green>Conexión establecida con éxito</p>"; //mostramos un mensaje indicando que todo ha ido bien
                        }
                        catch(mysqli_sql_exception $ex){
                            echo "<p style='color:red;'>No se ha podido establecer la conexión</p>";
                            echo "<p style=color:red>Error: ".$ex->getCode()."<br>"; // muestro el mensaje de error
                            echo "Código de error: ".$ex->getMessage()."</p>"; // muestro el código del error
                        }
                        finally {
                            $miDB->close(); //cerramos la conexion
                        }
                    ?>
                </article>
            </section>
        </main>
        <footer>
            <address>Contacta conmigo en: susana.fabant@educa.jcyl.es</address>
            <p>- 18 de Noviembre 2020 -</p>
        </footer>
    </body>
</html>

