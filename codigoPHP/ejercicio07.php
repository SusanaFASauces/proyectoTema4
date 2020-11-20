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
            <h2>Ejercicio 07</h2>
        </header>
        <main>
            <section>
                <header>
                    <h3>Importa datos de un fichero xml a la tabla Departamento de nuestra base de datos</h3>
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
                            $miDB = new PDO(DSN, USER, PASSWORD); //instanciamos un objeto de la clase PDO para conectarnos a la base de datos
                            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //establecemos que cuando se produzca un error en el atributo ERRMODE se lanzará una excepción
                            
                            //heredoc que contiene nuestra consulta sql preparada
                            $consulta = <<< CONSULTA
                                INSERT INTO Departamento (CodDepartamento, DescDepartamento, FechaBaja, VolumenNegocio) VALUES
                                (:codDepartamento, :descDepartamento, :fechaBaja, :volumenNegocio)
CONSULTA;
                            $insert = $miDB->prepare($consulta); //objeto de la clase PDOStatement que contiene una consulta preparada que le hacemos a la base de datos
                            
                            $xml = new DOMDocument('1.0','UTF-8'); //instanciamos objeto de la clase DOMDocument
                            $xml->load('../tmp/departamentos.xml'); //cargamos el documento xml que queremos importar
                            
                            $totalRegistros = $xml->getElementsByTagName('departamento')->count(); //número de departamentos que hay en el archivo importado
                            $registrosImportados = 0; //contador de registros importados
                            $registrosDuplicados = 0; //contador de registros duplicados
                            for($departamento=0; $departamento<$totalRegistros; $departamento++){ //recorremos los departamentos del archivo importado
                                try {
                                    $codDepartamento = $xml->getElementsByTagName("codDepartamento")->item($departamento)->nodeValue;
                                    $descDepartamento = $xml->getElementsByTagName("descDepartamento")->item($departamento)->nodeValue;
                                    $fechaBaja = $xml->getElementsByTagName("fechaBaja")->item($departamento)->nodeValue;
                                    if(empty($fechaBaja)){ //si el elemento está vacío
                                        $fechaBaja = null; //le asignamos el valor de null
                                    }
                                    $volmenNegocio = $xml->getElementsByTagName("volumenNegocio")->item($departamento)->nodeValue;
                                    $aParametros = [ //array que utilizaremos para bindear los parámetros de la consulta preparada
                                        "codDepartamento" => $codDepartamento,
                                        "descDepartamento" => $descDepartamento,
                                        "fechaBaja" => $fechaBaja,
                                        "volumenNegocio" => $volmenNegocio
                                    ];
                                    $insert->execute($aParametros);
                                    $registrosImportados++;
                                }
                                catch(PDOException $exDepartamento) {
                                    if($exDepartamento->getCode()==23000) {
                                        $registrosDuplicados++;
                                    }
                                    else {
                                        echo "<p style=color:red>Error: ".$exDepartamento->getMessage()."<br>"; // muestro el mensaje de error
                                        echo "Código de error: ".$exDepartamento->getCode()."</p>"; // muestro el código del error
                                    }      
                                }
                            }
                            
                            echo "<p style=color:green>Se han importado $registrosImportados de $totalRegistros registros.</p>"; //mostramos un mensaje indicando que todo ha ido bien
                            if($registrosDuplicados!=0) {
                                echo "<p style=color:red>Error: Se han intentado importar $registrosDuplicados registros duplicados.</p>";
                            }
                        }
                        catch(PDOException $ex) { // código a ejecutar cuando se produce un error 
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