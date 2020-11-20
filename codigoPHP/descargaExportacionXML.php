<?php
    /**
    * @author Susana Fabián Antón
    * @since 18/11/2020
    * @version 18/11/2020
    */

    header("Content-type: application/pdf"); //declaramos el tipo de archivo que se va a descargar
    header("Content-Disposition: attachment; filename=departamentos.xml"); //declaramos el nombre con el que se va a descargar
    readfile("../tmp/departamentos.xml"); //declaramos la ubicación en la que se va a guardar el archivo origial, para que lo lea en el caso de que no se consiga realizar la descarga
?>