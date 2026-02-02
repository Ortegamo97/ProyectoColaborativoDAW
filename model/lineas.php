<?php
/**
 * Modelo de líneas
 *
 * Representa la tabla "lineas" y contiene las operaciones básicas
 * para insertar, modificar, borrar y seleccionar líneas
 *
 * @package ProyectoTienda - Model
 */

require_once("bd.php");

class LineasModelo extends BD
{
    /** @var int|null Id de la línea */
    public $id;

    /** @var int|string|null Id de la factura asociada */
    public $factura_id;

    /** @var string|null Referencia del artículo */
    public $referencia;

    /** @var string|null Descripción de la línea */
    public $descripcion;

    /** @var int|string|null Cantidad */
    public $cantidad;

    /** @var float|string|null Precio */
    public $precio;

    /** @var float|string|null IVA */
    public $iva;

    /** @var float|string|null Importe total de la línea */
    public $importe;

    /**
     * Filas obtenidas en las consultas
     *
     * @var array<int, object>|null
     */
    public $filas = null;

    /**
     * Inserta una línea en la base de datos
     *
     * @return int Número de filas afectadas
     */
    public function Insertar()
    {
        $sql = "INSERT INTO lineas VALUES" .
            " (default, '$this->factura_id', '$this->referencia', '$this->descripcion', '$this->cantidad', '$this->precio', '$this->iva', '$this->importe')";
        return $this->_ejecutar($sql);
    }

    /**
     * Selecciona líneas de la base de datos
     *
     * Si la propiedad $id tiene valor, selecciona solo esa línea
     * Si no, selecciona todas
     *
     * @return bool True si hay resultados, false si no
     */
    public function Seleccionar()
    {
        $sql = 'SELECT * FROM lineas';
        // Si me han pasado un id, obtenemos solo el registro indicado.
        if ($this->id != 0)
            $sql .= " WHERE id=$this->id";

        $this->filas = $this->_consultar($sql);

        if ($this->filas == null)
            return false;

        if ($this->id != 0) {
            // Guardamos los campos en las propiedades.
            $this->id = $this->filas[0]->id;
            $this->factura_id = $this->filas[0]->factura_id;
            $this->referencia = $this->filas[0]->referencia;
            $this->descripcion = $this->filas[0]->descripcion;
            $this->cantidad = $this->filas[0]->cantidad;
            $this->precio = $this->filas[0]->precio;
            $this->iva = $this->filas[0]->iva;
            $this->importe = $this->filas[0]->importe;
        }
        return true;
    }

    /**
     * Modifica una línea existente
     *
     * @return int Número de filas afectadas
     */
    public function Modificar()
    {
        $sql = "UPDATE lineas SET" .
            " '$this->factura_id', '$this->referencia', '$this->descripcion', '$this->cantidad', '$this->precio', '$this->iva', '$this->importe'" .
            " WHERE id=$this->id";
        return $this->_ejecutar($sql);
    }

    /**
     * Borra una línea por su id
     *
     * @return int Número de filas afectadas
     */
    public function Borrar()
    {
        $sql = "DELETE FROM lineas WHERE id=$this->id";
        return $this->_ejecutar($sql);
    }
}
