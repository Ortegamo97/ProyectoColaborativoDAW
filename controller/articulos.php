<?php

/**
 * Controlador de artículos.
 *
 * Gestiona las operaciones CRUD de artículos y utilidades como exportar a CSV
 * o imprimir un listado en PDF.
 *
 * @package ProyectoTienda - Controller
 */

if (session_status() === PHP_SESSION_NONE)
    session_start();

require_once("model/articulos.php");
require_once("pdfs/articulos.php");

class ArticulosControlador
{
    /**
     * Muestra el listado de artículos.
     *
     * @return void
     */
    static function index()
    {
        $articulos = new ArticulosModelo();
        $articulos->Seleccionar();

        require_once("view/articulos.php");
    }

    /**
     * Muestra el formulario para crear un artículo.
     *
     * @return void
     */
    static function Nuevo()
    {
        $opcion = 'NUEVO'; // Opción de insertar un cliente.
        require_once("view/articulosmantenimiento.php");
    }

    /**
     * Inserta un artículo con los datos recibidos por POST.
     *
     * @return void
     */
    static function Insertar()
    {
        $articulos = new ArticulosModelo();

        $articulos->referencia = $_POST['referencia'];
        $articulos->descripcion = $_POST['descripcion'];
        $articulos->precio = $_POST['precio'];
        $articulos->iva = $_POST['iva'];

        if ($articulos->Insertar() == 1)
            header("location:" . URLSITE . '?c=articulos');
        else {
            $_SESSION["CRUDMVC_ERROR"] = $articulos->GetError();
            header("location:" . URLSITE . "view/error.php");
        }
    }

    /**
     * Carga un artículo por id (GET) y muestra el formulario de edición.
     *
     * @return void
     */
    static function Editar()
    {
        $articulos = new ArticulosModelo();

        $articulos->id = $_GET['id'];
        $opcion = 'EDITAR'; // Opción de modificar un cliente.
        if ($articulos->seleccionar())
            require_once("view/articulosmantenimiento.php");
        else {
            $_SESSION["CRUDMVC_ERROR"] = $articulos->GetError();
            header("location:" . URLSITE . "view/error.php");
        }
    }

    /**
     * Modifica un artículo usando id (GET) y datos (POST).
     *
     * @return void
     */
    static function Modificar()
    {
        $articulos = new ArticulosModelo();

        $articulos->id = $_GET['id'];
        $articulos->referencia = $_POST['referencia'];
        $articulos->descripcion = $_POST['descripcion'];
        $articulos->precio = $_POST['precio'];
        $articulos->iva = $_POST['iva'];

        // Aquí hay que tener cuidado, en el caso de que se pulse el botón de aceptar
        // pero no se haya modificado nada, la función modificar devolverá un cero,
        // por eso hay que comprobar que no hay error.
        if (($articulos->Modificar() == 1) || ($articulos->GetError() == ''))
            header("location:" . URLSITE . '?c=articulos');
        else {
            $_SESSION["CRUDMVC_ERROR"] = $articulos->GetError();
            header("location:" . URLSITE . "view/error.php");
        }
    }

    /**
     * Borra un artículo por id (GET).
     *
     * @return void
     */
    static function Borrar()
    {
        $articulos = new ArticulosModelo();

        $articulos->id = $_GET['id'];
        if ($articulos->Borrar() == 1)
            header("location:" . URLSITE . '?c=articulos');
        else {
            $_SESSION["CRUDMVC_ERROR"] = $articulos->GetError();
            header("location:" . URLSITE . "view/error.php");
        }
    }

    // Abrimos el fichero clientes.csv en modo escritura

    /**
     * Exporta el listado de artículos a un archivo CSV descargable.
     *
     * @return void
     */
    static function Exportar()
    {
        $articulos = new ArticulosModelo();
        // Para cada fila de la tabla
        $articulos->Seleccionar();

        try {
            $fichero = fopen("articulos.csv", "w");

            foreach ($articulos->filas as $fila) {

                // creamos la linea a exportar
                $cadena = "$fila->id#$fila->referencia#$fila->descripcion#$fila->precio#$fila->iva\n";

                // la guardamos la linea en el fichero
                fputs($fichero, $cadena);
            }
        } finally {

            // cerramos el fichero
            fclose($fichero);
        }

        // finalmente exportamos el fichero
        $rutaFichero = 'articulos.csv';
        $fichero = basename($rutaFichero);

        header("Content-Type: application/actet-stream");
        header("Content-Length: " . filesize($rutaFichero));
        header("Content-Disposition: attachment; filename=$fichero");

        readfile($rutaFichero);
    }

    // http://localhost/mvc/?c=clientes&m=imprimir

    /**
     * Genera y muestra un PDF con el listado de artículos.
     *
     * @return void
     */
    static function Imprimir()
    {
        // Creamos el modelo de articulos.
        $articulos = new ArticulosModelo();

        // Seleccionamos todos los articulos.
        $articulos->Seleccionar();

        // Creamos el PDF de articulos.
        $pdf = new ArticulosPDF();

        // Añadimos un página.
        $pdf->AddPage();

        // Indicamos el tamaño de letra.
        $pdf->SetFont('Arial', '', 12);

        // Establecemos el tamaño de cada celda.
        $pdf->SetWidths(array(75, 75, 40));

        // Pasamos la filas obtenidas.
        $pdf->filas = $articulos->filas;

        // Imprimirmos
        $pdf->Imprimir();

        // Mostramos
        $pdf->Output();
    }
}
