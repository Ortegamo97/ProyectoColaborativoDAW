<?php
/**
 * Modelo de clientes
 *
 * Representa la tabla "clientes" y contiene las operaciones básicas
 * para insertar, modificar, borrar y seleccionar clientes
 *
 * @package ProyectoTienda - Model
 */

require_once("bd.php");

class ClientesModelo extends BD
{
    // Campos de la tabla.

    /** @var int|null Id del cliente */
    public $id;

    /** @var string|null Nombre del cliente */
    public $nombre;

    /** @var string|null Apellidos del cliente */
    public $apellidos;

    /** @var string|null Correo electrónico del cliente */
    public $email;

    /** @var string|null Contraseña del cliente (encriptada) */
    public $contrasenya;

    /** @var string|null Dirección del cliente */
    public $direccion;

    /** @var string|null Código postal */
    public $cp;

    /** @var string|null Población */
    public $poblacion;

    /** @var string|null Provincia */
    public $provincia;

    /** @var string|null Fecha de nacimiento */
    public $fechaNac;

    /** @var string|null Forma de pago del cliente */
    public $formadepago;

    /**
     * Filas obtenidas en las consultas
     *
     * @var array<int, object>|null
     */
    public $filas = null;

    /**
     * Inserta un cliente en la base de datos
     *
     * @return int Número de filas afectadas
     */
    public function Insertar()
    {
        $sql = "INSERT INTO clientes VALUES" .
            " (default, '$this->nombre', '$this->apellidos', '$this->email', '$this->contrasenya', '$this->direccion', '$this->cp', '$this->poblacion', '$this->provincia', '$this->fechaNac, '$this->formadepago')";
        return $this->_ejecutar($sql);
    }

    /**
     * Modifica un cliente existente
     *
     * @return int Número de filas afectadas
     */
    public function Modificar()
    {
        $sql = "UPDATE clientes SET" .
            " nombre='$this->nombre', apellidos = '$this->apellidos' , email='$this->email' , contrasenya = '$this->contrasenya', direccion = '$this->direccion' , cp = '$this->cp', poblacion = '$this->poblacion', provincia = '$this->provincia', fechaNac = '$this->fechaNac', formadepago = '$this->formadepago'" .
            " WHERE id=$this->id";
        return $this->_ejecutar($sql);
    }

    /**
     * Borra un cliente por su id
     *
     * @return int Número de filas afectadas
     */
    public function Borrar()
    {
        $sql = "DELETE FROM clientes WHERE id=$this->id";
        return $this->_ejecutar($sql);
    }

    /**
     * Selecciona clientes de la base de datos
     *
     * Si la propiedad $id tiene valor, selecciona solo ese cliente
     * Si no, selecciona todos
     *
     * @return bool True si hay resultados, false si no
     */
    public function Seleccionar()
    {
        $sql = 'SELECT * FROM clientes';
        // Si me han pasado un id, obtenemos solo el registro indicado.
        if ($this->id != 0)
            $sql .= " WHERE id=$this->id";

        $this->filas = $this->_consultar($sql);

        if ($this->filas == null)
            return false;

        if ($this->id != 0) {
            // Guardamos los campos en las propiedades.
            $this->nombre = $this->filas[0]->nombre;
            $this->apellidos = $this->filas[0]->apellidos;
            $this->email = $this->filas[0]->email;
            $this->contrasenya = $this->filas[0]->contrasenya;
            $this->direccion = $this->filas[0]->direccion;
            $this->cp = $this->filas[0]->cp;
            $this->poblacion = $this->filas[0]->poblacion;
            $this->provincia = $this->filas[0]->provincia;
            $this->fechaNac = $this->filas[0]->fechaNac;
            $this->formadepago = $this->filas[0]->formadepago;
        }
        return true;
    }
}
