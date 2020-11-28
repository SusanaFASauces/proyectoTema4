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
            <h2>Ejercicio 05</h2>
        </header>
        <main>
            <section>
                <header>
                    <h3>
                        Añade tres registros a la tabla Departamento utilizando tres instrucciones insert y una transacción,
                        de tal forma que se añadan los tres registros o no se añada ninguno
                    </h3>
                </header>
                <article>
                    <header>
                        <h4>Registros insertados con éxito</h4>
                    </header>
                    <?php
                        /**
                         * @author Susana Fabián Antón
                         * @since 11/11/2020
                         * @version 28/11/2020
                         */
                        require_once '../config/confDBPDO.php'; //fichero que contiene las constantes de configuración
                        
                        try {
                            $miDB = new PDO(DSN, USER, PASSWORD); //instanciamos un objeto de la clase PDO para conectarnos a la base de datos
                            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //establecemos que cuando se produzca un error en el atributo ERRMODE se lanzará una excepción
                            
                            $miDB->beginTransaction(); //iniciamos una nueva transacción
                            //heredoc que contiene nuestra consulta sql preparada
                            $consulta = <<< CONSULTA
                                INSERT INTO Departamento (CodDepartamento, DescDepartamento, VolumenNegocio) VALUES
                                (:codDepartamento, :descDepartamento, :volumenNegocio)
CONSULTA;
                            $insert = $miDB->prepare($consulta); //objeto de la clase PDOStatement que contiene una consulta preparada que le hacemos a la base de datos
                            $aDepartamentos = [ //array que contiene información de los departamentos que vamos a añadir a nuestra base de datos
                                ["codDepartamento" => "QUI", "descDepartamento" => "Departamento de química", "volumenNegocio" => 9],
                                ["codDepartamento" => "MUS", "descDepartamento" => "Departamento de música", "volumenNegocio" => 3],
                                ["codDepartamento" => "ELE", "descDepartamento" => "Departamento de electricidad", "volumenNegocio" => 12]
                            ];
                            foreach($aDepartamentos as $departamento) { //recorremos el array de departamentos
                                $parametros = [ //array que utilizaremos para bindear los parámetros de la consulta preparada
                                    ":codDepartamento" => $departamento["codDepartamento"],
                                    ":descDepartamento" => $departamento["descDepartamento"],
                                    ":volumenNegocio" => $departamento["volumenNegocio"]
                                ];
                                $insert->execute($parametros); //ejecutamos la consulta
                            }
                            $miDB->commit(); //confirmamos la transacción
                            echo "<p style=color:green>Los resgistros se han insertado en la tabla Departamento con éxito</p>"; //mostramos un mensaje indicando que todo ha ido bien
                        }
                        catch (PDOException $ex) { // código a ejecutar cuando se produce un error 
                            $miDB->rollBack(); //cancelamos la transacción
                            echo "<p style=color:red>No se han insertado los registros</p>";
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
                        <h4>Error al insertar registros</h4>
                    </header>
                    <?php
                        require_once '../config/confDBPDO.php'; //fichero que contiene las constantes de configuración
                        
                        try {
                            $miDB = new PDO(DSN, USER, PASSWORD); //instanciamos un objeto de la clase PDO para conectarnos a la base de datos
                            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //establecemos que cuando se produzca un error en el atributo ERRMODE se lanzará una excepción
                            
                            $miDB->beginTransaction(); //iniciamos una nueva transacción
                            //heredoc que contiene nuestra consulta sql preparada
                            $consulta = <<< CONSULTA
                                INSERT INTO Departamento (CodDepartamento, DescDepartamento, VolumenNegocio) VALUES
                                (:codDepartamento, :descDepartamento, :volumenNegocio)
CONSULTA;
                            $insert = $miDB->prepare($consulta); //objeto de la clase PDOStatement que contiene una consulta preparada que le hacemos a la base de datos
                            $aParametros = [ //array que utilizaremos para bindear los parámetros de la consulta preparada
                                ["codDepartamento" => "QUI", "descDepartamento" => "Departamento de química", "volumenNegocio" => 9],
                                ["codDepartamento" => "MUS", "descDepartamento" => "Departamento de música", "volumenNegocio" => 3],
                                ["codDepartamento" => "INF", "descDepartamento" => "Departamento de electricidad", "volumenNegocio" => 12]
                            ];
                            foreach($aParametros as $parametro) { //recorremos el array de departamentos
                                $insert->execute($parametro); //ejecutamos la consulta
                            }
                            $miDB->commit(); //confirmamos la transacción
                            echo "<p style=color:green>Los resgistros se han insertado en la tabla Departamento con éxito.</p>"; //mostramos un mensaje indicando que todo ha ido bien
                        }
                        catch (PDOException $ex) { // código a ejecutar cuando se produce un error 
                            $miDB->rollBack(); //cancelamos la transacción
                            echo "<p style=color:red>No se han insertado los registros</p>";
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
            <p>- 28 de Noviembre 2020 -</p>
        </footer>
    </body>
</html>