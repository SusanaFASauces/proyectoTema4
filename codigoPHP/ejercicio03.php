<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Susana Fabián Antón</title>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../webroot/css/estilo.css">
    </head>
    <body>
        <header>
            <h1>CFGS Desarrollo de Aplicaciones Web</h1>
            <h2>Ejercicio 03</h2>
        </header>
        <main>
            <section>
                <header>
                    <h3>Formulario para añadir un departamento a la tabla Departamento con validación de entrada y control de errores</h3>
                </header>
                <article>
                    <?php
                        /**
                         * COMPLETAR PIDIENDO AL USUARIO QUE ESCRIBA EL CÓDIGO DE DEPARTAMENTO EN MAYÚSCULAS. AÑADIR MAX Y MIN FLOAT
                         * 
                         * @author Susana Fabián Antón
                         * @since 10/11/2020
                         * @version 11/11/2020
                         */
                        require_once '../config/confDBPDO.php'; //fichero que contiene las constantes de configuración de una base de datos en PDO
                        require_once '../core/201022libreriaValidacion.php'; //incluimos la librería de validaciones
                        
                        // DECLARACIÓN E INICIALIZACIÓN DE VARIABLES
                        //constantes que contienen datos que necesitan las funciones de la libreria de validacion
                        define('OBLIGATORIO', 1);
                        define('OPCIONAL', 0);
                        $entradaOK = true; //creamos una variable que indicará que el formulario está bien rellenado
                        $aErrores = [ //creamos un array para guardar los errores que surjan durante la validación
                            'codDepartamento' => null,
                            'descDepartamento' => null,
                            'volumenNegocio' => null
                        ];
                        $aFormulario = [ //creamos un array para guardar los errores que surjan durante la validación
                            'codDepartamento' => null,
                            'descDepartamento' => null,
                            'volumenNegocio' => null
                        ];
                        
                        if(isset($_REQUEST['enviar'])) { //si se ha pulsado enviar
                            //VALIDACIÓN DE LOS DATOS -> utilizando los métodos de la librería de validaciones
                            $aErrores['codDepartamento'] = validacionFormularios::comprobarAlfabetico($_REQUEST['codDepartamento'], 3, 3, OBLIGATORIO); // maximo, mínimo y obligatoriedad
                            $aErrores['descDepartamento'] = validacionFormularios::comprobarAlfabetico($_REQUEST['descDepartamento'], 255, 1, OBLIGATORIO); // maximo, mínimo y obligatoriedad
                            $aErrores['volumenNegocio'] = validacionFormularios::comprobarFloat($_POST['volumenNegocio'], PHP_FLOAT_MAX, -PHP_FLOAT_MAX, OBLIGATORIO); // maximo, mínimo y obligatoriedad
                            
                            //comprobamos que el código de departamento introducido no exista ya en la tabla Departamento
                            try{ 
                                $miDB = new PDO(DSN, USER, PASSWORD); //instanciamos un objeto de la clase PDO para conectarnos a la base de datos
                                $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //establecemos que cuando se produzca un error en el atributo ERRMODE se lanzará una excepción
                                
                                $consulta = <<< CONSULTA
                                        SELECT CodDepartamento from Departamento where CodDepartamento="{$_REQUEST['codDepartamento']}";
CONSULTA;
                                $select = $miDB->query($consulta); //objeto de la clase PDOStatement que contiene una consulta que le hacemos a la base de datos
                                if($select->rowCount() > 0){ //si el número de registros en mayor de 0
                                    $aErrores['codDepartamento'] = "El código de departamento ya existe."; //avisamos de que el código del departamento ya existe
                                }
                            }
                            catch(PDOException $excepcion){
                                $errorExcepcion = $excepcion->getCode();//Almacenamos el código del error de la excepción en la variable $errorExcepcion
                                $mensajeExcepcion = $excepcion->getMessage();//Almacenamos el mensaje de la excepción en la variable $mensajeExcepcion

                                echo "<span style='color: red;'>Error: </span>".$mensajeExcepcion."<br>";//Mostramos el mensaje de la excepción
                                echo "<span style='color: red;'>Código del error: </span>".$errorExcepcion;//Mostramos el código de la excepción
                            }
                            finally {
                               unset($miDB); 
                            }
                            
                            
                            
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
                            $aFormulario['codDepartamento']= $_POST['codDepartamento'];
                            $aFormulario['descDepartamento']= $_POST['descDepartamento'];
                            $aFormulario['volumenNegocio']= $_POST['volumenNegocio'];
                            
                            //TRATAMIENTO DE LOS DATOS
                            try {
                                $miDB = new PDO(DSN, USER, PASSWORD); //instanciamos un objeto de la clase PDO para conectarnos a la base de datos
                                $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //establecemos que cuando se produzca un error en el atributo ERRMODE se lanzará una excepción
                                
                                $insert = $miDB->prepare("INSERT INTO Departamento VALUES (:codDepartamento, :descDepartamento, :fechaBaja, :volumenNegocio);"); //objeto de la clase PDOStatement que contiene una consulta preparada que le hacemos a la base de datos
                                $aParametros = [ //array que utilizaremos para bindear los parámetros de la consulta preparada
                                    ":codDepartamento" => $aFormulario['codDepartamento'],
                                    ":descDepartamento" => $aFormulario['descDepartamento'],
                                    ":fechaBaja" => null,
                                    ":volumenNegocio" => $aFormulario['volumenNegocio']
                                ];

                                $num = $insert->execute($aParametros); //ejecutamos la consulta
                                echo "<p style=color:green>El resgistro se ha insertado en la tabla Departamento con éxito.</p>"; //mostramos un mensaje indicando que todo ha ido bien
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
                        <p> <!-- Código del departamento -->
                            <label for="lblCodDepartamento">Código del departamento</label>
                            <input type="text" id="lblCodDepartamento" name="codDepartamento" value="<?php
                                if (isset($_POST['codDepartamento']) && $aErrores['codDepartamento']==null) { //si se ha insertado un valor en este campo y no hay nigún error
                                    echo $_POST['codDepartamento']; //mostramos el valor
                                }
                            ?>">
                            <?php
                                if ($aErrores['codDepartamento'] != null) { //si hay un error en este campo
                                    echo "&nbsp;<span style=color:red>".$aErrores['codDepartamento']."</span>"; //mostramos el error
                                }
                            ?>
                        </p>
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
                        <p> <!-- Volumen de negocio -->
                            <label for="lblVolumenNegocio">Volumen de negocio</label>
                            <input type="text" id="lblVolumenNegocio" name="volumenNegocio" value="<?php
                                if (isset($_POST['volumenNegocio']) && $aErrores['volumenNegocio']==null) { //si se ha insertado un valor en este campo y no hay nigún error
                                    echo $_POST['volumenNegocio']; //mostramos el valor
                                }
                            ?>">
                            <?php
                                if ($aErrores['volumenNegocio'] != null) { //si hay un error en este campo
                                    echo "&nbsp;<span style=color:red>".$aErrores['volumenNegocio']."</span>"; //mostramos el error
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
            <p>- 11 de Noviembre 2020 -</p>
        </footer>
    </body>
</html>