<?php
/**
 * Controlador de recibos.
 *
 * Gestiona las operaciones CRUD de recibos, exportación a CSV y generación de PDF.
 * Para crear o editar recibos se cargan también las facturas (selector del formulario).
 *
 * @package ProyectoTienda - Controller
 */

if (session_status() === PHP_SESSION_NONE)
    session_start();

require_once("model/recibos.php");
require_once("pdfs/recibos.php");

class RecibosControlador
{
    /**
     * Muestra el listado de recibos.
     *
     * @return void
     */
    static function index()
    {
        $recibos = new RecibosModelo();
        $recibos->Seleccionar();

        require_once("view/recibos.php");
    }

    /**
     * Muestra el formulario para crear un recibo.
     * Carga previamente las facturas para el selector del formulario.
     *
     * @return void
     */
    static function Nuevo()
    {
        $facturas = new FacturasModelo();
        $facturas->Seleccionar();

        $opcion = 'NUEVO';
        require_once("view/recibosmantenimiento.php");
    }

    /**
     * Inserta un recibo con los datos recibidos por POST.
     *
     * @return void
     */
    static function Insertar()
    {
        $recibos = new RecibosModelo();
        $recibos->factura_id = $_POST['factura_id'];
        $recibos->fecha = $_POST['fecha'];
        $recibos->importe = $_POST['importe'];
        
        if ($recibos->Insertar() == 1)
            header("location:" . URLSITE . '?c=recibos');
        else {
            $_SESSION["CRUDMVC_ERROR"] = $recibos->GetError();
            header("location:" . URLSITE . "view/error.php");
        }
    }

    /**
     * Carga un recibo por id (GET) y muestra el formulario de edición.
     * Carga previamente las facturas para el selector del formulario.
     *
     * @return void
     */
    static function Editar()
    {
        $facturas = new FacturasModelo();
        $facturas->Seleccionar();

        $recibos = new RecibosModelo();
        $recibos->id = $_GET['id'];
        $opcion = 'EDITAR'; // Opción de modificar un cliente.
        if ($recibos->seleccionar())
            require_once("view/recibosmantenimiento.php");
        else {
            $_SESSION["CRUDMVC_ERROR"] = $cliente->GetError();
            header("location:" . URLSITE . "view/error.php");
        }
    }

    /**
     * Modifica un recibo usando id (GET) y datos (POST).
     *
     * @return void
     */
    static function Modificar()
    {
        $recibos = new RecibosModelo();

        $recibos->id = $_GET['id'];
        $recibos->factura_id = $_POST['factura_id'];
        $recibos->fecha = $_POST['fecha'];
        $recibos->importe = $_POST['importe'];

        if (($recibos->Modificar() == 1) || ($recibos->GetError() == ''))
            header("location:" . URLSITE . '?c=recibos');
        else {
            $_SESSION["CRUDMVC_ERROR"] = $recibos->GetError();
            header("location:" . URLSITE . "view/error.php");
        }
    }

    /**
     * Borra un recibo por id (GET).
     *
     * @return void
     */
    static function Borrar()
    {
        $recibos = new RecibosModelo();
        $recibos->id = $_GET['id'];
        if ($recibos->Borrar() == 1)
            header("location:" . URLSITE . '?c=recibos');
        else {
            $_SESSION["CRUDMVC_ERROR"] = $recibos->GetError();
            header("location:" . URLSITE . "view/error.php");
        }
    }

    // Abrimos el fichero clientes.csv en modo escritura

    /**
     * Exporta el listado de recibos a un archivo CSV descargable.
     *
     * @return void
     */
    static function Exportar()
    {
        $recibos = new RecibosModelo();

        $recibos->Seleccionar();

        try {
            $fichero = fopen("recibos.csv", "w");

            foreach ($recibos->filas as $fila) {

                $cadena = "$fila->id#$fila->factura#$fila->fecha#$fila->importe\n";

                fputs($fichero, $cadena);
            }
        } finally {

            fclose($fichero);
        }

        $rutaFichero = 'recibos.csv';
        $fichero = basename($rutaFichero);

        header("Content-Type: application/actet-stream");
        header("Content-Length: " . filesize($rutaFichero));
        header("Content-Disposition: attachment; filename=$fichero");

        readfile($rutaFichero);
    }

    /**
     * Genera y muestra un PDF con el listado de recibos.
     *
     * @return void
     */
    static function Imprimir()
    {
        $recibos = new RecibosModelo();
        $facturas = new FacturasModelo();
        $cliente = new ClientesModelo();

        $recibos->Seleccionar();
        $facturas->Seleccionar();
        $cliente->Seleccionar();

        $pdf = new RecibosPDF();

        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetWidths(array(40, 45, 45, 60));

        $pdf->filas = $recibos->filas;

        $pdf->Imprimir();
        $pdf->Output();
    }

    /**
     * Muestra los recibos filtrando por un id recibido por GET.
     *
     * @return void
     */
    static function Recibos()
    {
        $buscar = $_GET['id'];

        $recibos = new RecibosModelo();
        $recibos->Seleccionar($buscar);

        require_once("view/recibos.php");
    }
}
