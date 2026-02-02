<?php
/**
 * Modelo de recibos
 *
 * Representa la tabla "recibos" y contiene las operaciones básicas
 * para insertar, modificar, borrar y seleccionar recibos
 *
 * @package ProyectoTienda - Model
 */

require_once("bd.php");

class recibosModelo extends BD
{
    // Campos de la tabla.

    /** @var int|null Id del recibo */
    public $id;

    /** @var int|string|null Id de la factura asociada */
    public $factura_id;

    /** @var string|null Fecha del recibo */
    public $fecha;

    /** @var float|string|null Importe del recibo */
    public $importe;

    /**
     * Filas obtenidas en las consultas
     *
     * @var array<int, object>|null
     */
    public $filas = null;

    /**
     * Inserta un recibo en la base de datos
     *
     * @return int Número de filas afectadas
     */
    public function Insertar()
    {
        $sql = "INSERT INTO recibos VALUES" .
            " (default, '$this->factura_id', '$this->fecha', '$this->importe')";
        return $this->_ejecutar($sql);
    }

    /**
     * Modifica un recibo existente
     *
     * @return int Número de filas afectadas
     */
    public function Modificar()
    {
        $sql = "UPDATE recibos SET" .
            " factura_id ='$this->factura_id', fecha = '$this->fecha' , importe ='$this->importe'" .
            " WHERE id=$this->id";
        return $this->_ejecutar($sql);
    }

    /**
     * Borra un recibo por su id
     *
     * @return int Número de filas afectadas
     */
    public function Borrar()
    {
        $sql = "DELETE FROM recibos WHERE id=$this->id";
        return $this->_ejecutar($sql);
    }

    /**
     * Selecciona recibos de la base de datos
     *
     * Si la propiedad $id tiene valor, selecciona solo ese recibo
     * Si no, selecciona todos
     *
     * @return bool True si hay resultados, false si no
     */
    public function Seleccionar()
    {
        $sql = 'SELECT * FROM recibos';
        // Si me han pasado un id, obtenemos solo el registro indicado.
        if ($this->id != 0)
            $sql .= " WHERE id=$this->id";

        $this->filas = $this->_consultar($sql);

        if ($this->filas == null)
            return false;

        if ($this->id != 0) {
            // Guardamos los campos en las propiedades.
            $this->factura_id = $this->filas[0]->factura_id;
            $this->fecha = $this->filas[0]->fecha;
            $this->importe = $this->filas[0]->importe;
        }
        return true;
    }
}
