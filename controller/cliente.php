<?php
/**
 * Controlador de clientes.
 *
 * Gestiona las operaciones CRUD de clientes, además de exportar datos a CSV
 * y generar listados en PDF. En inserción y modificación se encripta la contraseña.
 *
 * @package ProyectoTienda - Controller
 */

if (session_status() === PHP_SESSION_NONE)
    session_start();

require_once("model/clientes.php");
require_once("pdfs/clientes.php");

class ClientesControlador
{
    /**
     * Muestra el listado de clientes.
     *
     * @return void
     */
    static function index()
    {
        $clientes = new ClientesModelo();
        $clientes->Seleccionar();

        require_once("view/clientes.php");
    }

    /**
     * Muestra el formulario para crear un cliente.
     *
     * @return void
     */
    static function Nuevo()
    {
        $opcion = 'NUEVO'; // Opción de insertar un cliente.
        require_once("view/clientesmantenimiento.php");
    }

    /**
     * Inserta un cliente con los datos recibidos por POST.
     * La contraseña se guarda encriptada.
     *
     * @return void
     */
    static function Insertar()
    {
        require_once("controller/crypt.php");

        $cliente = new ClientesModelo();
        $cliente->nombre = $_POST['nombre'];
        $cliente->apellidos = $_POST['apellidos'];
        $cliente->email = $_POST['email'];
        $cliente->contrasenya = Crypt::Encriptar($_POST['contrasenya']);
        $cliente->direccion = $_POST['direccion'];
        $cliente->cp = $_POST['cp'];
        $cliente->poblacion = $_POST['poblacion'];
        $cliente->provincia = $_POST['provincia'];
        $cliente->fechaNac = $_POST['fechaNac'];
        $cliente->formadepago = $_POST['formadepago'];

        if ($cliente->Insertar() == 1)
            header("location:" . URLSITE . '?c=clientes');
        else {
            $_SESSION["CRUDMVC_ERROR"] = $cliente->GetError();
            header("location:" . URLSITE . "view/error.php");
        }
    }

    /**
     * Carga un cliente por id (GET) y muestra el formulario de edición.
     *
     * @return void
     */
    static function Editar()
    {
        $cliente = new ClientesModelo();
        $cliente->id = $_GET['id'];
        $opcion = 'EDITAR'; // Opción de modificar un cliente.

        if ($cliente->seleccionar())
            require_once("view/clientesmantenimiento.php");
        else {
            $_SESSION["CRUDMVC_ERROR"] = $cliente->GetError();
            header("location:" . URLSITE . "view/error.php");
        }
    }

    /**
     * Modifica un cliente usando id (GET) y datos (POST).
     * La contraseña se vuelve a guardar encriptada.
     *
     * @return void
     */
    static function Modificar()
    {
        require_once("controller/crypt.php");

        $cliente = new ClientesModelo();

        $cliente->id = $_GET['id'];
        $cliente->nombre = $_POST['nombre'];
        $cliente->apellidos = $_POST['apellidos'];
        $cliente->email = $_POST['email'];
        $cliente->contrasenya = Crypt::Encriptar($_POST['contrasenya']);
        $cliente->direccion = $_POST['direccion'];
        $cliente->cp = $_POST['cp'];
        $cliente->poblacion = $_POST['poblacion'];
        $cliente->provincia = $_POST['provincia'];
        $cliente->fechaNac = $_POST['fechaNac'];
        $cliente->formadepago = $_POST['formadepago'];

        // Aquí hay que tener cuidado, en el caso de que se pulse el botón de aceptar
        // pero no se haya modificado nada, la función modificar devolverá un cero,
        // por eso hay que comprobar que no hay error.
        if (($cliente->Modificar() == 1) || ($cliente->GetError() == ''))
            header("location:" . URLSITE . '?c=clientes');
        else {
            $_SESSION["CRUDMVC_ERROR"] = $cliente->GetError();
            header("location:" . URLSITE . "view/error.php");
        }
    }

    /**
     * Borra un cliente por id (GET).
     *
     * @return void
     */
    static function Borrar()
    {
        $cliente = new ClientesModelo();
        $cliente->id = $_GET['id'];

        if ($cliente->Borrar() == 1)
            header("location:" . URLSITE . '?c=clientes');
        else {
            $_SESSION["CRUDMVC_ERROR"] = $cliente->GetError();
            header("location:" . URLSITE . "view/error.php");
        }
    }

    // Abrimos el fichero clientes.csv en modo escritura

    /**
     * Exporta el listado de clientes a un archivo CSV descargable.
     *
     * @return void
     */
    static function Exportar()
    {
        $clientes = new ClientesModelo();
        // Para cada fila de la tabla
        $clientes->Seleccionar();

        try {
            $fichero = fopen("clientes.csv", "w");

            foreach ($clientes->filas as $fila) {

                // creamos la linea a exportar
                $cadena = "$fila->id#$fila->nombre#$fila->apellidos\n";

                // la guardamos la linea en el fichero
                fputs($fichero, $cadena);
            }
        } finally {

            // cerramos el fichero
            fclose($fichero);
        }

        // finalmente exportamos el fichero
        $rutaFichero = 'clientes.csv';
        $fichero = basename($rutaFichero);

        header("Content-Type: application/actet-stream");
        header("Content-Length: " . filesize($rutaFichero));
        header("Content-Disposition: attachment; filename=$fichero");

        readfile($rutaFichero);
    }

    // http://localhost/mvc/?c=clientes&m=imprimir

    /**
     * Genera y muestra un PDF con el listado de clientes.
     *
     * @return void
     */
    static function Imprimir()
    {
        $clientes = new ClientesModelo();

        $clientes->Seleccionar();

        $pdf = new ClientesPDF();

        $pdf->AddPage();

        $pdf->SetFont('Arial', '', 12);

        $pdf->SetWidths(array(75, 75, 40));

        $pdf->filas = $clientes->filas;

        $pdf->Imprimir();

        $pdf->Output();
    }
}
