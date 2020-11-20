<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Susana Fabián Antón</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../webroot/css/estilo.css">
    </head>
    <body>
        <header>
            <h1>CFGS Desarrollo de Aplicaciones Web</h1>
            <h2>Ejercicio 08</h2>
        </header>
        <main>
            <section>
                <header>
                    <h3>Exporta los datos de la tabla Departamento a un fichero xml</h3>
                </header>
                <article>
                    <?php
                        /**
                         * @author Susana Fabián Antón
                         * @since 17/11/2020
                         * @version 18/11/2020
                         */
                        require_once '../config/confDBPDO.php'; //fichero que contiene las constantes de configuración
                        
                        try {
                            $miDB = new PDO(DSN, USER, PASSWORD); //instanciamos un objeto de la clase 'PDO' para conectarnos a la base de datos
                            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //establecemos que cuando se produzca un error en el atributo ERRMODE se lanzará una excepción
                            
                            $xml = new DOMDocument("1.0","UTF-8"); //instanciamos objeto de la clase DOMDocument
                            $xml->formatOutput = true; //establecemos la propiedad 'formatOutput' a true para dar formato a la salida
                            $xmlDepartamentos = $xml->appendChild($xml->createElement('departamentos')); //creamos el elemento raíz 'departamentos' y lo insertamos en el documento
                            
                            $select = $miDB->query("SELECT * FROM Departamento"); //objeto de la clase PDOStatement que contiene una consulta que le hacemos a la base de datos
                            $totalRegistros = $select->rowCount(); //número de registros encontrados
                            $registrosExportados = 0; //contador de registros exportados
                            while($departamento = $select->fetch()) { //recorremos los registros de nuestra consulta
                                $xmlDepartamento = $xmlDepartamentos->appendChild($xml->createElement('departamento')); //creamos el elemeto 'departamento' hijo de 'departamentos'
                                $xmlDepartamento->appendChild($xml->createElement('codDepartamento',$departamento['CodDepartamento'])); //creamos el elemento 'codDepartamento' hijo de 'departamento'
                                $xmlDepartamento->appendChild($xml->createElement('descDepartamento',$departamento['DescDepartamento'])); //creamos el elemento 'descDepartamento' hijo de 'departamento'
                                $xmlDepartamento->appendChild($xml->createElement('fechaBaja',$departamento['FechaBaja'])); //creamos el elemento 'fechaBaja' hijo de 'departamento'
                                $xmlDepartamento->appendChild($xml->createElement('volumenNegocio',$departamento['VolumenNegocio'])); //creamos el elemento 'volumenNegocio' hijo de 'departamento'
                                $registrosExportados++;
                            }
                            $xml->save('../tmp/departamentos.xml'); //guardamos el árbol xml creado en el documento deseado
                            echo "<p style=color:green>Exportación realizada con éxito: Se han exportado $registrosExportados de $totalRegistros registros</p>"; //mostramos un mensaje indicando que todo ha ido bien
                            ?>
                            <div class="boton"><a href=descargaExportacionXML.php>Descargar XML</a></div>
                            <?php
                            }
                        catch (PDOException $ex) { // código a ejecutar cuando se produce un error 
                            echo "<p style=color:red>Error en la exportación: Se han exportado $registrosExportados de $totalRegistros registros</p>";
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
            <p>- 18 de Octubre 2020 -</p>
        </footer>
    </body>
</html>