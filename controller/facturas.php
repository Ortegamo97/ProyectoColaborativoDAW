<?php

/**
 * Controlador de facturas.
 *
 * Gestiona las operaciones CRUD de facturas. Para crear o editar facturas,
 * se cargan también los clientes para poder seleccionarlos en el formulario.
 *
 * @package ProyectoTienda - Controller
 */

if (session_status() === PHP_SESSION_NONE)
    session_start();

require_once("model/facturas.php");
require_once("model/clientes.php");

class FacturasControlador
{
    /**
     * Muestra el listado de facturas.
     *
     * @return void
     */
    static function index()
    {
        $facturas = new FacturasModelo();
        $facturas->Seleccionar();

        require_once("view/facturas.php");
    }

    /**
     * Muestra el formulario para crear una factura.
     * Carga previamente los clientes para el selector del formulario.
     *
     * @return void
     */
    static function Nuevo()
    {
        $clientes = new ClientesModelo();
        $clientes->Seleccionar();

        $opcion = 'NUEVO'; // Opción de insertar un cliente.
        require_once("view/facturasmantenimiento.php");
    }

    /**
     * Inserta una factura con los datos recibidos por POST.
     *
     * @return void
     */
    static function Insertar()
    {
        $facturas = new FacturasModelo();
        $facturas->cliente_id = $_POST['cliente_id'];
        $facturas->fecha = $_POST['fecha'];
        $facturas->numero = $_POST['numero'];

        if ($facturas->Insertar() == 1)
            header("location:" . URLSITE . '?c=facturas');
        else {
            $_SESSION["CRUDMVC_ERROR"] = $facturas->GetError();
            header("location:" . URLSITE . "view/error.php");
        }
    }

    /**
     * Carga una factura por id (GET) y muestra el formulario de edición.
     * Carga previamente los clientes para el selector del formulario.
     *
     * @return void
     */
    static function Editar()
    {
        $clientes = new ClientesModelo();
        $clientes->Seleccionar();

        $facturas = new FacturasModelo();
        $facturas->id = $_GET['id'];
        $opcion = 'EDITAR'; // Opción de modificar un cliente.
        if ($facturas->seleccionar())
            require_once("view/facturasmantenimiento.php");
        else {
            $_SESSION["CRUDMVC_ERROR"] = $facturas->GetError();
            header("location:" . URLSITE . "view/error.php");
        }
    }

    /**
     * Modifica una factura usando id (GET) y datos (POST).
     *
     * @return void
     */
    static function Modificar()
    {
        $facturas = new FacturasModelo();

        $facturas->id = $_GET['id'];
        $facturas->cliente_id = $_POST['cliente_id'];
        $facturas->fecha = $_POST['fecha'];
        $facturas->numero = $_POST['numero'];

        if (($facturas->Modificar() == 1) || ($facturas->GetError() == ''))
            header("location:" . URLSITE . '?c=facturas');
        else {
            $_SESSION["CRUDMVC_ERROR"] = $facturas->GetError();
            header("location:" . URLSITE . "view/error.php");
        }
    }

    /**
     * Borra una factura por id (GET).
     *
     * @return void
     */
    static function Borrar()
    {
        $facturas = new FacturasModelo();

        $facturas->id = $_GET['id'];
        if ($facturas->Borrar() == 1)
            header("location:" . URLSITE . '?c=facturas');
        else {
            $_SESSION["CRUDMVC_ERROR"] = $facturas->GetError();
            header("location:" . URLSITE . "view/error.php");
        }
    }

    /**
     * Exporta el listado de facturas a un archivo CSV descargable.
     *
     * @return void
     */
    static function Exportar()
    {
        $facturas = new FacturasModelo();
        // Para cada fila de la tabla
        $facturas->Seleccionar();

        try {
            $fichero = fopen("facturas.csv", "w");

            foreach ($facturas->filas as $fila) {

                // creamos la linea a exportar
                $cadena = "$fila->id#$fila->cliente_id#$fila->numero#$fila->fecha\n";

                // la guardamos la linea en el fichero
                fputs($fichero, $cadena);
            }
        } finally {

            // cerramos el fichero
            fclose($fichero);
        }

        // finalmente exportamos el fichero
        $rutaFichero = 'facturas.csv';
        $fichero = basename($rutaFichero);

        header("Content-Type: application/actet-stream");
        header("Content-Length: " . filesize($rutaFichero));
        header("Content-Disposition: attachment; filename=$fichero");

        readfile($rutaFichero);
    }
}
