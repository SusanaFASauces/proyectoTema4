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
            <h2>Ejercicio 01</h2>
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
                         * COMPLETAR EL EJERCICIO AÑADIENDO LA EXPLICACIÓN DE CADA UNO DE LOS ATRIBUTOS
                         *
                         * @author Susana Fabián Antón
                         * @since 29/10/2020
                         * @version 16/11/2020
                         */
                        require_once '../config/confDBPDO.php'; //fichero que contiene las constantes de configuración de una base de datos en PDO

                        try {
                            $miDB = new PDO(DSN, USER, PASSWORD); //instanciamos un objeto de la clase PDO para conectarnos a la base de datos
                            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //establecemos que cuando se produzca un error en el atributo ERRMODE se lanzará una excepción

                            $aAtributos = [ //array con los atributos de los que está compuesto PDO
                                "AUTOCOMMIT", 
                                "CASE",
                                "CLIENT_VERSION",
                                "CONNECTION_STATUS",
                                "DRIVER_NAME",
                                "ERRMODE",
                                "ORACLE_NULLS",
                                "PERSISTENT",
                                "SERVER_INFO",
                                "SERVER_VERSION"
                            ];

                            foreach ($aAtributos as $valor){ //recorremos el array
                                echo "<strong>PDO::ATTR_$valor: </strong>"; //mostramos el nombre del atributo
                                try { //controlamos las excepciones que puedan lanzar los atributos
                                    echo $miDB->getAttribute(constant("PDO::ATTR_$valor"))."<br>"; //mostramos el valor del atributo
                                } 
                                catch ( PDOException $ex ) {
                                    echo "<span style=color:red>".$ex->getMessage()."</span><br>"; // muestro el mensaje de error
                                }
                            }

                            echo "<p style=color:green>Conexión establecida con éxito</p>"; //mostramos un mensaje indicando que todo ha ido bien
                        }
                        catch (PDOException $ex) { // código a ejecutar cuando se produce un error 
                            echo "<p style=color:red>Error: ".$ex->getMessage()."<br>"; // muestro el mensaje de error
                            echo "Código de error: ".$ex->getCode()."</p>"; // muestro el código del error
                        }
                        finally {
                            unset($miDB); //cerramos la conexion
                        }
                    ?>
                </article>
                <article>
                    <header>
                        <h4>Conexión fallida</h4>
                    </header>
                    <?php
                        require_once '../config/confDBPDO.php'; //fichero que contiene las constantes de configuración de una base de datos en PDO

                        try {
                            $miDB = new PDO(DSN, USER, "password"); //instanciamos un objeto de la clase PDO para conectarnos a la base de datos
                            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //establecemos que cuando se produzca un error en el atributo ERRMODE se lanzará una excepción

                            $aAtributos = [ //array con los atributos de los que está compuesto PDO
                                "AUTOCOMMIT", 
                                "CASE",
                                "CLIENT_VERSION",
                                "CONNECTION_STATUS",
                                "DRIVER_NAME",
                                "ERRMODE",
                                "ORACLE_NULLS",
                                "PERSISTENT",
                                "SERVER_INFO",
                                "SERVER_VERSION"
                            ];

                            foreach ($aAtributos as $valor){ //recorremos el array
                                echo "<strong>PDO::ATTR_$valor: </strong>"; //mostramos el nombre del atributo
                                try { //controlamos las excepciones que puedan lanzar los atributos
                                    echo $miDB->getAttribute(constant("PDO::ATTR_$valor"))."<br>"; //mostramos el valor del atributo
                                } 
                                catch ( PDOException $ex ) {
                                    echo "<span style=color:red>".$ex->getMessage()."</span><br>"; // muestro el mensaje de error
                                }
                            }

                            echo "<p style=color:green>Conexión establecida con éxito</p>"; //mostramos un mensaje indicando que todo ha ido bien
                        }
                        catch (PDOException $ex) { // código a ejecutar cuando se produce un error 
                            echo "<p style=color:red>Error: ".$ex->getMessage()."<br>"; // muestro el mensaje de error
                            echo "Código de error: ".$ex->getCode()."</p>"; // muestro el código del error
                        }
                        finally {
                            unset($miDB); //cerramos la conexion
                        }
                    ?>
                </article>
            </section>
        </main>
        <footer>
            <address>Contacta conmigo en: susana.fabant@educa.jcyl.es</address>
            <p>- 16 de Noviembre 2020 -</p>
        </footer>
    </body>
</html>

