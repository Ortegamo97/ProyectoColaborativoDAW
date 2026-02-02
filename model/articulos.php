<?php
/**
 * Modelo de artículos
 *
 * Representa la tabla "articulos" y contiene las operaciones básicas
 * para insertar, modificar, borrar y seleccionar artículos
 *
 * @package ProyectoTienda - Model
 */

require_once("bd.php");

class ArticulosModelo extends BD
{
    /**
     * Campos de la tabla.
     */

    /** @var int|null Id del artículo */
    public $id;

    /** @var string|null Referencia del artículo */
    public $referencia;

    /** @var string|null Descripción del artículo */
    public $descripcion;

    /** @var float|string|null Precio del artículo */
    public $precio;

    /** @var float|string|null IVA del artículo */
    public $iva;

    /**
     * Listado de filas obtenido en las consultas
     *
     * @var array<int, object>|null
     */
    public $filas = null;

    /**
     * Inserta un artículo en la base de datos.
     *
     * @return int Resultado de la ejecución (normalmente 1 si va bien).
     */
    public function Insertar()
    {
        $sql = "INSERT INTO articulos VALUES" .
            " (default, '$this->referencia', '$this->descripcion', '$this->precio', '$this->iva')";
        return $this->_ejecutar($sql);
    }

    /**
     * Modifica un artículo existente.
     *
     * @return int Resultado de la ejecución (normalmente 1 si va bien).
     */
    public function Modificar()
    {
        $sql = "UPDATE articulos SET" .
            " referencia ='$this->referencia', descripcion = '$this->descripcion' , precio ='$this->precio' , iva = '$this->iva'" .
            " WHERE id=$this->id";
        return $this->_ejecutar($sql);
    }

    /**
     * Borra un artículo por su id.
     *
     * @return int Resultado de la ejecución (normalmente 1 si va bien).
     */
    public function Borrar()
    {
        $sql = "DELETE FROM articulos WHERE id=$this->id";
        return $this->_ejecutar($sql);
    }

    /**
     * Selecciona artículos de la base de datos.
     *
     * Si la propiedad $id tiene valor, selecciona solo ese artículo.
     * Si no, selecciona todos.
     *
     * @return bool True si la consulta devuelve resultados, false si no.
     */
    public function Seleccionar()
    {
        $sql = 'SELECT * FROM articulos';
        // Si me han pasado un id, obtenemos solo el registro indicado.
        if ($this->id != 0)
            $sql .= " WHERE id=$this->id";

        $this->filas = $this->_consultar($sql);

        if ($this->filas == null)
            return false;

        if ($this->id != 0) {
            // Guardamos los campos en las propiedades.
            $this->referencia = $this->filas[0]->referencia;
            $this->descripcion = $this->filas[0]->descripcion;
            $this->precio = $this->filas[0]->precio;
            $this->iva = $this->filas[0]->iva;
        }
        return true;
    }
}
