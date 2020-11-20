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
            <h2>Ejercicio 04</h2>
        </header>
        <main>
            <section>
                <header>
                    <h3>Formulario de búsqueda de departamentos por descripción</h3>
                </header>
                <article>
                    <?php
                        /**
                         * @author Susana Fabián Antón
                         * @since 10/11/2020
                         * @version 20/11/2020
                         */
                        require_once '../config/confDBPDO.php'; //fichero que contiene las constantes de configuración de una base de datos en PDO
                        require_once '../core/201022libreriaValidacion.php'; //incluimos la librería de validaciones
                        
                        // DECLARACIÓN E INICIALIZACIÓN DE VARIABLES
                        //constantes que contienen datos que necesitan las funciones de la libreria de validacion
                        define('OBLIGATORIO', 1);
                        define('OPCIONAL', 0);
                        $entradaOK = true; //creamos una variable que indicará que el formulario está bien rellenado
                        $aErrores = [ //creamos un array para guardar los errores que surjan durante la validación
                            'descDepartamento' => null
                        ];
                        $aFormulario = [ //creamos un array para guardar los errores que surjan durante la validación
                            'descDepartamento' => null
                        ];
                        
                        if(isset($_REQUEST['enviar'])) { //si se ha pulsado enviar
                            //VALIDACIÓN DE LOS DATOS -> utilizando los métodos de la librería de validaciones
                            $aErrores['descDepartamento'] = validacionFormularios::comprobarAlfabetico($_REQUEST['descDepartamento'], 255, 0, OPCIONAL); // maximo, mínimo y obligatoriedad
                            foreach ($aErrores as $campo => $error) { //recorremos el vector en busca de errores
                                if ($error != null) { //si encontramos errores
                                    $entradaOK = false;
                                }
                            }
                        }
                        else { //si NO se ha pulsado enviar
                            $entradaOK = false;
                        }
                        
                        if ($entradaOK) { //si el formulario se ha rellenado y los datos son correctos
                            //guardamos los datos en el $aFormulario
                            $aFormulario['descDepartamento']= $_POST['descDepartamento'];
                            
                            //TRATAMIENTO DE LOS DATOS
                            try {
                                $miDB = new PDO(DSN, USER, PASSWORD); //instanciamos un objeto de la clase PDO para conectarnos a la base de datos
                                $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //establecemos que cuando se produzca un error en el atributo ERRMODE se lanzará una excepción

                                $select = $miDB->query("SELECT * FROM Departamento WHERE DescDepartamento LIKE '%{$aFormulario['descDepartamento']}%'"); //objeto de la clase PDOStatement que contiene una consulta que le hacemos a la base de datos
                                
                                if($select->rowCount()>0){ //si se han encontrado registros
                    ?>
                    <table>
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
                                    $numRegistros = $select->rowCount();
                                    echo "<p class=center style=color:green>Se han encontrado $numRegistros registros</p>"; //mostramos un mensaje indicando que todo ha ido bien
                                }
                                else { //si no
                                    echo "<p style=color:red>No se han encontrado resultados</p>"; //mostramos un mensaje de error
                                }
                    
                                
                            }
                            catch (PDOException $ex) { // código a ejecutar cuando se produce un error 
                                echo "<p style=color:red>Error: ".$ex->getMessage()."<br>"; // muestro el mensaje de error
                                echo "Código de error: ".$ex->getCode()."</p>"; // muestro el código del error
                            }
                            finally {
                                unset($miDB); //cerramos la conexion
                            }
                        }
                        else { //si NO se ha pulsado enviar o los datos enviados no son válidos
                            //mostramos el formulario
                    ?>
                    <!-- FORMULARIO -->
                    <form name="formulario" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                        <p> <!-- Descripción del departamento -->
                            <label for="lblDescDepartamento">Descripción del departamento</label>
                            <input type="text" id="lblDescDepartamento" name="descDepartamento" value="<?php
                                if (isset($_POST['descDepartamento']) && $aErrores['descDepartamento']==null) { //si se ha insertado un valor en este campo y no hay nigún error
                                    echo $_POST['descDepartamento']; //mostramos el valor
                                }
                            ?>">
                            <?php
                                if ($aErrores['descDepartamento'] != null) { //si hay un error en este campo
                                    echo "&nbsp;<span style=color:red>".$aErrores['descDepartamento']."</span>"; //mostramos el error
                                }
                            ?>
                        </p>
                        <p>
                            <input type="submit" value="Enviar" name="enviar">
                        </p>
                    </form>
                    <?php
                        }
                    ?>
                </article>
            </section>
        </main>
        <footer>
            <address>Contacta conmigo en: susana.fabant@educa.jcyl.es</address>
            <p>- 20 de Noviembre 2020 -</p>
        </footer>
    </body>
</html>