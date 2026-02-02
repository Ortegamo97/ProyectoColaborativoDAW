<?php
/**
 * Front controller del proyecto
 *
 * Este archivo actúa como punto de entrada de la aplicación
 * En función de los parámetros GET:
 * - c indica el controlador
 * - m indica el método del controlador
 * Si no se indica nada, se carga la página principal
 *
 * @package ProyectoTienda - Index
 */

if (session_status() === PHP_SESSION_NONE)
    session_start();
require_once("config.php");
require_once("controller/app.php");
require_once("controller/cliente.php");
require_once("controller/facturas.php");
require_once("controller/lineas.php");
require_once("controller/articulos.php");
require_once("controller/recibos.php");
$controlador = '';
if (isset($_GET['c'])) :
    $controlador = $_GET['c'];
    $metodo = '';
    if (isset($_GET['m']))
        $metodo = $_GET['m'];
    switch ($controlador):
        case 'clientes':
            if (method_exists('ClientesControlador', $metodo)) :
                ClientesControlador::{$metodo}();
            else:
                ClientesControlador::index();
            endif;
            break;

        case 'facturas':
            if (method_exists('FacturasControlador', $metodo)) :
                FacturasControlador::{$metodo}();
            else:
                FacturasControlador::index();
            endif;
            break;
        case 'lineas':
            if (method_exists('LineasControlador', $metodo)) :
                LineasControlador::{$metodo}();
            else:
                LineasControlador::index();
            endif;
            break;
        case 'articulos':
            if (method_exists('ArticulosControlador', $metodo)) :
                ArticulosControlador::{$metodo}();
            else:
                ArticulosControlador::index();
            endif;
            break;
        case 'recibos':
            if (method_exists('RecibosControlador', $metodo)) :
                RecibosControlador::{$metodo}();
            else:
                RecibosControlador::index();
            endif;
            break;

        default:
            AppControlador::index();
    endswitch;
else :
    AppControlador::index();
endif;