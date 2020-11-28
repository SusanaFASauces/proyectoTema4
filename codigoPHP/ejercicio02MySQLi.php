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
            <h2>Ejercicio 02 MySQLi</h2>
        </header>
        <main>
            <section>
                <header>
                    <h3>Mostrar el contenido de la tabla Departamento y el número de registros</h3>
                </header>
                <article>
                    <?php
                        /**
                         * @author Susana Fabián Antón
                         * @since 09/11/2020
                         * @version 10/11/2020
                         */
                        require_once '../config/confDBPDO.php'; //fichero que contiene las constantes de configuración de una base de datos en PDO
                        
                        try {
                            $miDB = new PDO(DSN, USER, PASSWORD); //instanciamos un objeto de la clase PDO para conectarnos a la base de datos
                            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //establecemos que cuando se produzca un error en el atributo ERRMODE se lanzará una excepción
                            
                            $select = $miDB->query("SELECT * FROM Departamento"); //objeto de la clase PDOStatement que contiene una consulta que le hacemos a la base de datos                            
                    ?>
                    <table class="tabla">
                        <tr>
                            <th>CodDepartamento</th>
                            <th>DescDepartamento</th>
                            <th>FechaBaja</th>
                            <th>VolumenNegocio</th>
                        </tr> 
                    <?php
                            while($departamento = $select->fetch()) { //recorremos los registros de nuestra consulta
                    ?>
                        <tr>
                            <td><?php echo $departamento['CodDepartamento'] ?></td> <!-- mostramos el valor del campo 'CodDepartamento' para este registro -->
                            <td><?php echo $departamento['DescDepartamento'] ?></td> <!-- mostramos el valor del campo 'DescDepartamento' para este registro -->
                            <td><?php echo $departamento['FechaBaja'] ?></td> <!-- mostramos el valor del campo 'FechaBaja' para este registro -->
                            <td><?php echo $departamento['VolumenNegocio'] ?></td> <!-- mostramos el valor del campo 'VolumenNegocio' para este registro -->
                        </tr>
                    <?php
                            }
                    ?>
                    </table>
                    <?php
                        $numRegistros = $select->rowCount(); //variable que contiene el número de registros que tiene nuestra consulta
                        echo "<p class=center><strong>La tabla Departamento tiene $numRegistros registros</strong></p>"; //mostramos el número de registros
                    
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
            <p>- 10 de Noviembre 2020 -</p>
        </footer>
    </body>
</html>