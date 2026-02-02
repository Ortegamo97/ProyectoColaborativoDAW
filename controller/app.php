<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Controlador principal de la aplicación.
 *
 * @package ProyectoTienda - Controller
 */
class AppControlador
{
    /**
     * Carga la vista principal de la aplicación.
     *
     * @return void
     */
    public static function index(): void
    {
        require_once("view/app.php");
    }
}
