<?php
/**
 * Modelo de facturas
 *
 * Representa la tabla "facturas" y contiene las operaciones básicas
 * para insertar, modificar, borrar y seleccionar facturas
 *
 * @package ProyectoTienda - Model
 */

require_once("bd.php");

class FacturasModelo extends BD
{
    /** @var int|null Id de la factura */
    public $id;

    /** @var int|string|null Id del cliente asociado a la factura */
    public $cliente_id;

    /** @var string|null Número de la factura */
    public $numero;

    /** @var string|null Fecha de la factura */
    public $fecha;

    /**
     * Filas obtenidas en las consultas
     *
     * @var array<int, object>|null
     */
    public $filas = null;

    /**
     * Inserta una factura en la base de datos
     *
     * @return int Número de filas afectadas
     */
    public function Insertar()
    {
        $sql = "INSERT INTO facturas VALUES" .
            " (default, '$this->cliente_id', '$this->numero', '$this->fecha')";
        return $this->_ejecutar($sql);
    }

    /**
     * Selecciona facturas de la base de datos
     *
     * Si la propiedad $id tiene valor, selecciona solo esa factura
     * Si no, selecciona todas
     *
     * @return bool True si hay resultados, false si no
     */
    public function Seleccionar()
    {
        $sql = 'SELECT * FROM facturas';
        // Si me han pasado un id, obtenemos solo el registro indicado.
        if ($this->id != 0)
            $sql .= " WHERE id=$this->id";

        $this->filas = $this->_consultar($sql);

        if ($this->filas == null)
            return false;

        if ($this->id != 0) {
            // Guardamos los campos en las propiedades.
            $this->cliente_id = $this->filas[0]->cliente_id;
            $this->numero = $this->filas[0]->numero;
            $this->fecha = $this->filas[0]->fecha;
        }
        return true;
    }

    /**
     * Modifica una factura existente
     *
     * @return int Número de filas afectadas
     */
    public function Modificar()
    {
        $sql = "UPDATE facturas SET" .
            " cliente_id='$this->cliente_id', numero='$this->numero', fecha = '$this->fecha'" .
            " WHERE id=$this->id";
        return $this->_ejecutar($sql);
    }

    /**
     * Borra una factura por su id
     *
     * @return int Número de filas afectadas
     */
    public function Borrar()
    {
        $sql = "DELETE FROM facturas WHERE id=$this->id";
        return $this->_ejecutar($sql);
    }
}
