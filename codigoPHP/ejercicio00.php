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
            <h2>Ejercicio 00</h2>
        </header>
        <main>
            <section>
                <header>
                    <h3>Borra todos los registros de la tabla Departamento</h3>
                </header>
                <article>
                    <?php
                        /**
                         * @author Susana Fabián Antón
                         * @since 13/11/2020
                         * @version 18/11/2020
                         */
                        require_once '../config/confDBPDO.php'; //fichero que contiene las constantes de configuración de una base de datos en PDO
                        
                        try {
                            $miDB = new PDO(DSN, USER, PASSWORD); //instanciamos un objeto de la clase PDO para conectarnos a la base de datos
                            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //establecemos que cuando se produzca un error en el atributo ERRMODE se lanzará una excepción
                            
                                    
                            $mysqlImportFilename ='../scriptDB/BorraTablasDAW208DBDepartamentos.sql'; //cadena que contiene el nombre del archivo sql que queremos ejecutar
                            $command='mysql -h'.HOST.' -u'.USER.' --password="'.PASSWORD.'" '.DBNAME.' < '.$mysqlImportFilename; //cadena que contiene el comando que vamos a utilizar
                            exec($command,$aOutput,$worked); //ejecutamos el comando
                            switch($worked) {
                                case 0:
                                    echo "<p style=color:green>Los registros de la tabla Departamento se han borrado con éxito</p>"; //mostramos un mensaje indicando que todo ha ido bien
                                    break;
                                case 1:
                                    echo "<p style=color:red>No han podido borrarse los registros de la tabla Departamento</p>"; //mostramos un mensaje indicando que se ha producido un error
                                    break;
                            }
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
            <p>- 18 de Noviembre 2020 -</p>
        </footer>
    </body>
</html>

