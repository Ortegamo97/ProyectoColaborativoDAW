<?php

/**
 * Controlador de líneas.
 *
 * Gestiona el listado y la inserción de líneas (por ejemplo, líneas de factura).
 * En la pantalla de alta se cargan también los artículos para mostrarlos en un
 * desplegable (dropdown).
 *
 * @package ProyectoTienda - Controller
 */

if (session_status() === PHP_SESSION_NONE)
    session_start();

require_once("model/lineas.php");

class LineasControlador
{
    /**
     * Muestra el listado de líneas.
     *
     * @return void
     */
    static function index()
    {
        $lineas = new LineasModelo();
        $lineas->Seleccionar();

        require_once("view/lineas.php");
    }

    /**
     * Muestra el formulario para crear una nueva línea.
     * También carga artículos para el dropdown del formulario.
     *
     * @return void
     */
    static function Nuevo()
    {
        $lineas = new LineasModelo();
        $lineas->Seleccionar();

        $articulos = new ArticulosModelo(); // para el dropdown es importante crear y seleccionar lo que quieres exponer
        $articulos->Seleccionar();

        $opcion = 'NUEVO'; // Opción de insertar un cliente.
        require_once("view/lineasmantenimiento.php");
    }

    /**
     * Inserta una línea con los datos recibidos por POST.
     *
     * @return void
     */
    static function Insertar()
    {
        $lineas = new LineasModelo();

        $lineas->referencia = $_POST['referencia'];
        $lineas->descripcion = $_POST['descripcion'];
        $lineas->cantidad = $_POST['cantidad'];
        $lineas->precio = $_POST['precio'];
        $lineas->iva = $_POST['iva'];
        $lineas->importe = $_POST['importe'];

        if ($lineas->Insertar() == 1)
            header("location:" . URLSITE . '?c=lineas');
        else {
            $_SESSION["CRUDMVC_ERROR"] = $lineas->GetError();
            header("location:" . URLSITE . "view/error.php");
        }
    }
}
