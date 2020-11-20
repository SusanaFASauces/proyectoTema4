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
                    <h3>Restablece la carga inicial de la tabla Departamento</h3>
                </header>
                <article>
                    <?php
                        /**
                         * @author Susana Fabián Antón
                         * @since 12/11/2020
                         * @version 12/11/2020
                         */
                        require_once '../config/confDBPDO.php'; //fichero que contiene las constantes de configuración de una base de datos en PDO

                        try {
                            $miDB = new PDO(DSN, USER, PASSWORD); //instanciamos un objeto de la clase PDO para conectarnos a la base de datos
                            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //establecemos que cuando se produzca un error en el atributo ERRMODE se lanzará una excepción

                            $select = $miDB->query("DELETE FROM Departamento"); //objeto de la clase PDOStatement que contiene una consulta que le hacemos a la base de datos 
                            
                            //heredoc que contiene nuestra consulta sql preparada
                            $consulta = <<< CONSULTA
                                INSERT INTO Departamento (CodDepartamento, DescDepartamento, VolumenNegocio)VALUES
                                (:codDepartamento, :descDepartamento, :volumenNegocio)
CONSULTA;
                            $insert = $miDB->prepare($consulta); //objeto de la clase PDOStatement que contiene una consulta preparada que le hacemos a la base de datos
                            $aDepartamentos = [ //array bidimiensional que información de tres departamentos
                                [":codDepartamento" => "INF", ":descDepartamento" => "Departamento de informatica", ":volumenNegocio" => 1], //arrays que utilizaremos para bindear los parámetros de la consulta preparada
                                [":codDepartamento" => "VEN", ":descDepartamento" => "Departamento de ventas", ":volumenNegocio" => 2],
                                [":codDepartamento" => "CON", ":descDepartamento" => "Departamento de contabilidad", ":volumenNegocio" => 3],
                                [":codDepartamento" => "COC", ":descDepartamento" => "Departamento de cocina", ":volumenNegocio" => 4],
                                [":codDepartamento" => "MEC", ":descDepartamento" => "Departamento de mecanica", ":volumenNegocio" => 5],
                                [":codDepartamento" => "MAT", ":descDepartamento" => "Departamento de matematicas", ":volumenNegocio" => 6]
                            ];
                            foreach($aDepartamentos as $parametros) { //recorremos el array de departamentos
                                $insert->execute($parametros); //ejecutamos la consulta
                            }
                            echo "<p style=color:green>Los resgistros de la tabla Departamento se han restablecido con éxito</p>"; //mostramos un mensaje indicando que todo ha ido bien
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
            <p>- 12 de Noviembre 2020 -</p>
        </footer>
    </body>
</html>

